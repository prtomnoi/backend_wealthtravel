<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $data = Models\Role::where('name', '!=', 'SUPER_ADMIN')
        ->paginate(10);
        return view('superAdmin.permissions.index', compact('data'));
    }

    public function show(Request $request, $id)
    {
    }

    public function create(Request $request)
    {
        $role = Models\Role::all();
        return view('pages.superAdmin.permission.create', compact('role'));
    }

    public function edit(Request $request, $id)
    {
        $role = Models\Role::where('id', $id)->first();
        $permission = Models\Permission::where('role_id', $id)
            ->orderBy('group')
            ->orderBy('table_name')
            ->get();
        return view('superAdmin.permissions.edit', compact('role', 'permission'));
    }

    public function update(Request $request, $id)
    {
        $id = $request->has('id') ? $request->input('id', []) : [];
        $view = $request->has('view') ? $request->input('view', []) : [];
        $create = $request->has('create') ? $request->input('create', []) : [];
        $update = $request->has('update') ? $request->input('update', []) : [];
        $delete =  $request->has('delete') ? $request->input('delete', []) : [];
        try {
            DB::beginTransaction();
            foreach ($id as $key => $item) {
                $permission = Models\Permission::where('id', $item)->first();
                if ($permission) {
                    $permission->update([
                        'view' => $view[$key] ?? 0,
                        'create' => $create[$key] ?? 0,
                        'update' => $update[$key] ?? 0,
                        'delete' => $delete[$key] ?? 0,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('permission.index')->with('success', 'Update value success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Cannot update value.', $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
    }
}
