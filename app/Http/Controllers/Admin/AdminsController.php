<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);


        $user = User::where("email", $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json("Invalid login credentials", 201);
        }

        $user->generateToken();

        return response()->json($user);
    }
    
    public function getEmails(){
        $emails = User::where("email", '!=', "admin@airshop247.com")->get("email");
        return response()->json($emails, 200);
    }
}
