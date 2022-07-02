<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(8);

        return view('welcome', [
            'products'=>$products
        ]);
    }
}
