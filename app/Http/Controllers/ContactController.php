<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OfferMail;

class ContactController extends Controller
{
    public function contact(){
        return view('client.pages.contact');
    }
    public function postContact(ContactRequest $request){
        $data = [
            'topic' => $request->topic,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->content
        ];        
        Mail::send('email.contact', $data, function($message) use($request){
                $message->to('vuonglqph12301@fpt.edu.vn', 'Polylib');
                $message->from($request->email, $request->name);
                $message->subject($request->topic);
        });
        return redirect(route('contact'))->with('message', 'Gửi thành công !');
    }

}
