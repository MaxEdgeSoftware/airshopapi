<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json("Invalid login credentials", 406);
        }

        $user->generateToken();

        return response()->json($user);
    }

    public function register(Request $request){
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email|email',
            'referred_by' => 'nullable',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'referred_by' => $request->referred_by,
            'password' => Hash::make($request->password),
        ])->generateToken();

        return response()->json(['data'=> 'success'], 201);
    }


    public function resetPassword(Request $request, $key){
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if(!$user){
            return response()->json("login", 200);
        }

        $this->validate($request, [
            'password' => ['required', 'min:8'],
            'current_password' => 'required'
        ]);

        if(!Hash::check($request->current_password, $user->password)){
            return response()->json("password", 200);
        }

        $user->password = Hash::make($request->password);
        return response()->json(true, 200);
    }

    public function verify($key){
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if(!$user){
            return response()->json("login", 200);
        }

        //check fi verified 
        $Verified = Verification::where("user_email", $user->email)->first();
        $data = [
            "token" => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 10),
            "email" => $user->email,
        ];

        if ($Verified){
            $status = $Verified->status;
            if ($status == "true"){
                return response()->json("verified", 200);
            }else{
                $Verified->token = $data["token"];
                $Verified->save();
            }
        }else{
            Verification::create([
                "user_email" => $user->email,
                "token" => $data["token"],
                "status" => "false"
            ]);
        }

        Mail::to($user->email)->send(new VerificationMail($data));

        return response()->json($user, 200);
    }
    public function check($key){
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if(!$user){
            return response()->json("login", 200);
        }

        //check fi verified 
        $Verified = Verification::where("user_email", $user->email)->first();
        
        if ($Verified){
            $status = $Verified->status;
            if ($status == 'true'){
                return response()->json("verified", 200);
            }
        }

        return response()->json(true, 200);
    }
    public function verified(Request $request){
        $data= [];
        //check fi verified 
        $Verified = Verification::where("user_email", $request->email)->where("token", $request->token)->first();
        $data["user"] = User::where("email", $request->email)->first();
        if($Verified){
            $Verified->status = "true";
            $Verified->save();
            $data["status"] = "verified";
            return response()->json($data, 200);
        }
        $data["status"] = "invalid";
        return response()->json($data, 200);
    }
}
