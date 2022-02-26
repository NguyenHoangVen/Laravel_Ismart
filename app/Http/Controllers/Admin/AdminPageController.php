<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $status = $request->input('status');
        $data['list_act'] = [
            'delete' => 'Xóa tạm thời',
        ];
        if ($status == 'trash') {
            $data['pages'] = Page::onlyTrashed()->paginate(5);
            $data['list_act'] = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $kw = "";
            if ($request->input('kw')) {
                $kw = $request->input('kw');
            }
            $data['pages'] = Page::where('title', 'like', "%{$kw}%")->paginate(5);
            $status = '';
        }

        $data['count_act'] = Page::count();
        $data['count_trash'] = Page::onlyTrashed()->count();
        $data['status'] = $status;

        return view('admin.page.list', $data);
    }

    function action(Request $request)
    {
        $act = $request->input('act');
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            if ($act == 'delete') {
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Bạn đã xóa tạm thời thành công');
            } else if ($act == 'restore') {
                Page::onlyTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục thành công');
            } else if ($act == 'forceDelete') {
                Page::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/page/list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
            }
        } else {
            return redirect('admin/page/list')->with('errors', 'Bạn cần chọn bản ghi để thực hiện');
        }
    }

    function getAdd()
    {
        return view('admin.page.add');
    }

    function postAdd(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|min:6',
                'content' => 'required|string'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min ký tự'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung trang'
            ]
        );

        Page::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return redirect('admin/page/list')->with('status', 'Bạn đã thêm trang thành công');
    }

    function getUpdate($id)
    {
        $page = Page::find($id);
        return view('admin.page.update', compact('page'));
    }

    function postUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|min:6',
                'content' => 'required|string'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min ký tự'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung trang'
            ]
        );

        Page::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return redirect('admin/page/list')->with('status', 'Bạn đã cập nhật trang thành công');
    }

    function delete($id)
    {
        Page::destroy($id);
        return redirect('admin/page/list')->with('status', 'Bạn đã xóa bản ghi thành công');
    }
}
