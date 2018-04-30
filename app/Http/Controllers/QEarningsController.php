<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QEarningsControllerController extends Controller
{

    public function get(Request $request) {
        $servername = "127.0.0.1";
        $username = "admin";
        $password = "";
        $db = "test";
        console.logger('here');
        return redirect('/getalltimehighs')->with('success', "Message Sent");
    }

    public function submit(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required'
        ]);

        $message = new Message();
        $message->name = $request->input('name');
        $message->role = $request->input('role');
        $message->email = $request->input('email');

        $message->save();

        return redirect('/home')->with('success', "Message Sent");
    }

    public function getMessages(){
        $messages = Message::all();
        return view('messages')->with('messages', $messages);


    }



}
