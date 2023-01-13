<?php

namespace App\Http\Controllers;

use App\Models\Entertainment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EntertainmentsController extends Controller
{
    /**
     * Display a listing of the Entertainments current user created.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entertainments =  Entertainment::where('userID',Auth::id())->orderBy('created_at', 'DESC')->get();

        $result = [];

        foreach($entertainments as $value){

            $entertainment = [
                "id" => $value->id,
                "name" => $value->name,
                "venue" =>$value->venue,
                "userID" => $value->userID,
                "startTime" =>  Carbon::parse($value->startTime)->format('Y-m-d H:i'),
                "endTime" => Carbon::parse($value->endTime)->format('Y-m-d H:i'),
                "eventDate" => Carbon::parse($value->eventDate)->format('Y-m-d'),
                "img_path" => $value->img_path,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at
            ];

            array_push($result,$entertainment);
        }
        
            return response()->json($result);
        

        
    }

    /**
     * Show the form for creating a new Entertainment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'venue'=>'required|string',
            'userID' => 'required|integer',
            'startTime'=>'required',
            'endTime'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $path = $request->image->store('postFlyer'); 
    
    
        Entertainment::create([
            'name' => $request->name,
            'venue' => $request->venue,
            'userID' => $request->userID,
            'img_path' => $path,
            'startTime' => strtotime($request->startTime),
            'endTime' => strtotime($request->endTime)
        ]);

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Display the specified Entertainment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entertainment = Entertainment::find($id);
        if(!$entertainment){
            return response()->json(['Entertainment not found'], Response::HTTP_NOT_FOUND);
        }
        return $entertainment;
    }

    /**
     * Show the form for editing the specified Entertainment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified Entertainment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request-> validate([
            'name' => 'required|string',
            'venue'=>'required|string',
            'startTime'=>'required',
            'endTime'=>'required',
            'eventDate'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        $entertainment = Entertainment::where('id',$id)->where('userID',Auth::id())->first();
        if(!$entertainment){
            return response()->json(['Entertainment not found'], Response::HTTP_NOT_FOUND);
        }

        $entertainment->name = $request['name'];
        $entertainment->venue = $request['venue'];
        $entertainment->startTime = $request['startTime'];
        $entertainment->endTime = $request['eventDate'];
        $path = $request->image->store('postFlyer');
        Storage::delete($entertainment->img_path);
        $entertainment->img_path = $path;
        $entertainment->save();

        return response()->json(['success' =>'updated successfully']);
    }

    /**
     * Remove the specified Entertainment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entertainment = Entertainment::where('id',$id)->where('userID',Auth::id())->first();

        if(!$entertainment){
            return response()->json(['Entertainment not found'], Response::HTTP_NOT_FOUND);
        }
        Storage::delete($entertainment->img_path);
        $entertainment->delete();

        return response()->json(['success' =>'deleted successfully']);
    }


    public function getImage($fileName)
    {
        if (Storage::exists('postFlyer/' . $fileName)) {

          return Storage::response('/postFlyer/' . $fileName);
        }
        else{
            return response()->json(['File not Found']);
        }
    }

    public function getEntertainment()
    {
        $entertainments =  DB::table("Entertainment")->orderBy('created_at', 'DESC')->get();

        $result = [];

        foreach($entertainments as $value){

            $entertainment = [
                "id" => $value->id,
                "name" => $value->name,
                "venue" =>$value->venue,
                "userID" => $value->userID,
                "startTime" =>  Carbon::parse($value->startTime)->format('Y-m-d H:i'),
                "endTime" => Carbon::parse($value->endTime)->format('Y-m-d H:i'),
                // "eventDate" => Carbon::parse($value->eventDate)->format('Y-m-d'),
                "img_path" => $value->img_path,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at
            ];

            array_push($result,$entertainment);
        }
        
            return response()->json($result);
    }
}
