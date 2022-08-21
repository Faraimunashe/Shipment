<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\BillingAddress;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Consigner;
use Illuminate\Support\Facades\Session;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->get();
        $consigners = Consigner::all();

        return view('user.checkout', [
            'cart'=>$cart,
            'consigners'=>$consigners
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'firstname'=>'required|string',
            'lastname'=>'required|string',
            'email'=>'required|string',
            'phone'=>'required|digits:10',
            'addr1'=>'required|string',
            'addr2'=>'required|string',
            'country'=>'required|string',
            'city'=>'required|string',
            'state'=>'required|string',
            'zip'=>'required|numeric',
            'gtotal'=>'required',
            'consigner_id'=>'required',
            'total'=>'required',
        ]);

        $consigner = Consigner::find($request->consigner_id);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->consigner_id = $consigner->id;
        $order->code = rand(11111111, 99999999);
        $order->sub_total = $request->gtotal;
        $order->consigner_fee = $consigner->pricing;
        $order->total = $request->gtotal + $consigner->pricing;
        $order->status = "missing address";
        $order->save();

        $address = new BillingAddress();
        $address->user_id = Auth::id();
        $address->order_id = $order->id;
        $address->firstname = $request->firstname;
        $address->lastname = $request->lastname;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->addr1 = $request->addr1;
        $address->addr2 = $request->addr2;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip = $request->zip;
        $address->save();

        foreach(Cart::where('user_id', Auth::id())->get() as $item)
        {
            $product = Product::find($item->product_id);
            $oitem = new OrderItem();

            $oitem->order_id = $order->id;
            $oitem->product_name = $product->name;
            $oitem->qty = $item->qty;
            $oitem->price = $product->price;
            $oitem->total = $item->qty * $product->price;
            $oitem->save();

            //$item->delete();
        }

        //Session::put('shipping_order_id', $order->id);

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user-shipping', $order->id)->with('success', 'Add shipping address');
    }

    public function myorders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('user.orders', [
            'orders'=>$orders
        ]);
    }

    public function report($order_id)
    {
        $order = Order::find($order_id);

        $items = OrderItem::where('order_id', $order_id)->get();

        $pdf = PDF::loadView('pdf.order', [
            'order' => $order,
            'items' => $items
        ]);
        return $pdf->download(now().'report.pdf');
    }
}
