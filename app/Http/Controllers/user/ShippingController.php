<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Consigner;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\ShippingConsigner;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShippingController extends Controller
{
    public function index($order_id)
    {
        //$order_id = Session::get('shipping_order_id');
        $order = Order::find($order_id);

        return view('user.shipping-address', [
            'order'=>$order
        ]);
    }

    public function shipping(Request $request)
    {
        $request->validate([
            'order_id'=>'required|numeric',
            'lon'=>'required|numeric',
            'lat'=>'required|numeric',
            'address_address'=>'required|string'
        ]);

        try{
            $order = Order::find($request->order_id);
            $order->destination = $request->lat.",".$request->lon;
            $order->destination_name = $request->address_address;
            $order->status = "pending";
            $order->save();

            $shipping = new ShippingAddress();
            $shipping->order_id = $request->order_id;
            $shipping->address = $request->address_address;
            $shipping->cordinates = $request->lat.",".$request->lon;
            $shipping->save();
        }catch(QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }


        return redirect()->route('user-shopping')->with('success', 'Thank you for buying here, please buy again');
    }

}
