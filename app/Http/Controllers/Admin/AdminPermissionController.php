<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPermissionController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }

    function list()
    {
        if ($this->authorize('xem-quyen')) {
            $groupPermissions = GroupPermission::get();
            $permissions = Permission::latest()->paginate(5);
            return view('admin.permission.list', compact('groupPermissions', 'permissions'));
        }
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:5|unique:group_permissions',
                'description' => 'required|min:5',
                'group_permission_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute phải chứa ít nhất :min ký tự',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'name' => 'Tên nhóm quyền',
                'description' => 'Mô tả',
                'group_permission_id' => 'Nhóm quyền'
            ]
        );

        $dataInsert = [
            'display_name' => $request->name,
            'name' => Str::slug($request->name),
            'description' => $request->description,
            'group_permission_id' => $request->input('group_permission_id')
        ];

        Permission::create($dataInsert);
        return back()->with('status', 'Bạn đã thêm quyền mới thành công');
    }

    function delete($id)
    {
        Permission::find($id)->delete();
        return back()->with('status', 'Bạn đã xóa quyền này thành công');
    }
}
