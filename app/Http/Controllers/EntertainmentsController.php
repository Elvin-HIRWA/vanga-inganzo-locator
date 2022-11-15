<?php

namespace App\Http\Controllers;

use App\Models\Entertainment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntertainmentsController extends Controller
{
    /**
     * Display a listing of the Entertainments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Entertainment::all();
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
        $request-> validate([
            'name' => 'required|string',
            'venue'=>'required|string',
            'startTime'=>'required',
            'endTime'=>'required',
            'eventDate'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg|max:5048'
        ]);
        
        $path = $request->image->store('postFlyer'); 
    
    
        Entertainment::create([
            'name' => $request->name,
            'venue' => $request->venue,
            'userID' => Auth::id(),
            'img_path' => $path,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'eventDate' => $request->eventDate
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
}
