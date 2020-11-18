<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Attribute;

class CartController extends Controller {

    public function index() {

        return view('frontend/cart/cart');
    }

    public function add_cart(Request $request) {
        $product = Product::find($request->product_id);
        $id = $request->product_id;
        $quantity = $request->quantity;
        if ($quantity != '') {
            $quantity = $request->quantity;
        } else {
            $quantity = 1;
        }

        $attribute_id = $request->attribute_id;
        if ($attribute_id != '') {
            $attribute_id = $request->attribute_id;
        } else {
            $attribute_id = 3;
        }
        $attributes = Attribute::with(['attribute_group'])->whereHas('products.attributes', function($q) use ($attribute_id) {
                    $q->where('attribute_id', $attribute_id);
                })->get();

        $attribute_array = array();
        foreach ($attributes as $attribute) {
            $group_name = $attribute['attribute_group']['attribute_group_name'];
            $attribute_array[$group_name][] = $attribute;
        }

        if (!$product) {

            abort(404);
        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if (!$cart) {

            $cart = [
                $id => [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "quantity" => $quantity,
                    "attribute_id" => $request->attribute_id,
                    "attributes" => $attribute_array,
                    "sku" => $product->sku,
                    "price" => $product->price,
                    "image" => $product->product_images[0]['images_name'],
                    'attribute_id' => $attribute_id,
                    'subtotal' => $product->price * ($quantity)
                ]
            ];
            session()->put('cart', $cart);
            $this->OrderData();
            return;
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;
            $cart[$id]["subtotal"] = $cart[$id]['quantity'] * $cart[$id]["price"];
            if ($request->attribute_id != null) {
                $cart[$id]["attribute_id"] = $request->attribute_id;
                $cart[$id]["attributes"] = $attribute_array;
            }
            session()->put('cart', $cart);
            $this->OrderData();
            return;
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "product_id" => $product->id,
            "name" => $product->name,
            "quantity" => $quantity,
            "attribute_id" => $request->attribute_id,
            "sku" => $product->sku,
            "price" => $product->price,
            "image" => $product->product_images[0]['images_name'],
            'attribute_id' => $attribute_id,
            "attributes" => $attribute_array,
            'subtotal' => $product->price * ($quantity)
        ];

        session()->put('cart', $cart);
        $this->OrderData();
        return;
    }

    public function get_cart() {
        $cart = session()->get('cart');
        $html = '';
        $cartTotal = 0;
        if (session('cart')) {
            foreach ($cart as $rowCart) {
                $cartTotal += $rowCart['subtotal'];
                $html .= '
                      <li>
                      <div class="media">
                        <a href="#"><img alt="" class="mr-3"
                         src="' . url('storage/app/' . $rowCart['image']) . '" width="60"></a>
                          <div class="media-body">
                            <a href="#">
                              <h4>' . $rowCart["name"] . '</h4>
                                </a>
                              <h4><span>' . $rowCart["quantity"] . ' x Tk.' . $rowCart["price"] . '</span></h4>
                             </div>
                           </div>
                          <div class="close-circle"><a href="#" onclick="deleteCartExceptReload(' . $rowCart["product_id"] . ')"><i class="fa fa-times"
                        aria-hidden="true"></i></a></div>
                  </li>
               ';
            }
            $html .= '
             <li>
                <div class="total">
                   <h5>subtotal : <span>Tk.' . $cartTotal . '</span></h5>
                 </div>
              </li>
             '
            ;
        } else {
            $html .= '
                      <li>
                       <div class="media">
                         <div class="media-body">
                           <h3>Your cart is empty<h3>
                             </div>
                            </div>
                        <div class="close-circle"><a href="#"><i class="fa fa-times"
                      aria-hidden="true"></i></a></div>
                   </li>
                ';
        }
        return response()->json($html);
    }

    public function update_cart(Request $request) {
        $id = $request->product_id;
        if ($id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$id]["quantity"] = $request->quantity;
            $cart[$id]["subtotal"] = $request->quantity * $cart[$id]["price"];
            session()->put('cart', $cart);
            $this->OrderData();
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function delete_cart(Request $request) {
        $id = $request->product_id;
        if ($id) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                $this->OrderData();
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function go_to_checkout(Request $request) {
        $this->OrderData();
    }

    public function checkout() {
        $customer_id = 1;
        if ($customer_id != null) {
            $this->OrderData();
            return view('frontend/checkout/checkout');
        } else {
            return redirect('cart/cart-list');
        }
    }

    public function OrderData() {
        $cart = session()->get('cart');
        if (!empty($cart)) {
            $cartTotal = 0;
            foreach ($cart as $rowCart) {
                $cartTotal += $rowCart['subtotal'];
            }
            $order_tax_percent = 0;
            $order_tax_amount = 100;
            $shipping_cost = 60;
            $order_discount_amount = 100;
            $data = [
                'shipping_cost' => $shipping_cost,
                'order_tax_amount' => $order_tax_amount,
                'order_grand_total' => $shipping_cost + $order_tax_amount + $cartTotal,
                'order_code' => "#order_code.$cartTotal.",
                'order_total' => $cartTotal,
                'order_sub_total' => $cartTotal,
                'order_tax_percent' => $order_tax_percent,
                'order_discount_amount' => $order_discount_amount
            ];
            session()->put('order_data', $data);
        } else {
            session()->forget('order_data');
        }
    }

    public function place_order(Request $request) {
        $customer_id = 1;
        $billing_id = $request->billing_id;
        if ($customer_id != null && $billing_id != null) {

            $customer_data = Customer::find($customer_id);
            $shipping_id = 1;
            $order = new Order;
            $order['customer_id'] = $customer_data->id;
            $order['customer_name'] = $customer_data->customer_first_name . ' ' . $customer_data->customer_last_name;
            $order['order_status'] = 0;
//            Use when you have a billing or shipping id
//            
//            $order['shipping_id'] = $shipping_id;
//            $order['shipping_cost'] = session('order_data')['shipping_cost'];

            $order['order_tax_amount'] = session('order_data')['order_tax_amount'];
            $order['order_grand_total'] = session('order_data')['order_grand_total'];
            $order['order_code'] = session('order_data')['order_code'];
            $order['order_total'] = session('order_data')['order_total'];
            $order['order_sub_total'] = session('order_data')['order_sub_total'];
            $order['order_tax_percent'] = session('order_data')['order_tax_percent'];
            $order['order_discount_amount'] = session('order_data')['order_discount_amount'];
            $order['order_date'] = date("Y-m-d h:i:s");
            $order->save();

            foreach (session('cart') as $row) {
                $order_detail = new OrderDetail;
                $order_detail['order_id'] = $order->id;
                $order_detail['order_code'] = $order->order_code;
                $order_detail['order_product_id'] = $row['product_id'];
                $order_detail['order_product_name'] = $row['name'];
                $order_detail['order_product_quantity'] = $row['quantity'];
                $order_detail['order_product_price'] = $row['price'];
                $order_detail->save();
            }

            session()->forget('cart');
            session()->forget('order_data');

            return redirect('/');
        } else {
            return redirect('cart/checkout');
        }
    }

}
