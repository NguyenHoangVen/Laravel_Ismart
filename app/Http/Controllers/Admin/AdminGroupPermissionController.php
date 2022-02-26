<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupPermission;
use Illuminate\Http\Request;

class AdminGroupPermissionController extends Controller {
    //
    function list() {
        if ($this->authorize('xem-nhom-quyen')) {
            $groupPermissions = GroupPermission::latest()->paginate(5);
            return view('admin.groupPermission.list', compact('groupPermissions'));
        }
    }

    function store(Request $request) {
        $request->validate(
            [
                'name' => 'required|min:5|unique:group_permissions',
                'description' => 'required|min:5'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute phải chứa ít nhất :min ký tự',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'name' => 'Tên nhóm quyền',
                'description' => 'Mô tả'
            ]
        );

        $dataInsert = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        GroupPermission::create($dataInsert);
        return back()->with('status', 'Bạn đã thêm nhóm quyền thành công');
    }

    function delete($id) {
        GroupPermission::find($id)->delete();
        return back()->with('status', 'Bạn đã xóa bản ghi thành công');
    }
}
