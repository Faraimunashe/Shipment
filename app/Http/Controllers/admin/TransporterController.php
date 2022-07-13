<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transporter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TransporterController extends Controller
{
    public function index()
    {
        $transporters = Transporter::all();
        $users = \App\Models\User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', '=', 3)
            ->get();

        return view('admin.transporters', [
            'transporters'=>$transporters,
            'users'=>$users
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'regnum'=>'required|string',
            'user_id'=>'required|numeric',
            'type'=>'required|string'
        ]);

        try{
            $transporter = new Transporter();

            $transporter->name = $request->name;
            $transporter->user_id = $request->user_id;
            $transporter->regnum = $request->regnum;
            $transporter->type = $request->type;

            $transporter->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully added a new transporter!');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'transporter_id'=>'required|numeric',
            'name'=>'required|string',
            'regnum'=>'required|string',
            'user_id'=>'required|numeric',
            'type'=>'required|string'
        ]);

        $transporter = Transporter::find($request->transporter_id);
        if(is_null($transporter))
        {
            return redirect()->back()->with('error', 'cannot find specified transporter');
        }

        try{
            $transporter->name = $request->name;
            $transporter->user_id = $request->user_id;
            $transporter->regnum = $request->regnum;
            $transporter->type = $request->type;
            $transporter->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully updated transporter!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'transporter_id'=>'required|numeric'
        ]);

        $transporter = Transporter::find($request->transporter_id);
        if(is_null($transporter))
        {
            return redirect()->back()->with('error', 'cannot find specified transporter');
        }

        try{
            $transporter->delete();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Successfully deleted transporter!');
    }
}
