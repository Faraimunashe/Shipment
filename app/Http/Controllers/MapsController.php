<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index()
    {
        $gmaps = new \yidas\googleMaps\Client(['key'=>'AIzaSyDsn-7y9P98peX7fZ3VoWVjK2fG1dh_sCs']);
        $directionsResult = $gmaps->directions('National Palace Museum', 'Taipei 101', [
            'mode' => "transit",
            'departure_time' => time(),
        ]);

        //dd($directionsResult);
        return view('map');
    }
}
