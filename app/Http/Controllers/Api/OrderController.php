<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Mail\OrderMailB;
use App\Models\Cart;
use App\Models\Market;
use App\Models\Order;
use App\Models\Orderbreakdown;
use App\Models\OrderShowroom;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user' => ['required'],
            'store' => ['required'],
            'Fullname' => 'required',
            'Email' => ['email', 'required'],
            'Phone' => 'required',
            'Address' => ['required'],
        ]);

        //get variables
        $store = Market::with('Vendor')->where('id', $request->store)->first();
        $storeEmail = $store->Vendor->email;
        
        $cart = Cart::with('product')->where('user', $request->user)->where('store_id', $request->store)->get();
        if($cart->count() == 0){
            return response()->json("cart", 200);
        }

        $shipment = 0;
        //comit order here
        $order = Order::create([
            'user' => $request->user,
            'market_id' => $request->store,
            'fullname' => $request->Fullname,
            'email' => $request->Email,
            'phone' => $request->Phone,
            'address' => $request->Address,
            'status' => 'pending',
            'order_id' => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20),
            'items' => $cart->count(),
            'totalamount' => $cart->sum('price') + $shipment,
        ]);

        //order breakdwon
        foreach ($cart as $item) {
            Orderbreakdown::create([
                'product_id' => $item->product->id,
                'order_id' => $order->id,
                'price' => $item->product->Price,
                'qty' => $item->qty,
            ]);
        }
        $BuyerMail = [
            'to' => $request->Email,
        ];

        $vendorMail = ['to' => $storeEmail];
        
        Mail::send(new OrderMailB($BuyerMail));

        Mail::send(new OrderMail($vendorMail));
        return response()->json(true, 200);
        //send mail to both parties
    }


    public function OrderPage(Request $request)
    {
        $this->validate($request, [
            'user' => ['required'],
            'store' => ['required'],
            'Fullname' => 'required',
            'Email' => ['email', 'required'],
            'Phone' => 'required',
            'Address' => ['required'],
            'Product' => ['required'],
            'Qty' => ['required'],
        ]);

        //get variables
        $store = Market::with('Vendor')->where('id', $request->store)->first();
        $storeEmail = $store->Vendor->email;
        $product = Product::where("id", $request->Product)->first();
        $shipment = 0;
        //comit order here
        $order = Order::create([
            'user' => $request->user,
            'market_id' => $request->store,
            'fullname' => $request->Fullname,
            'email' => $request->Email,
            'phone' => $request->Phone,
            'address' => $request->Address,
            'status' => 'pending',
            'order_id' => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20),
            'items' => 1,
            'totalamount' => $product->Price * $request->qty == null || $request->qty == ''  ? 1 : $request->qty,
        ]);

        //order breakdwon
        Orderbreakdown::create([
            'product_id' => $product->id,
            'order_id' => $order->id,
            'price' => $product->Price,
            'qty' => $request->qty == null || $request->qty == ''  ? 1 : $request->qty,
        ]);
        $BuyerMail = [
            'to' => $request->Email,
        ];

        $vendorMail = ['to' => $storeEmail];

        Mail::send(new OrderMailB($BuyerMail));

        Mail::send(new OrderMail($vendorMail));

        return response()->json(true, 200);
        //send mail to both parties
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function OrderShowroom(Request $request){
        $this->validate($request, [
            "user_fullname" => "required",
            "user_email" => "required|email",
            "user_tel" => "required",
            "user_ext" => "required",
            "user_address" => "required",
            "market_id" => "",
        ]);
        $order = OrderShowroom::create([
            "user_fullname" => $request->user_fullname,
            "user_email" => $request->user_email,
            "user_tel" => $request->user_tel,
            "user_ext" => $request->user_ext,
            "user_address" => $request->user_address,
            "market_id" => $request->market_id,
        ]);

        if($order){
            return response()->json(true, 200);
        }else{
            return response()->json(false, 200);
        }

    }
}
