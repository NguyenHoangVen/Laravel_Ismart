<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller {
    //
    function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }

    function list(Request $request) {
        if ($this->authorize('xem-vai-tro')) {
            $kw = "";
            if (!empty($request->kw)) {
                $kw = $request->kw;
            }
            $roles = Role::where('name', 'like', "%{$kw}%")->latest()->paginate(5);
            return view('admin.role.list', compact('roles'));
        }
    }

    function add() {
        if ($this->authorize('them-vai-tro')) {
            $groupPermission = GroupPermission::get();
            return view('admin.role.add', compact('groupPermission'));
        }
    }

    function postAdd(Request $request) {
        $request->validate([
            'name' => 'required|unique:roles',
            'description' => 'required',
            'permission_id' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã bị trùng trong hệ thống'
        ], [
            'name' => 'Tên vai trò',
            'description' => 'Miêu tả',
            'permission_id' => 'Quyền không được để trống'
        ]);

        try {
            DB::beginTransaction();

            $dataRole = [
                'name' => $request->name,
                'description' => $request->description,
            ];

            $role = Role::create($dataRole);

            $role->permissions()->attach($request->permission_id);

            DB::commit();

            return redirect()->route('role.list')->with('status', 'Bạn đã thêm vai trò thành công');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    function getUpdate($id) {
        if ($this->authorize('sua-vai-tro')) {
            $groupPermissions = GroupPermission::get();
            $role = Role::find($id);
            $permissionsChecked = $role->permissions;
            return view('admin.role.update', compact('role', 'permissionsChecked', 'groupPermissions'));
        }
    }

    function postUpdate($id, Request $request) {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id . ',id',
            'description' => 'required',
            'permission_id' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã bị trùng trong hệ thống'
        ], [
            'name' => 'Tên vai trò',
            'description' => 'Miêu tả',
            'permission_id' => 'Quyền không được để trống'
        ]);

        try {
            DB::beginTransaction();

            Role::find($id)->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            $role = Role::find($id);

            $role->permissions()->sync($request->permission_id);

            DB::commit();

            return redirect()->route('role.list')->with('status', 'Bạn đã cập nhật vai trò thành công');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    function delete($id) {
        if ($this->authorize('xoa-vai-tro')) {
            Role::find($id)->delete();
            return redirect()->route('role.list')->with('status', 'Bạn đã xóa vai trò thành công');
        }
    }
}
