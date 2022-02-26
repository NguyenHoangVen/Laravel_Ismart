<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductColor;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserCartController extends Controller {
    //
    function addCart(Request $request, $id) {
        $qty = $request->input('num');
        $productColorId = $request->input('productColorId');
        $productColor = ProductColor::find($productColorId);
        $product = Product::find($id);
        $qty = (int) $qty;
        if (is_int($qty) and $qty > 0) {
            Cart::add([
                'id' => $id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $product->price,
                'options' => [
                    'image_product' => $productColor->image_color_path,
                    'color_name' => $productColor->color->name,
                    'slug_category' => $product->category->catProductParent->slug,
                    'slug_product' => $product->slug,
                ]
            ]);

            return json_encode([
                'code' => 200,
                'name' => $product->name,
                'num' => Cart::count(),
                'message' => 'success'
            ]);
        } else {
            return back();
        }
    }

    function addProductCart($id) {
        $product = Product::find($id);
        $priceProduct = number_format($product->price, 0, ',', '.');
        $productColors = ProductColor::where('product_id', $id)->get();
        $txt = "";
        $t = 1;
        foreach ($productColors as $item) {
            $active = "";
            $checked = "";
            if ($t == 1) {
                $active = "active";
                $checked = "checked";
                $t++;
            }
            $src = asset("{$item->image_color_path}");
            $txt .= '<div class="product-color ' . $active . '">
                        <div class="img img-product">
                            <img src="' . $src . '"
                                alt="">
                            <input type="radio" ' . $checked . ' name="check-color-cart" value="' . $item->id . '" />
                            <p class="color-name">' . $item->color->name . '</p>
                        </div>
                    </div>';
        }

        return json_encode([
            'code' => 200,
            'product' => $product,
            'priceProduct' => $priceProduct,
            'txt' => $txt,
            'message' => 'success'
        ]);
    }

    function show() {
        // dd(Cart::content());
        return view('user.cart.show');
    }

    function updateCart(Request $request) {
        Cart::update($request->rowId, $request->qty);
        $productCart = Cart::get($request->rowId);
        $subTotal = $productCart->price * $productCart->qty;
        $subTotal = number_format($subTotal, 0, ',', '.');
        return json_encode([
            'code' => 200,
            'num' => Cart::count(),
            'subTotal' => $subTotal,
            'total' => number_format(Cart::total(), 0, ',', '.'),
            'message' => 'Success'
        ]);
    }


    function deleteCart($rowId) {
        if ($rowId == 'all') {
            Cart::destroy();
            return back();
        } else {
            try {
                Cart::remove($rowId);
                return json_encode([
                    'code' => 200,
                    'num' => Cart::count(),
                    'total' => number_format(Cart::total(), 0, ',', '.'),
                    'message' => 'Success'
                ]);
            } catch (\Exception $e) {
                Log::error('Lỗi: ' . $e->getMessage() . '---Line: ' . $e->getLine());
                return json_encode([
                    'code' => 500,
                    'message' => 'Error'
                ]);
            }
        }
    }

    function checkout() {
        if (Cart::count() > 0) {
            $checkoutProducts = Cart::content();
            $totalPrice = Cart::total();
            $numProducts = Cart::count();
            return view('user.cart.checkout', compact('checkoutProducts', 'totalPrice', 'numProducts'));
        } else {
            return back();
        }
    }

    function postCheckout(Request $request) {
        $request->validate(
            [
                'fullname' => 'required|min:3',
                'phone' => 'required|digits_between:10,12',
                'email' => 'required|email',
                'calc_shipping_provinces' => 'required',
                'calc_shipping_district' => 'required',
                'address' => 'required|min:5'

            ],
            [
                'required' => ':attribute không được để trống',
                'alpha' => ':attribute chỉ chứa ký tự chữ',
                'min' => ':attribute có ít nhất :min ký tự',
                'digits_between' => ':attribute chỉ chứa số và phải nhập 10 số',
                'email' => ':attribute phải có định dạng email'
            ],
            [
                'fullname' => 'Họ tên',
                'phone' => 'Số điện thoại',
                'email' => 'Email',
                'calc_shipping_provinces' => 'Tỉnh/Thành phố',
                'calc_shipping_district' => 'Quận/Huyện',
                'address' => 'Địa chỉ'
            ]
        );

        try {
            DB::beginTransaction();

            //Insert data customer
            $address = $request->address . ', ' . $request->calc_shipping_district . ', ' . $request->calc_shipping_provinces;
            $dataCustomer = [
                'name' => $request->fullname,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $address,
            ];
            $customer = Customer::create($dataCustomer);

            // Insert data order
            $orderId = 'IS-' . $this->createOrderId();
            $dataOrder = [
                'id' => $orderId,
                'customer_id' => $customer->id,
                'total' => Cart::total()
            ];
            Order::create($dataOrder);

            //Inset orderDetail
            $content = Cart::content();
            $dataOrderDetail = array();
            foreach ($content as $key => $value) {
                $dataOrderDetail['order_id'] = $orderId;
                $dataOrderDetail['product_id'] = $value->id;
                $dataOrderDetail['color'] = $value->options->color_name;
                $dataOrderDetail['quantity'] = $value->qty;
                OrderDetail::create($dataOrderDetail);
            }

            $data['info'] = $customer;
            $data['cart'] = Cart::content();
            $data['total'] = Cart::total();
            $data['orderId'] = $orderId;
            $emailCustomer = $dataCustomer['email'];
            $nameCustomer = $dataCustomer['name'];

            //Send Mail
            Mail::send('user.mail.orderConfirmation', $data, function ($message) use ($emailCustomer, $nameCustomer) {
                $message->from('nhven97@gmail.com', 'ISMART STORE');
                $message->to($emailCustomer, $nameCustomer);
                $message->subject('Xác nhận đơn hàng cửa hàng ISMART STORE');
            });

            Cart::destroy();

            DB::commit();
            return redirect()->route('user.complete');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        // dd($request->all());
    }

    function createOrderId() {
        $string = '';
        do {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $max = strlen($characters) - 1;
            for ($i = 0; $i < 8; $i++) {
                $string .= $characters[mt_rand(0, $max)];
            }
        } while (Order::where('id', 'like', "%IS-{$string}%")->first());
        return $string;
    }

    function complete() {
        return view('user.cart.complete');
    }
}
