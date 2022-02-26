<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryProductController extends Controller {
    //
    function list() {
        if ($this->authorize('xem-danh-muc-san-pham')) {
            // $categories = CategoryProduct::latest()->paginate(5);
            // dd(CategoryProduct::all());
            // recursive(CategoryProduct::all());
            $categories = CategoryProduct::all();
            $categories = recursive($categories);
            $data_select = dataSelect(new CategoryProduct);
            return view('admin.categoryProduct.list', compact('data_select', 'categories'));
        }
    }

    function postAdd(Request $request) {
        $request->validate(
            [
                'name' => 'required|min:3|unique:category_products',
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'unique' => 'Tên danh mục đã tồn tại',
                'min' => 'Tên danh mục chứa ít nhất 3 ký tự'
            ]
        );

        CategoryProduct::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ]);

        return back()->with('status', 'Bạn đã thêm danh mục thành công');
    }

    function getUpdate($id) {
        $category = CategoryProduct::find($id);
        $data_select = dataSelect(new CategoryProduct);
        return view('admin.categoryProduct.update', compact('data_select', 'category'));
    }

    function postUpdate($id, Request $request) {
        $request->validate(
            [
                'name' => 'required|min:3|unique:category_products,name,' . $id . ',id',
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'unique' => 'Tên danh mục đã tồn tại',
                'min' => 'Tên danh mục chứa ít nhất 3 ký tự'
            ]
        );

        CategoryProduct::find($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('category.list')->with('status', 'Bạn đã cập nhật danh mục thành công');
    }

    function delete($id) {
        CategoryProduct::find($id)->delete();
        return redirect()->route('category.list')->with('status', 'Bạn đã cập nhật danh mục thành công');
    }
}
