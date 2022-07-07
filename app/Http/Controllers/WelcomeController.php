<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::join('product_images', 'product_images.product_id', '=', 'products.id')
        ->select('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.img', 'products.created_at')
        ->latest()
        ->paginate(8);

        return view('welcome', [
            'products'=>$products
        ]);
    }
}
