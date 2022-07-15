<?php

namespace App\Http\Controllers\transporter;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\Transporter;
use App\Models\WayPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $shipitems = [];
        $order = [];
        $origin = [];
        $checkpoint = [];

        $transporter = Transporter::where('user_id', Auth::id())->first();
        $shipment = Shipment::where('transporter_id', $transporter->id)
            ->whereNot('status', 4)
            ->first();

        if(!is_null($shipment)){
            $shipitems = OrderItem::where('order_id', $shipment->order_id)->get();
            $order = Order::find($shipment->order_id);
            $origin = \App\Models\CheckPoint::find($shipment->origin);
            $checkpoint = \App\Models\CheckPoint::find($shipment->next_point_id);
        }

        return view('transporter.dashboard',[
            'transporter'=>$transporter,
            'shipment'=>$shipment,
            'shipitems'=>$shipitems,
            'order'=>$order,
            'origin'=>$origin,
            'checkpoint'=>$checkpoint
        ]);
    }

    public function location($id)
    {
        $shipment = Shipment::find($id);

        return view('transporter.location', [
            'shipment'=>$shipment
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'shipment_id'=>'required|numeric',
            'lat'=>'required',
            'lon'=>'required',
            'address_address'=>'required'
        ]);

        //dd($request->lat.",".$request->lon);

        $shipment = Shipment::find($request->shipment_id);

        $waypoint = new WayPoint();
        $waypoint->shipment_id = $shipment->id;
        $waypoint->cords = $shipment->current_position;
        $waypoint->save();

        $shipment->current_position = $request->lat.",".$request->lon;
        $shipment->save();

        return redirect()->route('transporter-dashboard')->with('success', 'successfully updated location');
    }
}
