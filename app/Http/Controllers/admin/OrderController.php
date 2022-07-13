<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CheckPoint;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Transporter;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        $transporters = Transporter::all();
        $points = CheckPoint::all();

        return view('admin.orders', [
            'orders'=>$orders,
            'transporters'=>$transporters,
            'points'=>$points
        ]);
    }

    public function ship(Request $request)
    {
        $request->validate([
            'transporter_id'=>'required|numeric',
            'order_id'=>'required|numeric',
            'next_point_id'=>'required|numeric',
            'origin'=>'required|string',
            'destination'=>'required|string',
            'current_position'=>'string'
        ]);

        $already = Shipment::where('order_id', $request->order_id)->first();
        if(is_null($already))
        {
            return redirect()->back()->with('error', 'Order already in shipment');
        }

        $shipment = new Shipment();
        $shipment->transporter_id = $request->transporter_id;
        $shipment->order_id = $request->order_id;
        $shipment->next_point_id = $request->next_point_id;
        $shipment->reference = rand(1111111111,9999999999);
        $shipment->origin = $request->origin;
        $shipment->destination = $request->destination;
        $shipment->current_position = $request->current_position;
        $shipment->departure = now();

        $shipment->save();

        $order = Order::find($request->order_id);
        $order->status = 'shipping';
        $order->save();

        return redirect()->back()->with('success', 'Successfully added order to shipment');
    }
}
