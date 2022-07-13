<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CheckPoint;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CheckPointController extends Controller
{
    public function index()
    {
        $checkpoints = CheckPoint::all();
        $users = \App\Models\User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', '=', 2)
            ->get();

        return view('admin.checkpoints', [
            'checkpoints'=>$checkpoints,
            'users'=>$users
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'address'=>'required|string',
            'user_id'=>'required|numeric',
            'latitude'=>'required|string',
            'longitude'=>'required|string'
        ]);

        try{
            $point = new CheckPoint();

            $point->name = $request->name;
            $point->user_id = $request->user_id;
            $point->address = $request->address;
            $point->cordinates = $request->latitude.",".$request->longitude;

            $point->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully added a new check point!');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'point_id'=>'required|numeric',
            'name'=>'required|string',
            'address'=>'required|string',
            'user_id'=>'required|numeric',
            'latitude'=>'required|string',
            'longitude'=>'required|string'
        ]);

        $point = CheckPoint::find($request->point_id);
        if(is_null($point))
        {
            return redirect()->back()->with('error', 'cannot find specified check point');
        }

        try{
            $point->name = $request->name;
            $point->user_id = $request->user_id;
            $point->address = $request->address;
            $point->cordinates = $request->latitude.",".$request->longitude;
            $point->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully updated checkpoint!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'point_id'=>'required|numeric'
        ]);

        $point = CheckPoint::find($request->point_id);
        if(is_null($point))
        {
            return redirect()->back()->with('error', 'cannot find specified check point');
        }

        try{
            $point->delete();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully deleted checkpoint!');
    }
}
