<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return view('admin.products', [
            'products'=>$products
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'category_id'=>'required|numeric',
            'name'=>'required|string',
            'slug'=>'required|string',
            'price'=>'required|numeric',
            'description'=>'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);
        /* Store $imageName name in DATABASE from HERE */
        try{
            $product = new Product();
            $product_image = new ProductImage();

            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->save();

            $product_image->img = $imageName;
            $product_image->product_id = $product->id;
            $product_image->save();

        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success','You have successfully added new product.');
    }
}
