<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Support\Facades\DB;

class ProductTypeController extends Controller
{
    public function index(Request $request)
    {
        $data = Models\ProductType::orderByDesc('id')->paginate(10);
        return view('admin.productType.index', compact('data'));
    }

    public function show(Request $request, $id)
    {
    }

    public function create(Request $request)
    {
        $config_lang = $this->lang();
        return view('admin.productType.create', compact('config_lang'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $main = new Models\ProductType();
            $datalange = $request->input('datalange');
            foreach ($this->lang() as $key => $value) {
                $name[$value] = $datalange[$value]['name'] ?? null;
            }
            $main->name = $name;
            $main->status = $request->input('status', 'ACTIVE');
            $main->save();
            DB::commit();
            return redirect()->route('productType.index')->with('success', 'Insert value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot insert value.', $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $main = Models\ProductType::find($id);
        $config_lang = $this->lang();
        return view('admin.productType.edit', compact('main', 'config_lang'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $main = Models\ProductType::find($id);
            $datalange = $request->input('datalange');
            foreach ($this->lang() as $key => $value) {
                $name[$value] = $datalange[$value]['name'] ?? null;
            }
            $main->name = $name;
            $main->status = $request->input('status', $main->status);
            $main->save();
            // $main->update($validate);
            DB::commit();
            return redirect()->route('productType.index')->with('success', 'Update value success.');
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
            $main = Models\ProductType::find($id);
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
