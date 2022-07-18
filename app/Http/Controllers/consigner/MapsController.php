<?php

namespace App\Http\Controllers\consigner;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\WayPoint;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index($id)
    {
        $shipment = Shipment::find($id);

        return view('consigner.maps', [
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

        return redirect()->route('consigner-dashboard')->with('success', 'successfully updated location');
    }
}
