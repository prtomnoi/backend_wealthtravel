<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = Models\Product::orderByDesc('id')->paginate(10);
        return view('admin.product.index', compact('data'));
    }

    public function show(Request $request, $id)
    {
    }

    public function create(Request $request)
    {
        $productType = Models\ProductType::all();
        $config_lang = $this->lang();
        return view('admin.product.create', compact('productType', 'config_lang'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'type' => ['required'],
        ]);
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('product', $file_name, 'local_public');
            } else {
                $file_name = null;
            }
            $main = new Models\Product();
            $datalange = $request->input('datalange');
            foreach ($this->lang() as $key => $value) {
                $name[$value] = $datalange[$value]['name'] ?? null;
            }
            $main->name = $name;
            $main->price = $this->getAmount($request->input('price', 0));
            $main->star = $request->input('star', '0');
            $main->price_sale = $this->getAmount($request->input('price_sale', 0));
            $main->image = $file_name ?? null;
            $main->status = $request->input('status', 'ACTIVE');
            $main->product_type_id = $request->input('type');
            $main->save();
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Insert value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot insert value.', $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $main = Models\Product::find($id);
        $productType = Models\ProductType::all();
        $config_lang = $this->lang();
        return view('admin.product.edit', compact('main', 'productType', 'config_lang'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'type' => ['required'],
        ]);
        try {
            DB::beginTransaction();
            $main = Models\Product::find($id);
            if ($request->hasFile('image')) {
                if ($main->image) {
                    File::delete(public_path('app/product/') . $main->image);
                }
                $file = $request->file('image');
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('product', $file_name, 'local_public');
            } else {
                $file_name = $main->image;
            }
            $datalange = $request->input('datalange');
            foreach ($this->lang() as $key => $value) {
                $name[$value] = $datalange[$value]['name'] ?? null;
            }
            $main->name = $name;
            $main->price = $this->getAmount($request->input('price', $main->price));
            $main->star = $request->input('star', $main->star);
            $main->price_sale = $this->getAmount($request->input('price_sale', $main->price_sale));
            $main->image = $file_name;
            $main->status = $request->input('status', $main->status);
            $main->product_type_id = $request->input('type', $main->product_type_id);
            $main->save();
            // $main->update($validate);
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Update value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot update value.', $e->getMessage()]);
        }
    }

    public function destroy(Request $request,$id)
    {
        // $validate = $request->validate([
        //     'status' => "sometimes",
        // ]);
        try {
            DB::beginTransaction();
            $main = Models\Product::find($id);
            // $main->update($validate);
            $main->delete();
            DB::commit();
            $res = [
                'code' => 200,
                'message' => 'Delete value success.',
                'error' => null,
            ];
            return response()->json($res);
        } catch (\Exception $e) {
            DB::rollBack();
            $res = [
                'code' => 200,
                'message' => 'Cannot delete value.',
                'error' => $e->getMessage(),
            ];
            return response()->json($res);
        }
    }
}
