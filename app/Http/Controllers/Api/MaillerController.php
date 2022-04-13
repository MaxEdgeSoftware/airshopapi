<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SupportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MaillerController extends Controller
{
    public function support(Request $request){
        $this->validate($request,[
            'Email' => 'required|email',
            'Message' => 'required',
            'Fullname' => 'required',
            'Business_Name' => 'required',
            'Telephone' => 'required',
        ]);

        $data = [
            'email' => $request->Email,
            'message' => $request->Message,
            'name' => $request->Fullname,
            'businessname' => $request->Business_Name,
            'phone' => $request->Telephone,
        ];
        Mail::to('support@airshop247.com')->send(new SupportMail($data));
        return response()->json(true, 200);
    }
}
