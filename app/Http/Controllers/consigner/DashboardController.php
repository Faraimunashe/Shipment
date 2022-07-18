<?php

namespace App\Http\Controllers\consigner;

use App\Http\Controllers\Controller;
use App\Models\Consigner;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $consigner = Consigner::where('user_id', Auth::id())->first();
        if(is_null($consigner))
        {
            return redirect()->route('consigner-details')->with('error', 'Enter consigners details first!');
        }
        $orders = Order::where('status', 'pending')
        ->where('consigner_id', $consigner->id)
        ->get();

        return view('consigner.dashboard', [
            'orders' => $orders
        ]);
    }

    public function start_shipping(Request $request)
    {
        $request->validate([
            'order_id' => 'required|numeric',
            'next_point_id' => 'required|numeric'
        ]);

        $consigner = Consigner::where('user_id', Auth::id())->first();
        $order = Order::find($request->order_id);
        try{
            $ship = new Shipment();
            $ship->consigner_id = $consigner->id;
            $ship->order_id = $request->order_id;
            $ship->next_point_id = $request->next_point_id;
            $ship->reference = rand(111111111,999999999);
            $ship->origin = "50.0377643,-5.6759337"; //PorthChapel Beach
            $ship->destination = $order->destination;
            $ship->current_position = "50.0377643,-5.6759337";
            $ship->status = 1;
            $ship->save();

            $order->status = "shipping";
            $order->save();

        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'successfully started shipment');
    }

    public function details()
    {
        return view('consigner.details');
    }

    public function add_details(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'regnum' => 'required|string',
            'price' => 'required|numeric'
        ]);

        try{
            $con = new Consigner();
            $con->user_id = Auth::id();
            $con->name = $request->name;
            $con->regnum = $request->regnum;
            $con->pricing = $request->price;
            $con->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('dashboard');
    }
}
