<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function getplans($currency){
        $plans = Plan::all();
        $newPrice = [];
        $url = 'https://freecurrencyapi.net/api/v2/latest?apikey=288252f0-760b-11ec-aba8-89d4dc9c8c3b&base_currency=NGN';
        

        $json = file_get_contents($url);
        $obj = json_decode($json, true);
        $data = $obj["data"];
        $rate = $data[$currency];

        foreach ($plans as $plan) {
            $price = $plan['Price'] * $rate;
            $plan['Price'] = number_format($price, 2);
            array_push($newPrice, $plan);
        }
        return response()->json($newPrice);
    }
}
