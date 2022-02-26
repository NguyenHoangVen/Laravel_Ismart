<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSliderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $status = $request->status;
        $list_act = array(
            'delete' => 'Xóa tạm thời',
        );
        if ($status == "trash") {
            $list_act = [
                'active' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $sliders = Slider::onlyTrashed()->latest()->paginate(5);
        } else if ($status == "public") {
            $list_act = [
                'delete' => 'Xóa tạm thời',
                'pending' => 'Chờ duyệt'
            ];
            $sliders = Slider::where('status', 1)->latest()->paginate(5);
        } else if ($status == 'pending') {
            $list_act = [
                'delete' => 'Xóa tạm thời',
                'public' => 'Công khai'
            ];
            $sliders = Slider::where('status', 0)->latest()->paginate(5);
        } else {
            $status = '';
            $sliders = Slider::latest()->paginate(3);
        }

        $count['all'] = Slider::count();
        $count['public'] = Slider::where('status', 1)->count();
        $count['pending'] = Slider::where('status', 0)->count();
        $count['trash'] = Slider::onlyTrashed()->count();


        return view('admin.slider.list', compact('status','sliders', 'list_act', 'count'));
    }

    function postAdd(Request $request)
    {
        $request->validate(
            [
                'image_path' => 'required|unique:sliders',
            ],
            [
                'required' => 'Ảnh slider không được để trống'
            ]
        );

        $dataInsert = array(
            'status' => $request->status,
            'user_id' => Auth::id(),
        );

        if ($request->hasFile('image_path')) {
            $dataImg = uploadImage($request->image_path, 'slider');
            $dataInsert['image_path'] = $dataImg['file_path'];
            $dataInsert['image_name'] = $dataImg['file_name'];
        }
        Slider::create($dataInsert);

        return back()->with('status', 'Bạn đã thêm slider thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->list_check;
        $action = $request->act;
        $url = url()->previous();
        if (!empty($list_check)) {
            if (!empty($action)) {
                if ($action == 'delete') {
                    Slider::destroy($list_check);
                    return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
                } else if ($action == 'active') {
                    Slider::onlyTrashed()->whereIn('id', $list_check)->restore();
                    return back()->with('status', 'Bạn đã khôi phục bản ghi thành công');
                } else if ($action == 'forceDelete') {
                    Slider::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    return back()->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công');
                } else if ($action == 'public') {
                    Slider::whereIn('id', $list_check)->update([
                        'status' => 1
                    ]);
                    return back()->with('status', 'Bạn đã chuyển thành công bản ghi thành công khai');
                } else {
                    Slider::whereIn('id', $list_check)->update([
                        'status' => 0
                    ]);
                    return back()->with('status', 'Bạn đã chuyển thành công bản ghi thành chờ duyệt');
                }
            } else {
                return back()->with('error', 'Bạn vui lòng chọn thao tác thực hiện bản ghi');
            }
        } else {
            return back()->with('error', 'Bạn vui lòng chọn bản ghi để thực hiện');
        }
    }

    function delete($id)
    {
        Slider::find($id)->delete();
        return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
    }

    function getUpdate($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.update', compact('slider'));
    }

    function postUpdate($id, Request $request)
    {
        $dataUpdate = array(
            'status' => $request->status,
            'user_id' => Auth::id(),
        );

        if ($request->hasFile('image_path')) {
            $dataImg = uploadImage($request->image_path, 'slider');
            $dataInsert['image_path'] = $dataImg['file_path'];
            $dataInsert['image_name'] = $dataImg['file_name'];
        }

        Slider::find($id)->update($dataInsert);

        return redirect()->route('slider.list')->with('status', 'Bạn đã cập nhật slider thành công');
    }
}
