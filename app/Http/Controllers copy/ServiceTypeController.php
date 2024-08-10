<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Support\Facades\DB;

class ServiceTypeController extends Controller
{
    public function index(Request $request)
    {
        $data = Models\ServiceType::orderByDesc('id')->paginate(10);
        return view('admin.serviceType.index', compact('data'));
    }

    public function show(Request $request, $id)
    {
    }

    public function create(Request $request)
    {
        return view('admin.serviceType.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'status' => ['sometimes'],
            'lange' => ['sometimes'],
        ]);
        try {
            DB::beginTransaction();
            $main = new Models\ServiceType();
            $main->setTranslation('name', $request->input('lange', 'en'), $validate['name']);
            $main->status = $request->input('status', 'ACTIVE');
            $main->save();
            DB::commit();
            return redirect()->route('serviceType.index')->with('success', 'Insert value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot insert value.', $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $main = Models\ServiceType::find($id);
        return view('admin.serviceType.edit', compact('main'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['sometimes'],
            'status' => ['sometimes'],
        ]);
        try {
            DB::beginTransaction();
            $main = Models\ServiceType::find($id);
            $main->setTranslation('name', $request->input('lange', 'en'), $request->input('name', ''));
            $main->status = $request->input('status', $main->status);
            $main->save();
            // $main->update($validate);
            DB::commit();
            return redirect()->route('serviceType.index')->with('success', 'Update value success.');
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
            $main = Models\ServiceType::find($id);
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
