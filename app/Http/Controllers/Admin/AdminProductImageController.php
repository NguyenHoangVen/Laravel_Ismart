<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminProductImageController extends Controller {
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
            $productImages = ProductImage::onlyTrashed()->where('product_id', $id)->paginate(5);
        } else if ($status == "public") {
            $list_act = [
                'pending' => 'Chờ duyệt',
                'delete' => 'Xóa tạm thời',

            ];
            $productImages = ProductImage::where([
                ['status', '=', 1],
                ['product_id', '=', $id]
            ])->paginate(5);
        } else if ($status == 'pending') {
            $list_act = [
                'public' => 'Công khai',
                'delete' => 'Xóa tạm thời',
            ];
            $productImages = ProductImage::where([
                ['status', '=', 0],
                ['product_id', '=', $id]
            ])->paginate(5);
        } else {
            $productImages = ProductImage::where('product_id', $id)->paginate(5);
        }

        $count['all'] = ProductImage::where('product_id', $id)->count();
        $count['public'] = ProductImage::where([
            ['status', '=', 1],
            ['product_id', '=', $id]
        ])->count();
        $count['pending'] = ProductImage::where([
            ['status', '=', 0],
            ['product_id', '=', $id]
        ])->count();
        $count['trash'] = ProductImage::onlyTrashed()->where('product_id', $id)->count();
        $product_id = $id;
        return view('admin.productImage.list', compact('productImages', 'count', 'list_act', 'product_id'));
    }

    function postAdd($id, Request $request) {
        $request->validate([
            'image_product' => 'required|image',
        ], [
            'required' => 'Ảnh về sản phẩm không được bỏ trống',
            'image' => 'Bạn vui lòng chọn ảnh!!!'
        ]);

        $dataInsert = [
            'product_id' => $id,
            'status' => $request->status
        ];

        $dataImg = uploadImage($request->image_product, 'product');
        $dataInsert['image_product'] = $dataImg['file_path'];
        $dataInsert['image_name'] = $dataImg['file_name'];

        ProductImage::create($dataInsert);
        return back()->with('status', 'Bạn đã thêm ảnh chi tiết cho sản phẩm thành công');
    }

    function action(Request $request) {
        $list_check = $request->list_check;
        $action = $request->act;
        if (!empty($list_check)) {
            if (!empty($action)) {
                if ($action == 'delete') {
                    ProductImage::destroy($list_check);
                    return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
                } else if ($action == 'active') {
                    ProductImage::onlyTrashed()->whereIn('id', $list_check)->restore();
                    return back()->with('status', 'Bạn đã khôi phục bản ghi thành công');
                } else if ($action == 'forceDelete') {
                    ProductImage::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    return back()->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công');
                } else if ($action == 'public') {
                    ProductImage::whereIn('id', $list_check)->update([
                        'status' => 1
                    ]);
                    return back()->with('status', 'Bạn đã chuyển thành công bản ghi thành công khai');
                } else {
                    ProductImage::whereIn('id', $list_check)->update([
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
        ProductImage::find($id)->delete();
        return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
    }
}
