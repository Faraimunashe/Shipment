<?php

namespace App\Http\Controllers\consigner;

use App\Http\Controllers\Controller;
use App\Models\Consigner;
use App\Models\Shipment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function transit()
    {
        $consigner = Consigner::where('user_id', Auth::id())->first();
        if(is_null($consigner))
        {
            return redirect()->route('consigner-details')->with('error', 'Enter consigners details first!');
        }
        $shipments = Shipment::join('check_points', 'check_points.id', '=', 'shipments.next_point_id')
        ->join('orders', 'orders.id', '=', 'shipments.order_id')
        ->where('shipments.status', 1)
        ->where('shipments.consigner_id', $consigner->id)
        ->select('shipments.id','shipments.current_position', 'shipments.status','shipments.courier_id', 'shipments.origin', 'shipments.reference', 'orders.status as ostatus','orders.code','orders.destination_name','shipments.order_id','check_points.name as nextstop', 'check_points.name as nextcordinates')
        ->get();

        return view('consigner.transit', [
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

    public function add(Request $request)
    {
        $request->validate([
            'shipment_id'=>'required|numeric',
            'courier_id'=>'required|numeric'
        ]);

        try{
            $shipment = Shipment::find($request->shipment_id);
            $shipment->courier_id = $request->courier_id;
            $shipment->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'successfully courier to shipment');
    }

    public function warehouse()
    {
        $consigner = Consigner::where('user_id', Auth::id())->first();
        if(is_null($consigner))
        {
            return redirect()->route('consigner-details')->with('error', 'Enter consigners details first!');
        }
        $shipments = Shipment::join('check_points', 'check_points.id', '=', 'shipments.next_point_id')
        ->join('orders', 'orders.id', '=', 'shipments.order_id')
        ->where('shipments.status', 2)
        ->where('shipments.consigner_id', $consigner->id)
        ->select('shipments.id','shipments.current_position', 'shipments.status','shipments.courier_id', 'shipments.origin', 'shipments.reference', 'orders.status as ostatus','orders.code','orders.destination_name','shipments.order_id','check_points.name as nextstop', 'check_points.name as nextcordinates')
        ->get();

        return view('consigner.warehouse', [
            'shipments' => $shipments
        ]);
    }

    public function delivered()
    {
        $consigner = Consigner::where('user_id', Auth::id())->first();
        if(is_null($consigner))
        {
            return redirect()->route('consigner-details')->with('error', 'Enter consigners details first!');
        }
        $shipments = Shipment::join('check_points', 'check_points.id', '=', 'shipments.next_point_id')
        ->join('orders', 'orders.id', '=', 'shipments.order_id')
        ->where('shipments.status', 4)
        ->where('shipments.consigner_id', $consigner->id)
        ->select('shipments.id','shipments.current_position', 'shipments.status', 'shipments.origin', 'shipments.reference', 'orders.status as ostatus','orders.code','orders.destination_name','shipments.order_id','check_points.name as nextstop', 'check_points.name as nextcordinates')
        ->get();

        return view('consigner.delivered', [
            'shipments' => $shipments
        ]);
    }
}
