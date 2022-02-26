<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminProductController extends Controller {
    //
    function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function list(Request $request) {
        if ($this->authorize('xem-san-pham')) {
            $status = $request->status;
            $list_act = array(
                'delete' => 'Xóa tạm thời',
            );
            if ($status == "trash") {
                $list_act = [
                    'active' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $products = Product::onlyTrashed()->latest()->paginate(5);
            } else if ($status == "public") {
                $list_act = [
                    'pending' => 'Chờ duyệt',
                    'delete' => 'Xóa tạm thời',

                ];
                $products = Product::where('status', 1)->latest()->paginate(5);
            } else if ($status == 'pending') {
                $list_act = [
                    'public' => 'Công khai',
                    'delete' => 'Xóa tạm thời',
                ];
                $products = Product::where('status', 0)->latest()->paginate(5);
            } else {
                $kw = "";
                if ($request->kw) {
                    $kw = $request->kw;
                }
                $status = '';
                $products = Product::where('name', 'like', "%{$kw}%")->latest()->paginate(5);
            }

            $count['all'] = Product::count();
            $count['public'] = Product::where('status', 1)->count();
            $count['pending'] = Product::where('status', 0)->count();
            $count['trash'] = Product::onlyTrashed()->count();
            return view('admin.product.list', compact('status','products', 'count', 'list_act'));
        }
    }

    function getAdd() {
        if ($this->authorize('them-san-pham')) {
            $data_select = dataSelect(new CategoryProduct);
            return view('admin.product.add', compact('data_select'));
        }
    }

    function postAdd(Request $request) {

        dd($request);
        $request->validate(
            [
                'name' => 'required|unique:products|min:8',
                'feature_image' => 'required|image',
                'image_product' => 'required',
                'image_product.*' => 'mimes:jpeg,jpg,png,gif,csv',
                'price' => 'required|digits_between:5,10',
                'description' => 'required',
                'category_product_id' => 'required',
                'name_color.*' => 'alpha',
                'image_color_path' => 'required',
                'image_color_path.*' => 'mimes:jpeg,jpg,png,gif,csv',
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => ':attribute đã tồn tại',
                'image' => ':attribute phải là ảnh',
                'digits_between' => ':attribute phải là số và có giá khoảng từ 10,000 trở lên',
                'min' => ':attribute chưa ít nhất :min ký tự',
                'mimes' => 'Phải có định dạng file là: jpeg,jpg,png,gif,csv',
                'alpha' => 'Phải nhập ký tự chữ',
            ],
            [
                'name' => 'Tên sản phẩm',
                'feature_image' => 'Ảnh đại diện sản phẩm',
                'image_product' => 'Ảnh chi tiết sản phẩm',
                'price' => ' Giá sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'category_product_id' => 'Danh mục sản phẩm',
                'name_color' => 'Màu sản phẩm',
                'image_color_path' => 'Ảnh màu sản phẩm'
            ]

        );

        try {
            DB::beginTransaction();
            //Insert data product
            $dataInsert = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'category_product_id' => $request->category_product_id,
                'user_id' => Auth::id(),
                'status' => $request->status,
                'featured' => $request->featured,
            ];

            if ($request->hasFile('feature_image')) {
                $dataImg = uploadImage($request->feature_image, 'product');
                $dataInsert['feature_image'] = $dataImg['file_path'];
            }
            $product = Product::create($dataInsert);

            //Insert data product_image
            if ($request->hasFile('image_product')) {
                foreach ($request->image_product as $item) {
                    $dataImg = uploadImage($item, 'product');
                    $product->images()->create([
                        'image_product' => $dataImg['file_path'],
                        'image_name' => $dataImg['file_name']
                    ]);
                }
            }

            //Insert data color
            if (!empty($request->name_color)) {
                foreach ($request->name_color as $color) {
                    $colorCreate = Color::firstOrCreate(['name' => $color]);
                    $colorIds[] = $colorCreate->id;
                }
            }

            //Inset data product_colors
            if ($request->hasFile('image_color_path')) {
                foreach ($request->image_color_path as $item) {
                    $dataImg = uploadImage($item, 'product');
                    $imgColor[] = [
                        'image_color_path' => $dataImg['file_path'],
                        'image_color_name' => $dataImg['file_name']
                    ];
                }
            }

            for ($i = 0; $i < count($colorIds); $i++) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $colorIds[$i],
                    'image_color_name' => $imgColor[$i]['image_color_name'],
                    'image_color_path' => $imgColor[$i]['image_color_path']
                ]);
            }

            DB::commit();

            return redirect()->route('product.list')->with('status', 'Bạn đã thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    function getUpdate($id) {
        if ($this->authorize('sua-san-pham')) {
            $product = Product::find($id);
            $productImage = $product->images->where('status', 1);
            $data_select = dataSelect(new CategoryProduct);
            return view('admin.product.update', compact('product', 'data_select', 'productImage'));
        }
    }

    function postUpdate($id, Request $request) {
        $request->validate(
            [
                'name' => 'required|min:8|unique:products,name,' . $id . ',id',
                'image_product.*' => 'mimes:jpeg,jpg,png,gif,csv',
                'price' => 'required|digits_between:5,10',
                'description' => 'required',
                'category_product_id' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => ':attribute đã tồn tại',
                'image' => ':attribute phải là ảnh',
                'digits_between' => ':attribute phải là số và có giá khoảng từ 10,000 trở lên',
                'min' => ':attribute chưa ít nhất :min ký tự',
                'mimes' => 'Phải có định dạng file là: jpeg,jpg,png,gif,csv',
            ],
            [
                'name' => 'Tên sản phẩm',
                'feature_image' => 'Ảnh đại diện sản phẩm',
                'image_product' => 'Ảnh chi tiết sản phẩm',
                'price' => ' Giá sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'category_product_id' => 'Danh mục sản phẩm',
            ]

        );

        try {
            DB::beginTransaction();
            //Insert data product
            $dataUpdate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'category_product_id' => $request->category_product_id,
                'user_id' => Auth::id(),
                'status' => $request->status,
                'featured' => $request->featured,
            ];

            if ($request->hasFile('feature_image')) {
                $dataImg = uploadImage($request->feature_image, 'product');
                $dataUpdate['feature_image'] = $dataImg['file_path'];
            }
            Product::find($id)->update($dataUpdate);

            $product = Product::find($id);

            //Insert data product_image
            if ($request->hasFile('image_product')) {
                ProductImage::where('product_id', $id)->delete();
                foreach ($request->image_product as $item) {
                    $dataImg = uploadImage($item, 'product');
                    $product->images()->create([
                        'image_product' => $dataImg['file_path'],
                        'image_name' => $dataImg['file_name']
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('product.list')->with('status', 'Bạn đã cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
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
                    Product::destroy($list_check);
                    return redirect($url)->with('status', 'Bạn đã xóa tạm bản ghi thành công');
                } else if ($action == 'active') {
                    Product::onlyTrashed()->whereIn('id', $list_check)->restore();
                    return redirect($url)->with('status', 'Bạn đã khôi phục bản ghi thành công');
                } else if ($action == 'forceDelete') {
                    Product::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect($url)->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công');
                } else if ($action == 'public') {
                    Product::whereIn('id', $list_check)->update([
                        'status' => 1
                    ]);
                    return redirect($url)->with('status', 'Bạn đã chuyển thành công bản ghi thành công khai');
                } else {
                    Product::whereIn('id', $list_check)->update([
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

    function delete($id) {
        if ($this->authorize('xoa-san-pham')) {
            Product::find($id)->delete();
            return redirect()->route('product.list')->with('status', 'Bạn đã xóa tạm bản ghi thành công');
        }
    }

    function featured($id) {
        $product = Product::find($id);
        $featured = $product->featured;
        if ($featured == 1) {
            Product::find($id)->update([
                'featured' => 0
            ]);
        } else {
            Product::find($id)->update([
                'featured' => 1
            ]);
        }

        return back()->with('status', 'Bạn đã đổi trạng thái nổi bật của sản phẩm thành công');
    }
}
