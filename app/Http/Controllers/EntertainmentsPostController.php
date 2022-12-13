<?php

namespace App\Http\Controllers;

use App\Models\EntertainmentsPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntertainmentsPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EntertainmentsPost::all()->paginate(10);
             
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
        $request-> validate([
            'title' => 'required|string',
            'youtubeLink' => 'required|string|min:20|max:80'
        ]);
        
            if (!strpos($request->youtubeLink, 'youtube.com/')) {
                return ['invalid youtube url'];
            } 

        EntertainmentsPost::create([
            'title' => $request->title,
            'userID' => Auth::id(),
            'url' => $request->youtubeLink
        ]);

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entertainmentPost = EntertainmentsPost::find($id);
        if(!$entertainmentPost){
            return response()->json(['Entertainment not found'], Response::HTTP_NOT_FOUND);
        }
        return $entertainmentPost;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request-> validate([
            'title' => 'required|string',
            'youtubeLink' => 'required|string|min:20|max:80'
        ]);

        $entertainmentPost = EntertainmentsPost::where('id',$id)->where('userID',Auth::id())->first();
        if(!$entertainmentPost){
            return response()->json(['Entertainment not found'], Response::HTTP_NOT_FOUND);
        }

        $entertainmentPost->name = $request['title'];
        $entertainmentPost->youtubeLink = $request['youtubeLink'];
        $entertainmentPost->save();

        return response()->json(['success' =>'updated successfully']);
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

    public function getVideo($fileName)
    {
        $videoSrc = "";

        $video = EntertainmentsPost::where();

        $videoSrc = '' . explode('watch?v=', $video->url)[1];

        return response()->json(['src' => $videoSrc]);

    }
}
