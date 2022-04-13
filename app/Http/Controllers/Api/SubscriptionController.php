<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function addSubs(Market $market, $plan){
        $date = Carbon::now();
        Subscription::create([
            'market_id'=>$market->id,
            'plan_id'=>$plan,
            'Due_date'=>$date->addMonth(1),
        ]);
        return true;
    }
}
