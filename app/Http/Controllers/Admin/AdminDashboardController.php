<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller {
    //
    function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function show() {
        $data['roles'] = Role::count();
        $data['pages'] = Page::count();
        $data['posts'] = Post::count();
        $data['products'] = Product::count();
        $data['users'] = User::count();
        $data['orderSuccess'] = Order::where('status', 2)->count();
        $data['orderProcessing'] = Order::where('status', 0)->count();
        $data['orderDelivery'] = Order::where('status', 1)->count();
        $data['orderDelete'] = Order::where('status', 3)->count();
        $data['orders'] = Order::where('status','!=',3)->latest()->paginate(10);
        $revenue = Order::where('status', 2)->select('total')->get();
        $total = 0;
        foreach ($revenue as $value) {
            $total += (int)$value->total;
        }
        $data['revenue'] = $total;
        return view('admin.dashboard', $data);
    }
}
