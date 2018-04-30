<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllTimeHighController extends Controller
{

    public function get(Request $request) {
        $servername = "127.0.0.1";
        $username = "admin";
        $password = "";
        $db = "test";
        console.logger('here');
        return redirect('/getalltimehighs.index')->with('success', "Message Sent");
    }

        // Create connection
 //       $conn = new mysqli($servername, $username, $password, $db);
/*
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
*/
     //   echo "Connected successfully";
/*
        $sql = "SELECT ticker FROM all_time_highs";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                "<td>". $row["ticker"]."</td>";
                "<td><img src='https://finviz.com/chart.ashx?ty=c&ta=0&p=d&s=l&t=$row[ticker]' /></td>";
            }
        } else {
            echo "0 results";
        }
*/
       // $conn->close();


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
