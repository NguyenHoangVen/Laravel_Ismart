<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductColorController extends Controller {
    //
    function list($id, Request $request) {
        $status = $request->status;
        $list_act = array(
            'delete' => 'Xóa tạm thời',
        );
        if ($status == "trash") {
            $list_act = [
                'active' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $productColors = ProductColor::onlyTrashed()->where('product_id', $id)->paginate(5);
        } else if ($status == "public") {
            $list_act = [
                'pending' => 'Chờ duyệt',
                'delete' => 'Xóa tạm thời',

            ];
            $productColors = ProductColor::where([
                ['status', '=', 1],
                ['product_id', '=', $id]
            ])->paginate(5);
        } else if ($status == 'pending') {
            $list_act = [
                'public' => 'Công khai',
                'delete' => 'Xóa tạm thời',
            ];
            $productColors = ProductColor::where([
                ['status', '=', 0],
                ['product_id', '=', $id]
            ])->paginate(5);
        } else {
            $productColors = ProductColor::where('product_id', $id)->paginate(5);
        }

        $count['all'] = ProductColor::where('product_id', $id)->count();
        $count['public'] = ProductColor::where([
            ['status', '=', 1],
            ['product_id', '=', $id]
        ])->count();
        $count['pending'] = ProductColor::where([
            ['status', '=', 0],
            ['product_id', '=', $id]
        ])->count();
        $count['trash'] = ProductColor::onlyTrashed()->where('product_id', $id)->count();
        $product_id = $id;
        return view('admin.color.list', compact('productColors', 'count', 'list_act', 'product_id'));
    }

    function postAdd($id, Request $request) {
        $request->validate([
            'name_color' => 'required|alpha',
            'image_color_path' => 'required|image',
        ], [
            'required' => ':attribute không được bỏ trống',
            'alpha' => ':attribute phải là chữ',
            'image' => ':attribute phải là ảnh'
        ], [
            'name_color' => 'Màu sản phẩm',
            'image_color_path' => 'Ảnh màu sản phẩm'
        ]);

        try {
            DB::beginTransaction();
            //Insert data color
            $colorCreate = Color::firstOrCreate(['name' => $request->name_color]);
            $colorId = $colorCreate->id;

            //Inset data product_colors
            if ($request->hasFile('image_color_path')) {
                $dataImg = uploadImage($request->image_color_path, 'product');
                ProductColor::updateOrCreate([
                    'color_id' => $colorId,
                    'product_id' => $id,
                ], [
                    'image_color_name' => $dataImg['file_name'],
                    'image_color_path' => $dataImg['file_path'],
                    'status' => $request->status
                ]);
            }
            DB::commit();
            return back()->with('status', 'Bạn đã thêm hoặc cập nhật màu sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    function action(Request $request) {
        $list_check = $request->list_check;
        $action = $request->act;
        if (!empty($list_check)) {
            if (!empty($action)) {
                if ($action == 'delete') {
                    ProductColor::destroy($list_check);
                    return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
                } else if ($action == 'active') {
                    ProductColor::onlyTrashed()->whereIn('id', $list_check)->restore();
                    return back()->with('status', 'Bạn đã khôi phục bản ghi thành công');
                } else if ($action == 'forceDelete') {
                    ProductColor::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    return back()->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công');
                } else if ($action == 'public') {
                    ProductColor::whereIn('id', $list_check)->update([
                        'status' => 1
                    ]);
                    return back()->with('status', 'Bạn đã chuyển thành công bản ghi thành công khai');
                } else {
                    ProductColor::whereIn('id', $list_check)->update([
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

    function delete($id) {
        ProductColor::find($id)->delete();
        return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
    }
}
