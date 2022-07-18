<?php

namespace App\Http\Controllers\courier;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Shipment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $courier = Courier::where('user_id', Auth::id())->first();
        if(is_null($courier))
        {
            return redirect()->route('courier-details')->with('error', 'Enter couriers details first!');
        }
        $shipments = Shipment::join('check_points', 'check_points.id', '=', 'shipments.next_point_id')
        ->join('orders', 'orders.id', '=', 'shipments.order_id')
        ->where('shipments.status', '!=', 4)
        ->where('shipments.courier_id', $courier->id)
        ->select('shipments.id','shipments.current_position', 'shipments.status', 'shipments.origin', 'shipments.reference', 'orders.status as ostatus','orders.code','orders.destination_name','shipments.order_id','check_points.name as nextstop', 'check_points.name as nextcordinates')
        ->get();

        return view('courier.dashboard', [
            'shipments' => $shipments
        ]);
    }

    public function details()
    {
        return view('courier.details');
    }

    public function add_details(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        try{
            $cor = new Courier();
            $cor->user_id = Auth::id();
            $cor->name = $request->name;
            $cor->pricing = $request->price;
            $cor->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('dashboard');
    }
}
