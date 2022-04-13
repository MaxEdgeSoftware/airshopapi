<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\PasswordResetn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
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
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json('invalid', 200);
        }
        $password = PasswordResetn::create([
            'token' => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 60),
            'user_id' => $user->id,
            'status' => 'Open',
        ]);
        $data = [
            'email' => $request->email,
            'name' => $user->first_name,
            'token' => $password->token,
        ];

        Mail::to($request->email)->send(new PasswordReset($data));
        return response()->json(true, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        // $thistoken = PasswordResetn::with('user')->where('token', $token)->first();
        $thistoken = PasswordResetn::where('token', $token)->where('status', 'Open')->first();
        if(!$thistoken){
            return response()->json('invalid', 200);
        }

        return response()->json(true, 200);
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
    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => ['confirmed', 'required', 'min:8'],
            'token' => 'required',
        ]);
        $thistoken = PasswordResetn::with('user')->where('token', $request->token)->first();
        if(!$thistoken){
            return response()->json('invalid', 200);
        }
        $user = $thistoken->user->id;
        $user= User::where('id', $user)->first();
        $user->password = Hash::make($request->password);
        $thistoken->status = 'Close';
        $user->save();
        $thistoken->save();
        return response()->json('done', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }
}
