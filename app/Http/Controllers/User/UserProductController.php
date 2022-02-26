<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    //
    function productDetail($slugCategory, $slugProduct)
    {
        $product = Product::where('slug', 'like', '%' . $slugProduct . '%')->first();
        $productId = $product->id;
        $productImgs = $product->images;
        $productColors = ProductColor::where('product_id', $productId)->get();

        $cat = CategoryProduct::where('slug', '=', $slugCategory)->first();
        $catChild = DB::table('category_products')->where('parent_id', $cat->id)->get();
        foreach ($catChild as $item) {
            $catIds[] = $item->id;
        }
        
        $sameProduct = Product::whereIn('category_product_id', $catIds)->where('featured', 1)->where('status', 1)->get();
        return view('user.product.detail', compact('product', 'productImgs', 'productColors', 'sameProduct', 'cat'));
    }

    function category($slugCategory, Request $request)
    {
        $catProduct = CategoryProduct::where('slug', '=', $slugCategory)->first();
        $checkBrand = $request->input('r-brand');

        $catCheck = "";
        $catBrandIds = array();
        // Filter by b-rand (brand is array)
        if (!empty($checkBrand)) {
            $catBrand = CategoryProduct::whereIn('slug', $checkBrand)->get();
            foreach ($catBrand as $cat) {
                $catBrandIds[] = $cat->id;
            }
        }
        $checkPrice = $request->input('r-price');

        if ($catProduct->parent_id == 0) {
            // Category is root (parent_id =0)
            $catFilter = $catProduct->catProductChild;
            $catIds = array();
            foreach ($catFilter as $value) {
                $catIds[] = $value->id;
            }
        } else {

            if (empty($checkBrand)) {
                // Using in checked feature filter
                $catCheck = $catProduct->slug;
            }
            // Get all category have lavel equal (equal parent_id)
            $catFilter = CategoryProduct::where(
                'parent_id',
                $catProduct->catProductParent->id
            )->get();
            $catIds[] = $catProduct->id;
        }

        if (!empty($request->sort)) {
            $sort = $request->sort;
            if ($sort == 'a-z') {
                $products = Product::whereIn('category_product_id', $catIds)->where('status', 1)->orderBy('name')->paginate(16);
            } else if ($sort == 'z-a') {
                $products = Product::whereIn('category_product_id', $catIds)->where('status', 1)->orderBy('name', 'desc')->paginate(16);
            } else if ($sort == 'high-to-low') {
                $products = Product::whereIn('category_product_id', $catIds)->where('status', 1)->orderBy('price', 'desc')->paginate(16);
            } else {
                $products = Product::whereIn('category_product_id', $catIds)->where('status', 1)->orderBy('price')->paginate(16);
            }
        } else if (!empty($checkBrand) || !empty($checkPrice)) {
            if ((!empty($checkBrand) and !empty($checkPrice)) || !empty($checkBrand)) {
                $products = Product::when($catBrandIds, function ($query, $catBrandIds) {
                    $query->whereIn('category_product_id', $catBrandIds);
                })->when($checkPrice, function ($query, $checkPrice) {
                    $query->when('duoi-3-trieu' == $checkPrice, function ($query) {
                        $query->Where('price', '<', '3000000');
                    })->when('tu-3-5-trieu' == $checkPrice, function ($query) {
                        $query->WhereBetween('price', ['3000000', '5000000']);
                    })->when('tu-5-8-trieu' == $checkPrice, function ($query) {
                        $query->WhereBetween('price', ['5000000', '8000000']);
                    })->when('tu-8-11-trieu' == $checkPrice, function ($query) {
                        $query->WhereBetween('price', ['8000000', '11000000']);
                    })->when('tren-11-trieu' == $checkPrice, function ($query) {
                        $query->Where('price', '>', '11000000');
                    });
                })->where('status', 1)->latest()->paginate(16);
            } else {
                // In case category root
                $products = Product::when($checkPrice, function ($query, $checkPrice) {
                    $query->when('duoi-3-trieu' == $checkPrice, function ($query) {
                        $query->Where('price', '<', '3000000');
                    })->when('tu-3-5-trieu' == $checkPrice, function ($query) {
                        $query->WhereBetween('price', ['3000000', '5000000']);
                    })->when('tu-5-8-trieu' == $checkPrice, function ($query) {
                        $query->WhereBetween('price', ['5000000', '8000000']);
                    })->when('tu-8-11-trieu' == $checkPrice, function ($query) {
                        $query->WhereBetween('price', ['8000000', '11000000']);
                    })->when('tren-11-trieu' == $checkPrice, function ($query) {
                        $query->Where('price', '>', '11000000');
                    });
                })->whereIn('category_product_id', $catIds)->where('status', 1)->latest()->paginate(16);
            }
            // dd($products);
        } else {
            // dd($catIds);
            $products = Product::whereIn('category_product_id', $catIds)->where('status', 1)->latest()->paginate(16);
        }
        return view('user.product.category', compact(
            'products',
            'catProduct',
            'catFilter',
            'checkBrand',
            'checkPrice',
            'catCheck'
        ));
    }

    function search(Request $request)
    {
        $kw = $request->input('search');
        if ($kw != "") {
            $products = Product::where('name', 'like', "%{$kw}%")->where('status', 1)->latest()->paginate(16);
            $countSearch = Product::where('name', 'like', "%{$kw}%")->where('status', 1)->get()->count();
            return view('user.product.search', compact('products', 'countSearch'));
        } else {
            return back();
        }
    }

    function autocomplete(Request $request)
    {
        $kw = $request->input('kw');
        $products = Product::where('name', 'like', "%{$kw}%")->where('status', 1)->latest()->paginate(5);

        $txt = '<ul class="list-results">';
        foreach ($products as $item) {
            $src_img = asset("{$item->feature_image}");
            $hrefProduct = route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]);
            $txt .= '<li class="list-item">
                        <a href="' . $hrefProduct . '" class="pro-item">
                            <div class="pro-item-img">
                                <img src="' . $src_img . '" alt="">
                            </div>
                            <div class="pro-item-info">
                                <h3 class="pro-item-name">' . $item->name . '</h3>
                                <p class="pro-item-price">' . number_format($item->price, 0, ',', '.') . 'đ</p>
                            </div>
                        </a>
                    </li>';
        }
        $txt .= '</ul>';

        return json_encode([
            'code' => 200,
            'text' => $txt,
            'message' => 'Success'
        ]);
    }
}
