<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCategoryPostController extends Controller
{
    function list()
    {
        if ($this->authorize('xem-danh-muc-bai-viet')) {
            $catPosts = CategoryPost::latest()->paginate(5);
            $data_select = dataSelect(new CategoryPost);
            return view('admin.categoryPost.list', compact('catPosts', 'data_select'));
        }
    }

    function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:5|unique:category_posts',
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'unique' => 'Tên danh mục đã tồn tại',
                'min' => 'Tên danh mục chứa ít nhất 5 ký tự'
            ]
        );

        CategoryPost::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ]);

        return back()->with('status', 'Bạn đã thêm danh mục thành công');
    }

    function getUpdate($id)
    {
        $catPost = CategoryPost::find($id);

        $data_select = dataSelect(new CategoryPost);
        return view('admin.categoryPost.update', compact('data_select', 'catPost'));
    }

    function postUpdate($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:5|unique:category_posts,name,' . $id . ',id',
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'unique' => 'Tên danh mục đã tồn tại',
                'min' => 'Tên danh mục chứa ít nhất 5 ký tự'
            ]
        );

        CategoryPost::find($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('categoryPost.list')->with('status', 'Bạn đã cập nhật danh mục thành công');
    }

    function delete($id)
    {
        return deleteModel($id, new CategoryPost);
    }
}
