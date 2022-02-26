<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserPostController extends Controller {
    //
    function post($slug = '') {
        $cat = CategoryPost::all();
        $catName = CategoryPost::where('slug', 'like', '%' . $slug . '%')->first();
        $catPosts[] = [
            'name' => 'Tin mới',
            'slug' => '',
        ];
        foreach ($cat as $item) {
            $catPosts[] = [
                'name' => $item->name,
                'slug' => $item->slug,
            ];
        }
        if (empty($slug)) {
            $posts = Post::orderBy('created_at')->where('status', 1)->limit(6)->get();
        } else {
            $cat = CategoryPost::where('slug', 'like', '%' . $slug . '%')->first();
            $posts = Post::where('category_post_id', $cat->id)->where('status', 1)->latest()->paginate(6);
        }
        return view('user.blog.blog', compact('catPosts', 'posts', 'slug', 'catName'));
    }

    function postDetail($slugCate, $slugPost) {
        $post = Post::where('slug', 'like', '%' . $slugPost . '%')->first();
        $catName = CategoryPost::where('slug', 'like', '%' . $slugCate . '%')->first();
        return view('user.blog.detail', compact('post', 'catName'));
    }
}
