<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller {
    //
    function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    function list(Request $request) {
        
        if ($this->authorize('xem-thanh-vien')) {
            $status = $request->input('status');
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($status == 'trash') {
                $users = User::onlyTrashed()->latest()->paginate(5);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
            } else {
                $req = "";
                if ($request->keyword) {
                    $req = $request->keyword;
                }
                $status = '';
                $users = User::where('name', 'like', "%{$req}%")->latest()->paginate(5);
            }

            $count_active = User::count();
            $count_trash = User::onlyTrashed()->count();

            $count = [$count_active, $count_trash];

            return view('admin.user.list', compact('status','users', 'count', 'list_act'));
        }
    }

    function add() {
        if ($this->authorize('them-thanh-vien')) {
            if ($this->authorize('them-thanh-vien')) {
                $roles = Role::get();
                return view('admin.user.add', compact('roles'));
            }
        }
    }

    function store(Request $request) {

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max kí tự',
                'min' => ':attribute có độ dài ít nhất :min kí tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role_id' => 'Chọn vai trò'
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect('admin/user/list')->with('status', 'Bạn đã thêm thành công');
    }

    function delete($id) {
        if ($this->authorize('xoa-thanh-vien')) {
            if (Auth::id() != $id) {
                User::destroy($id);
                return redirect('admin/user/list')->with('status', 'Đã xóa bản ghi thành công');
            } else
                return redirect('admin/user/list')->with('status', 'Bạn không thể xóa chính bạn');
        }
    }

    function action(Request $request) {
        $list_check = $request->input('list_check');
        if ($list_check) {
            foreach ($list_check as $k => $v) {
                if (Auth::id() == $v) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa tạm thành công');
                }

                if ($act == 'restore') {
                    User::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == 'forceDelete') {
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
                }
            }
            return redirect('admin/user/list')->with('errors', 'Bạn không thể thao tác trên tài khoản của mình');
        } else {
            return redirect('admin/user/list')->with('errors', 'Bạn cần chọn phần tử cần thực thi');
        }
    }

    function getUpdate($id) {
        if ($this->authorize('sua-thanh-vien')) {
            $user = User::find($id);
            $roles = Role::get();
            return view('admin.user.update', compact('user', 'roles'));
        }
    }

    function postUpdate(Request $request, $id) {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max kí tự',
                'min' => ':attribute có độ dài ít nhất :min kí tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',
                'role_id' => 'Chọn vai trò'
            ]
        );

        User::where('id', $id)->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->role_id
        ]);

        return redirect('admin/user/list')->with('status', 'Bạn đã cập nhật thành công');
    }
}
