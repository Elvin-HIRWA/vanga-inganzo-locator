<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the Entertainments current user created.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages =  DB::table("Message")->orderBy('created_at', 'DESC')->get();

        $result = [];

        foreach($messages as $value){

            $message = [
                "id" => $value->id,
                "name" => $value->name,
                "email" =>$value->email,
                "subject" => $value->subject,
                "message" =>  $value->message,
            ];

            array_push($result,$message);
        }
        
            return response()->json($result);
        

        
    }

     /**
     * Store a newly created Entertainment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string',
            'email'=>'required|string',
            'subject' => 'required|string',
            'message'=>'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }    
    
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return response()->json(['success' => true], Response::HTTP_OK);
    }
}
