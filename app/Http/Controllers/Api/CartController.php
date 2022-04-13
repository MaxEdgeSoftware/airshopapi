<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'product' => ['required'],
            'store' => ['required'],
            'user' => ['required'],
        ]);

        $product = Product::where('id', $request->product)->first();
        $qty = 1;
        $store = $request->store;
        $user = $request->user;
        $price = $qty * $product->Price;

        Cart::create([
            'product_id' => $product->id,
            'store_id' => $store,
            'user'=> $request->user,
            'qty' => $qty,
            'price' => $price,
            'cart_id' => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 30),
        ]);

        // $yourCart = $this->getCart($user, $store);

        return response()->json(true, 200);


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

    public function getCart($user, $store){
        $cart = Cart::with('product')->where('user', $user)->where('store_id', $store)->get();
        $data = [
            'cart' => $cart,
            'count' => $cart->count(),
            'sum' => $cart == null ? 0 : $cart->sum('price'),
        ];
        return $data;
    }

    public function deletecart(Request $request){

        Cart::with('product')->where('user', $request->user)->where('id', $request->item)->first()->delete();

        return response()->json(true, 200);
    }
    public function cartquantity(Request $request){
        $cart = Cart::with('product')->where('user', $request->user)->where('id', $request->item)->first();
        $cart->qty = $request->qty;
        $cart->price = $request->price * $request->qty;
        $cart->save();

        return response()->json(true, 200);
    }
}
