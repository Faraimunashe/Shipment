<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Consigner;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Null_;

class TrackController extends Controller
{
    public function index($id)
    {
        $orderitems = OrderItem::where('order_id', $id)->get();
        $shipment = Shipment::where('order_id', $id)->first();
        $order = Order::find($id);
        $consigner = Consigner::find($shipment->consigner_id);

        /* Distance And Time */
        // $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json?destinations='.$shipment->current_position.'&origins='.$shipment->origin.'&units=imperial&key=AIzaSyDsn-7y9P98peX7fZ3VoWVjK2fG1dh_sCs');
        // dd(json_decode($response));
        /* End Distance And Time */

        return view('user.track', [
            'order'=>$order,
            'orderitems'=>$orderitems,
            'shipment'=>$shipment,
            'consigner'=>$consigner
        ]);
    }
}
