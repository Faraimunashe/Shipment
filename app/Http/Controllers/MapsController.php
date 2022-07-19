<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index()
    {
        $ways = \App\Models\WayPoint::where('shipment_id', $shipment->id)->get();

        $gmaps = new \yidas\googleMaps\Client(['key'=>'AIzaSyDsn-7y9P98peX7fZ3VoWVjK2fG1dh_sCs']);
        $directionsResult = $gmaps->directions('Washington DC', 'New York City NY', [
            'units'=>'imperial'
        ]);

        dd($directionsResult);
        return view('map');
    }
}
