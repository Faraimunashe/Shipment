<?php

namespace App\Http\Controllers\transporter;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index()
    {
        $transporter = Transporter::where('user_id', Auth::id())->first();
        $shipments = Shipment::where('transporter_id', $transporter->id)
            ->get();
        return view('transporter.shipments', [
            'shipments'=>$shipments
        ]);
    }
}
