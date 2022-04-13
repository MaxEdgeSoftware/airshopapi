<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function fetchStore($key){
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if(!$user){
            return response()->json("login", 200);
        }
        $store = Market::where('user_id', $user->id)->first();

        if($store){

            $subs = $store->Subscriptions;
            if(count($subs) == 0){
                $subsController = new SubscriptionController();
                $subsController->addSubs($store, 1);
            }

            $subs = $store->Subscriptions;
            foreach ($subs as $sub) {
                $subdate = $sub->created_at;
                $subdate = date_format($subdate, 'd-M-Y');
                $dd = date_create($sub->Due_date);
                $Due_date = date_format($dd, 'd-M-Y');
                $sub['plan'] = Plan::where('id', $sub->plan_id)->first();
                $sub['sub_date'] = $subdate;
                $sub['Due_date'] = $Due_date;
                $sub['status'] = $dd > Carbon::now() ? 'Open' : 'Expired';
            }
        }
        $data = [
            'user' => $user,
            'store' => $store,
            'subscriptions' => $store == null ? null : $store->Subscriptions,
        ];
        return response()->json($data, 200);
    }

    public function fetchStore2($api, $key){
        $user = User::where('api_token', $api)->first();
        // $user = User::where('api_token', "test")->first();
        if(!$user){
            return response()->json("login", 200);
        }
        $shop = Market::where('Shop_id', $key)->first();
        $data = [];
        if(!$shop){
            $data = [
                'store' => null
            ];
            return response()->json($data, 200);
        }

        if($shop){

            $subs = $shop->Subscriptions;
            if(count($subs) == 0){
                $subsController = new SubscriptionController();
                $subsController->addSubs($shop, 1);
            }

            $subs = $shop->Subscriptions;
            foreach ($subs as $sub) {
                $subdate = $sub->created_at;
                $subdate = date_format($subdate, 'd-M-Y');
                $dd = date_create($sub->Due_date);
                $Due_date = date_format($dd, 'd-M-Y');
                $sub['plan'] = Plan::where('id', $sub->plan_id)->first();
                $sub['sub_date'] = $subdate;
                $sub['Due_date'] = $Due_date;
                $sub['status'] = $dd > Carbon::now() ? 'Open' : 'Expired';
            }
        }
        $data = [
            'store' => $shop,
            'subscriptions' => $shop == null ? null : $shop->Subscriptions,
            'products' => $shop == null ? null : $shop->Products,
            'orders' => $shop == null ? null : $shop->Orders,
        ];
        return response()->json($data, 200);
    }

    public function addStore(Request $request){
        $this->validate($request, [
            'Name' => ['required'],
            'Phone' => ['numeric', 'required'],
            'PhoneExt' => ['required'],
            'Description' => ['required'],
            'api_key' => '',
            'currency' => 'required',
            'country' => 'required',
        ]);

        $user = User::where('api_token', $request->api_key)->first();
        // $user = User::where('api_token', "test")->first();
        if(!$user){
            return response()->json("login", 200);
        }

        $shopExist = Market::where('Name', $request->Name,)->first();
        if ($shopExist){
            return response()->json("shop", 200);
        }

        $slug =Str::slug($request->Name);


        $store = Market::create([
            'Name' => $request->Name,
            'Slug' => $slug,
            'Phone' => $request->Phone,
            'PhoneExt' => $request->PhoneExt,
            'Description' => $request->Description,
            'user_id' => $user->id,
            'currency' => $request->currency,
            'country' => $request->country,
            'Shop_id' => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20),
        ]);
        $subs = new SubscriptionController();
        $subs->addSubs($store, 1);
        return response()->json($store, 200);
    }

    public function addLogo (Request $request){
        $this->validate($request, [
            'logo' => ['required', 'file'],
            'shop' => ''
        ]);

        $shop = Market::where('id', $request->shop)->first();
        if(!$shop){
            return response()->json("invalid", 200);
        }
        $path = $request->file('logo')->store('logos', 'public');
        $shop->Logo = $path;
        $shop->save();
        return response()->json(true, 200);
    }

    public function addBanner (Request $request){
        $this->validate($request, [
            'banner' => ['required', 'file'],
            'shop' => ''
        ]);

        $shop = Market::where('id', $request->shop)->first();
        if(!$shop){
            return response()->json("invalid", 200);
        }
        $path = $request->file('banner')->store('banners', 'public');
        $shop->Banner = $path;
        $shop->save();
        return response()->json(true, 200);
    }

    public function addDescription (Request $request){
        $this->validate($request, [
            'Description' => ['required'],
            'shop' => '',
        ]);

        $shop = Market::where('id', $request->shop)->first();
        if(!$shop){
            return response()->json("invalid", 200);
        }
        $shop->Description = $request->Description;
        $shop->save();
        return response()->json(true, 200);
    }

    public function updateStore(Request $request){

        $this->validate($request, [
            'Name' => ['required'],
            'Address' => ['required'],
            'FacebookName' => ['required'],
            'WhatsappNo' => ['required'],
            'WhatsppNoExt' => ['required'],
            'FacebookLink' => ['required','url'],
            'InstagramLink' => ['required', 'url'],
            'InstagramName' => ['required'],
            'Description' => ['required'],
            'Shop' => [''],
        ]);

        $shop = Market::where('id', $request->Shop)->first();
        if(!$shop){
            return response()->json("invalid", 200);
        }

        $shop->Name = $request->Name;
        $shop->Address = $request->Address;
        $shop->FacebookName = $request->FacebookName;
        $shop->WhatsappNo = $request->WhatsappNo;
        $shop->WhatsppNoExt = $request->WhatsppNoExt;
        $shop->FacebookLink = $request->FacebookLink;
        $shop->InstagramLink = $request->InstagramLink;
        $shop->InstagramName = $request->InstagramName;
        $shop->Description = $request->Description;
        $shop->save();
    }


    public function addContact (Request $request){

        $this->validate($request, [
            'Address' => ['required'],
            'FacebookName' => ['required'],
            'WhatsappNo' => ['required'],
            'WhatsppNoExt' => ['required'],
            'FacebookLink' => ['required','url'],
            'InstagramLink' => ['required', 'url'],
            'InstagramName' => ['required'],
            'shop' => [''],
        ]);

        $shop = Market::where('id', $request->shop)->first();
        if(!$shop){
            return response()->json("invalid", 200);
        }
        $shop->Address = $request->Address;
        $shop->FacebookName = $request->FacebookName;
        $shop->WhatsappNo = $request->WhatsappNo;
        $shop->WhatsppNoExt = $request->WhatsppNoExt;
        $shop->FacebookLink = $request->FacebookLink;
        $shop->InstagramLink = $request->InstagramLink;
        $shop->InstagramName = $request->InstagramName;
        $shop->save();
    }








    // visit
    public function fetchStoreVisit($key){

        $store = Market::with('Vendor')->where('Slug', $key)->first();

        if($store){
            $subs = $store->Subscriptions;
            if(count($subs) == 0){
                $subsController = new SubscriptionController();
                $subsController->addSubs($store, 1);
            }

            $subs = $store->Subscriptions;
            foreach ($subs as $sub) {
                $subdate = $sub->created_at;
                $subdate = date_format($subdate, 'd-M-Y');
                $dd = date_create($sub->Due_date);
                $Due_date = date_format($dd, 'd-M-Y');
                $sub['plan'] = Plan::where('id', $sub->plan_id)->first();
                $sub['sub_date'] = $subdate;
                $sub['Due_date'] = $Due_date;
                $sub['status'] = $dd > Carbon::now() ? 'Open' : 'Expired';
            }
        }
        $data = [
            'store' => $store,
            'subscriptions' => $store == null ? null : $store->Subscriptions,
            'products' => $store == null ? null : $store->Products,
            // 'productcount' => $store == null && $store->Products == null ? 0 : $store->Products->count(),
        ];
        return response()->json($data, 200);
    }
}
