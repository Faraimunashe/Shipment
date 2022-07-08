<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;

class ShoppingController extends Controller
{
    public function index()
    {
        $products = Product::join('product_images', 'product_images.product_id', '=', 'products.id')
        ->select('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.img', 'products.created_at')
        ->latest()
        ->paginate(8);

        return view('user.shopping', [
            'products'=>$products
        ]);
    }

    public function details($id)
    {
        $product = Product::join('product_images', 'product_images.product_id', '=', 'products.id')
        ->where('products.id', $id)
        ->select('products.id', 'products.name', 'products.slug', 'products.price', 'products.description', 'product_images.img', 'products.created_at')
        ->first();

        return view('user.product-details', [
            'product'=>$product
        ]);
    }

    public function category($id)
    {
        $categor = Category::find($id);
        $products = Product::join('product_images', 'product_images.product_id', '=', 'products.id')
        ->where('products.category_id', $id)
        ->select('products.id', 'products.name', 'products.slug', 'products.price', 'products.description', 'product_images.img', 'products.created_at')
        ->get();

        return view('user.category', [
            'products'=>$products,
            'categor'=>$categor
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

        $repeat = Cart::where('product_id', $id)->where('user_id', Auth::id())->first();
        if(!is_null($repeat))
        {
            $repeat->qty = $repeat->qty + 1;
            $repeat->save();
            return redirect()->back()->with('success', 'Product updated in cart succesfully');
        }else{
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

        if($cart->qty == 1)
        {
            $cart->delete();
            return redirect()->back()->with('success', 'product removed from cart successfully');
        }else{
            try{
                $cart->qty = $cart->qty-1;
                $cart->save();

            }catch(QueryException $e)
            {
                return redirect()->back()->with('error', $e);
            }

            return redirect()->back()->with('success', 'Quantity decreased successfully');
        }

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
