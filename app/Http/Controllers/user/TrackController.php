<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index($id)
    {
        $orderitems = OrderItem::where('order_id', $id)->get();
        $shipment = Shipment::where('order_id', $id)->first();
        return view('user.track', [
            'orderitems'=>$orderitems,
            'shipment'=>$shipment
        ]);
    }
}
