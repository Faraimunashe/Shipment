<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Consigner;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index($id)
    {
        $orderitems = OrderItem::where('order_id', $id)->get();
        $shipment = Shipment::where('order_id', $id)->first();
        $order = Order::find($id);
        $consigner = Consigner::find($shipment->consigner_id);

        return view('user.track', [
            'order'=>$order,
            'orderitems'=>$orderitems,
            'shipment'=>$shipment,
            'consigner'=>$consigner
        ]);
    }
}
