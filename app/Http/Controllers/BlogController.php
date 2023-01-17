<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return BlogPost::all();
    // }

    public function index()
    {
        $blogs =  BlogPost::where('userID',Auth::id())->orderBy('created_at', 'DESC')->get();

        $result = [];

        foreach($blogs as $value){

            $blog = [
                "id" => $value->id,
                "title" => $value->title,
                "description" =>$value->description,
                "userID" => $value->userID,
                "image_path" => $value->image_path,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at
            ];

            array_push($result,$blog);
        }
        
            return response()->json($result);
        

        
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
        {
            $request-> validate([
                'title' => 'required|string',
                'description'=>'required|string',
                'image'=>'required|mimes:jpg,png,jpeg|max:5048'
            ]);
            
            $path = $request->image->store('blogPost'); 
        
        
            BlogPost::create([
                'title' => $request->title,
                'description' => $request->description,
                'userID' => Auth::id(),
                'image_path' => $path,
            ]);
    
            return response()->json(['success' => true], Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogPost = BlogPost::find($id);
        if(!$blogPost){
            return response()->json(['blogPost not found'], Response::HTTP_NOT_FOUND);
        }
        return $blogPost;
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
            'description'=>'required|string',
            'image.*'=>'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        $blogPost = BlogPost::where('id',$id)->where('userID',Auth::id())->first();
        if(!$blogPost){
            return response()->json(['blogPost not found'], Response::HTTP_NOT_FOUND);
        }

        $blogPost->title = $request['title'];
        $blogPost->description = $request['description'];
        $path = $request->image->store('blogPost');
        Storage::delete($blogPost->image_path);
        $blogPost->image_path = $path;
        $blogPost->save();

        return response()->json(['success' =>'updated successfully'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogPost = BlogPost::where('id',$id)->where('userID',Auth::id())->first();

        if(!$blogPost){
            return response()->json(['blogPost not found'], Response::HTTP_NOT_FOUND);
        }
        Storage::delete($blogPost->image_path);
        $blogPost->delete();

        return response()->json(['success' =>'deleted successfully']);
    }

    public function getImage($fileName)
    {
        if (Storage::exists('blogPost/' . $fileName)) {

          return Storage::response('/blogPost/' . $fileName);
        }
        else{
            return response()->json(['File not Found']);
        }
    }

    public function getBlog()
    {
        // $entertainments =  DB::table("BlogPost")
        // ->orderBy('created_at', 'DESC')->get();
// dd($entertainments );
        $result = [];

        $entertainments = DB::select("SELECT a.*, b.name AS userName
        FROM BlogPost AS a
        INNER JOIN User AS b
        ON a.userID = b.id");

        foreach($entertainments as $value){

            $entertainment = [
                "id" => $value->id,
                "title" => $value->title,
                "description" =>$value->description,
                "userID" => $value->userID,
                "image_path" => $value->image_path,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
                "month" => Carbon::parse($value->created_at)->format('M'),
                "day" => Carbon::parse($value->created_at)->format('d'),
                "year" => Carbon::parse($value->created_at)->format('y'),
                "userName" => $value->userName,
            ];

            array_push($result,$entertainment);
        }
        
            return response()->json($result);
    }
}
