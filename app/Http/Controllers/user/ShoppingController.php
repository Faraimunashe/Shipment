<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Product;
use App\Models\Cart;

class ShoppingController extends Controller
{
    public function index()
    {
        $products = Product::paginate(8);

        return view('user.shopping', [
            'products'=>$products
        ]);
    }

    public function cart()
    {
        $cart = Cart::where('user_id', Auth::id())->get();

        return view('user.cart', [
            'cart'=>$cart
        ]);
    }

    public function add_cart($id)
    {
        $product = Product::find($id);
        if(is_null($product))
        {
            return redirect()->back()->with('error', 'failed to add product in the table');
        }

        try{
            $cart = new Cart();
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $id;
            $cart->save();

        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Product added to cart succesfully');
    }

    public function increase_cart($cart_id)
    {
        $cart = Cart::find($cart_id);
        if(is_null($cart))
        {
            return redirect()->back()->with('error', 'cannot find cart item');
        }

        try{
            $cart->qty = $cart->qty+1;
            $cart->save();

        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Quantity increased successfully');
    }

    public function decrease_cart($cart_id)
    {
        $cart = Cart::find($cart_id);
        if(is_null($cart))
        {
            return redirect()->back()->with('error', 'cannot find cart item');
        }

        try{
            $cart->qty = $cart->qty-1;
            $cart->save();

        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Quantity decreased successfully');
    }

    public function delete_cart($cart_id)
    {
        $cart = Cart::find($cart_id);
        if(is_null($cart))
        {
            return redirect()->back()->with('error', 'cannot find cart item');
        }

        try{
            $cart->delete();

        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Product successfully removed from cart');
    }
}
