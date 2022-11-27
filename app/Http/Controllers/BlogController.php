<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BlogPost::all();
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
            
            return response()->file(storage_path('/app/blogPost/' . $fileName));
            
        }
        else{
            return response()->json(['File not Found']);
        }
    }
}
