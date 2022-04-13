<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MessageMail;
use App\Models\Mails;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($key)
    {
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if (!$user) {
            return response()->json("login", 200);
        }

        $mails = Mails::with(['Messages', 'To', 'Sender'])->where("to", $user->email)->orderBy("updated_at", "DESC")->get();
        $data = [
            "mails" => $mails,
            "count" => $mails->count(),
        ];

        // return response()->json($mails, 200);
        return response()->json($data, 200);
    }

    public function getSent($key)
    {
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if (!$user) {
            return response()->json("login", 200);
        }

        $mails = Mails::with('Messages')->where("sender", $user->email)->orderBy('id', 'DESC')->get();

        foreach ($mails as $mail) {
            $mailMessages = $mail->Messages;
            $mail->dateUpdated = Carbon::createFromDate($mail->updated_at)->diffForHumans();
            foreach ($mailMessages as $mailMessage) {
                $mail->hasAttach = count($mailMessage->Attachments) > 0 ? true : false;
            }
        }
        return response()->json($mails, 200);
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
            'subject' => 'required',
            'emails' => 'required',
            'message' => 'required',
            'sender' => 'required',
        ]);


        $emails =  $request->emails;
        $emails = explode(",", $emails);
        foreach ($emails as $email) {


            $dMail = Mails::create([
                "subject" => $request->subject,
                "sender" => $request->sender,
                "to" => $email,
                "mail_id" => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 10),
            ]);

            $dMessage = Message::create([
                "mail_id" => $dMail->mail_id,
                "message_id" => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20),
                "text" => $request->message,
                "status" => "unread",
                "sent_by" => $request->sender
            ]);
            $data = [
                "subject" => $request->subject,
                "to" => $email,
                "sender" => $request->sender,
                "message" => $request->message,
                // "mail_id" => "t52iBw7pTa",
                // "message_id" => "ghQjaGL7JkVvU1NcTn59",
                "mail_id" => $dMail->mail_id,
                "message_id" => $dMessage->message_id,
                "url" => env('APP_URL') . "/dashboard/notification/" . $dMail->mail_id,
                // "url" => env('APP_URL') . "/dashboard/notification/t52iBw7pTa",
            ];
            if ($request->filesId) {
                $filesId = explode(",", $request->filesId);
                foreach ($filesId as $fileid) {
                    $file = $request->$fileid;
                    $path = $file->store("attachments", "public");
                    MessageAttachment::create([
                        "message_id" => $dMessage->message_id,
                        // "message_id" => $data["message_id"],
                        "file" => $path
                    ]);
                }
            }
            // Mail::send(new MessageMail($data));
        }

        return false;
        return response()->json(true, 200);
    }


    public function store2(Request $request, $mailid)
    {
        $this->validate($request, [
            'message' => 'required',
            'sender' => 'required',
        ]);


        // getuser
        $user = User::where("api_token", $request->sender)->first();

        if (!$user) {
            return response()->json(false, 200);
        }

        // get mails
        $dMail = Mails::where("mail_id", $mailid)->first();

        if (!$dMail) {
            return response()->json(false, 200);
        }

        // add message
        $dMessage = Message::create([
            "mail_id" => $dMail->mail_id,
            "message_id" => substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20),
            "text" => $request->message,
            "status" => "unread",
            "sent_by" => $user->email
        ]);

        $email = "";
        if ($dMail->to == $user->email) {
            $email = $dMail->sender;
        } else {
            $email = $dMail->to;
        }
        $data = [
            "subject" => $dMail->subject,
            "to" => $email,
            "sender" => $user->email,
            "message" => $request->message,
            // "mail_id" => "t52iBw7pTa",
            // "message_id" => "ghQjaGL7JkVvU1NcTn59",
            "mail_id" => $dMail->mail_id,
            "message_id" => $dMessage->message_id,
            "url" => env('APP_URL') . "/dashboard/notification/" . $dMail->mail_id,
            // "url" => env('APP_URL') . "/dashboard/notification/t52iBw7pTa",
        ];
        if ($request->filesId) {
            $filesId = explode(",", $request->filesId);
            foreach ($filesId as $fileid) {
                $file = $request->$fileid;
                $path = $file->store("attachments", "public");
                MessageAttachment::create([
                    "message_id" => $dMessage->message_id,
                    // "message_id" => $data["message_id"],
                    "file" => $path
                ]);
            }
        }
        Mail::send(new MessageMail($data));

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


    public function getMail($mailid, $apikey)

    {
        $user = User::with("Store")->where("api_token", $apikey)->first();
        $mail = Mails::with(['Messages', 'Sender', 'To'])->where("mail_id", $mailid)->first();
        $mailMessages = $mail->Messages;
        $ml = $mailMessages->last();

        // if sent by is not me, then set everything to read
        if ($ml->sent_by != $user->email) {
            foreach ($mailMessages as $mailMessage) {
                $mailMessage->status = 'read';
                $mailMessage->save();
            }
        }

        foreach ($mailMessages as $mailMessage) {
            $mail->hasAttach = count($mailMessage->Attachments) > 0 ? true : false;
            $mailMessage->ddate = Carbon::createFromDate($mailMessage->created_at)->diffForHumans();
        }
        $mail->thisuser = $user;
        return response()->json($mail, 200);
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
}
