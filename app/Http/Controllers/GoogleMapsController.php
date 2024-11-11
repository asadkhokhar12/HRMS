<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GoogleMapsController extends Controller
{
public function getGeocodeData()
{
    $lat = '23.790977598078786';
    $lng = '90.40671785713647';

    return getGeocodeData($lat, $lng);
}

}
