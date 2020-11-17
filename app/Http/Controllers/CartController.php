<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller {

    public function index() {

        return view('frontend/cart/cart');
    }

    public function add_cart(Request $request) {
        $product = Product::find($request->product_id);
        $id = $request->product_id;

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
                    "quantity" => 1,
                    "attribute_id" => $request->attribute_id,
                    "sku" => $product->sku,
                    "price" => $product->price,
                    "image" => $product->product_images[0]['images_name']
                ]
            ];

            session()->put('cart', $cart);

            return;
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return;
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "product_id" => $product->id,
            "name" => $product->name,
            "quantity" => 1,
            "attribute_id" => $request->attribute_id,
            "sku" => $product->sku,
            "price" => $product->price,
            "image" => $product->product_images[0]['images_name']
        ];

        session()->put('cart', $cart);

        return;
    }

    public function update_cart(Request $request) {
        $id = $request->product_id;
        if ($id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
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
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function go_to_checkout(Request $request) {      
        $data = [
        'shipping_cost' => $request->shipping_cost,
        'tax_cost' => $request->tax_cost,
        'grand_total' => $request->grand_total
        ];
        session()->put('cart_data', $data);
        print_r(session('cart_data'));
    }

}
