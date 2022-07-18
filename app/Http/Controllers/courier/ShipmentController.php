<?php

namespace App\Http\Controllers\courier;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Shipment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
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
        ->where('shipments.courier_id', $courier->id)
        ->select('shipments.id','shipments.current_position', 'shipments.status', 'shipments.origin', 'shipments.reference', 'orders.status as ostatus','orders.code','orders.destination_name','shipments.order_id','check_points.name as nextstop', 'check_points.name as nextcordinates')
        ->get();

        return view('courier.shipments', [
            'shipments' => $shipments
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'shipment_id'=>'required|numeric',
            'status'=>'required|numeric'
        ]);

        try{
            $shipment = Shipment::find($request->shipment_id);
            $shipment->status = $request->status;
            $shipment->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'successfully updated status');
    }
}
