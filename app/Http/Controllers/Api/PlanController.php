<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function getplans($currency)
    {
        $plans = Plan::all();
        $newPrice = [];
        $url = 'https://freecurrencyapi.net/api/v2/latest?apikey=288252f0-760b-11ec-aba8-89d4dc9c8c3b&base_currency=NGN';


        // $json = file_get_contents($url);
        // $obj = json_decode($json, true);
        // $data = $obj["data"];
        // $rate = $data[$currency];

        foreach ($plans as $plan) {
            // $price = $plan['Price'] * $rate;
            // $plan['Price'] = $currency === "NGN" ? $price : number_format($price, 2);
            // $plan['Price'] = $price;
            array_push($newPrice, $plan);
        }
        return response()->json($newPrice);
    }

    public function getPlan($currency, $plan)
    {
        $plan = Plan::where("plan_id", $plan)->first();
        $data = [
            "status" => false,
        ];
        if ($plan) {
            // $url = 'https://freecurrencyapi.net/api/v2/latest?apikey=288252f0-760b-11ec-aba8-89d4dc9c8c3b&base_currency=NGN';

            $data["status"] = true;
            // $json = file_get_contents($url);
            // $obj = json_decode($json, true);
            // $data = $obj["data"];
            // $rate = $data[$currency];
            // $price = $plan['Price'] * $rate;
            $price = $plan['Price'];
            $plan['Price'] = number_format($price, 2);
        }

        $data["plan"] = $plan;
        return response()->json($data);
    }
}
