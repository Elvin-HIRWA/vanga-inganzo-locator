<?php

namespace App\Http\Controllers;

use App\Models\Entertainment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntertainmentsController extends Controller
{
    /**
     * Display a listing of the Entertainments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'userID' => auth()->user()->id,
            'img_path' => $path,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'EventDate' => $request->EventDate
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
        //
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
        //
    }

    /**
     * Remove the specified Entertainment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
