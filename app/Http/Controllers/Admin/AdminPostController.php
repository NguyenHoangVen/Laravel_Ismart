<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostController extends Controller {
    //
    function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    function list(Request $request) {

        if ($this->authorize('xem-bai-viet')) {
            $status = $request->status;
            
            $list_act = array(
                'delete' => 'Xóa tạm thời',
            );
            if ($status == "trash") {
                $list_act = [
                    'active' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $posts = Post::onlyTrashed()->latest()->paginate(5);
            } else if ($status == "public") {
                $list_act = [
                    'pending' => 'Chờ duyệt',
                    'delete' => 'Xóa tạm thời',

                ];
                $posts = Post::where('status', 1)->latest()->paginate(5);
            } else if ($status == 'pending') {
                $list_act = [
                    'public' => 'Công khai',
                    'delete' => 'Xóa tạm thời',
                ];
                $posts = Post::where('status', 0)->latest()->paginate(5);
            } else {
                $kw = "";
                if ($request->kw) {
                    $kw = $request->kw;
                }
                $status = '';
                $posts = Post::where('title', 'like', "%{$kw}%")->latest()->paginate(5);
            }

            $count['all'] = Post::count();
            $count['public'] = Post::where('status', 1)->count();
            $count['pending'] = Post::where('status', 0)->count();
            $count['trash'] = Post::onlyTrashed()->count();
            return view('admin.post.list', compact('posts', 'list_act', 'count','status'));
        }
    }

    function getAdd() {
        if ($this->authorize('them-bai-viet')) {
            $data_select = dataSelect(new CategoryPost);
            return view('admin.post.add', compact('data_select'));
        }
    }

    function postAdd(Request $request) {
        $request->validate(
            [
                'title' => 'required|min:8|unique:posts',
                'image_post' => 'required',
                'content' => 'required|min:10',
                'category_post_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min ký tự',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'title' => 'Tiêu đề',
                'image_post' => 'Ảnh bài viết',
                'content' => 'Nội dung bài viết',
                'category_post_id' => 'Danh mục bài viết'
            ]

        );

        $dataInsert = array(
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'category_post_id' => $request->category_post_id,
            'user_id' => Auth::id(),
        );

        if ($request->hasFile('image_post')) {
            $dataImg = uploadImage($request->image_post, 'post');
            $dataInsert['image_post'] = $dataImg['file_path'];
            $dataInsert['image_post_name'] = $dataImg['file_name'];
        }

        Post::create($dataInsert);

        return redirect()->route('post.list')->with('status', 'Bạn đã thêm bài viết thành công');
    }

    function getUpdate($id,Request $request) {
        if ($this->authorize('sua-bai-viet')) {
            $post = Post::find($id);
            $data_select = dataSelect(new CategoryPost);
            // dd($post);
            return view('admin.post.update', compact('post', 'data_select'));
        }
    }

    function postUpdate($id, Request $request) {
        $request->validate(
            [
                'title' => 'required|min:8|unique:posts,title,' . $id . ',id',
                'content' => 'required|min:10',
                'category_post_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có ít nhất :min ký tự',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung bài viết',
                'category_post_id' => 'Danh mục bài viết'
            ]

        );

        $dataUpdate = array(
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'category_post_id' => $request->category_post_id,
            'user_id' => Auth::id(),
        );

        if ($request->hasFile('image_post')) {
            $dataImg = uploadImage($request->image_post, 'post');
            $dataUpdate['image_post'] = $dataImg['file_path'];
            $dataUpdate['image_post_name'] = $dataImg['file_name'];
        }
        Post::find($id)->update($dataUpdate);

        return redirect()->route('post.list')->with('status', 'Bạn đã cập nhật bài viết thành công');
    }

    function delete($id) {
        if ($this->authorize('xoa-bai-viet')) {
            Post::find($id)->delete();
            return redirect()->route('post.list')->with('status', 'Bạn đã xóa tạm bản ghi thành công');
        }
    }

    function action(Request $request) {
        $list_check = $request->list_check;
        $action = $request->act;
        // dd(url()->previous());
        $url = url()->previous();
        if (!empty($list_check)) {
            if (!empty($action)) {
                if ($action == 'delete') {
                    Post::destroy($list_check);
                    return redirect($url)->with('status', 'Bạn đã xóa tạm bản ghi thành công');
                } else if ($action == 'active') {
                    Post::onlyTrashed()->whereIn('id', $list_check)->restore();
                    return redirect($url)->with('status', 'Bạn đã khôi phục bản ghi thành công');
                } else if ($action == 'forceDelete') {
                    Post::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect($url)->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công');
                } else if ($action == 'public') {
                    Post::whereIn('id', $list_check)->update([
                        'status' => 1
                    ]);
                    return redirect($url)->with('status', 'Bạn đã chuyển thành công bản ghi thành công khai');
                } else {
                    Post::whereIn('id', $list_check)->update([
                        'status' => 0
                    ]);
                    return redirect($url)->with('status', 'Bạn đã chuyển thành công bản ghi thành chờ duyệt');
                }
            } else {
                return redirect($url)->with('errors', 'Bạn vui lòng chọn thao tác thực hiện bản ghi');
            }
        } else {
            return redirect($url)->with('errors', 'Bạn vui lòng chọn bản ghi để thực hiện');
        }
    }
}
