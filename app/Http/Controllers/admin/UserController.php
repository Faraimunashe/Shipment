<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users',[
            'users'=>$users
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'user_id'=>'required|numeric',
            'role'=>'required|numeric'
        ]);

        try{

            DB::select('UPDATE role_user SET role_id = "'.$request->role.'" WHERE user_id = ?', [$request->user_id]);

            return redirect()->back()->with('success', 'successfully updated user role');
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
