<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function cart(){
        $product= Product::all();
        $cart = session()->get('cart');
        return view('backend.cart.index', compact('product', 'cart'));
    }

    public function add_to_cart(Request $request)
    {
        $id = $request->input("product_id");
        $code = $request->input("code");
        $product = Product::where("id", $id)->orWhere("code", $code)->first();


        $cart = session()->has('cart') ? session()->get('cart') : [];

        if (key_exists($product->id, $cart)) {
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + 1;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session(['cart' => $cart]);
        return redirect()->back();
    }

    public function remove_from_cart($id)
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];
        if (key_exists($id, $cart)) {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        return redirect()->back();
    }
}
