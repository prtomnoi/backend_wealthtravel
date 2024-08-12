<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $data = Models\Service::orderByDesc('id')->paginate(10);
        return view('admin.service.index', compact('data'));
    }

    public function show(Request $request, $id)
    {
    }

    public function create(Request $request)
    {
        $serviceType = Models\ServiceType::all();
        $config_lang = $this->lang();
        return view('admin.service.create', compact('serviceType', 'config_lang'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('service', $file_name, 'local_public');
            } else {
                $file_name = null;
            }
            $main = new Models\Service();
            $datalange = $request->input('datalange');
            foreach ($this->lang() as $key => $value) {
                $title[$value] = $datalange[$value]['title'] ?? null;
                $sub_desc[$value] = $datalange[$value]['sub_desc'] ?? null;
                $desc[$value] = $datalange[$value]['desc'] ?? null;
            }
            $main->title = $title;
            $main->sub_desc = $sub_desc;
            $main->desc = $desc;
            $main->image = $file_name;
            $main->date = $request->input('date', now());
            $main->status = $request->input('status', 'ACTIVE');
            $main->service_type_id = $request->input('type');
            $main->save();
            DB::commit();
            return redirect()->route('service.index')->with('success', 'Insert value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot insert value.', $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $main = Models\Service::find($id);
        $serviceType = Models\ServiceType::all();
        $config_lang = $this->lang();
        return view('admin.service.edit', compact('main', 'serviceType', 'config_lang'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $main = Models\Service::find($id);
            if ($request->hasFile('image')) {
                if ($main->image) {
                    File::delete(public_path('app/service/') . $main->image);
                }
                $file = $request->file('image');
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('service', $file_name, 'local_public');
            } else {
                $file_name = $main->image;
            }
            $datalange = $request->input('datalange');
            foreach ($this->lang() as $key => $value) {
                $title[$value] = $datalange[$value]['title'] ?? null;
                $sub_desc[$value] = $datalange[$value]['sub_desc'] ?? null;
                $desc[$value] = $datalange[$value]['desc'] ?? null;
            }
            $main->title = $title;
            $main->sub_desc = $sub_desc;
            $main->desc = $desc;
            $main->image = $file_name;
            $main->date = $request->input('date', now());
            $main->status = $request->input('status', 'ACTIVE');
            $main->service_type_id = $request->input('type', $main->service_type_id);
            $main->save();
            // $main->update($validate);
            DB::commit();
            return redirect()->route('service.index')->with('success', 'Update value success.');
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
            $main = Models\Service::find($id);
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
