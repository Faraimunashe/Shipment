<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories', [
            'categories'=>$categories
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string'
        ]);

        try{
            $category = new Category();

            $category->name = $request->name;
            $category->slug = $request->slug;

            $category->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully added a new product category!');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'category_id'=>'required|numeric',
            'name'=>'required|string',
            'slug'=>'required|string'
        ]);

        $category = Category::find($request->category_id);
        if(is_null($category))
        {
            return redirect()->back()->with('error', 'cannot find specified category');
        }

        try{
            $category->name = $request->name;
            $category->slug = $request->slug;

            $category->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully updated category!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'category_id'=>'required|numeric'
        ]);

        $category = Category::find($request->category_id);
        if(is_null($category))
        {
            return redirect()->back()->with('error', 'cannot find specified category');
        }

        try{
            $category->delete();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully deleted category!');
    }
}
