<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all movie list
        return Movie::select('id','title','description','image')->get();
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
        //Store new movie
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'image'=>'required|image'
        ]);

        try {
            $imageName = $request->image.'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $request->image,$imageName);
            Movie::create($request->post()+['image'=>$imageName]);
            return response()->json([
                'message'=>'Movie Created Successfully!!'
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while creating a product!!'
                ],500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //Return specific movie
        return response()->json([
            'product'=>$movie
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //Update specific movie
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'image'=>'nullable'
        ]);

        try{
            $movie->fill($request->post())->update();
            if($request->hasFile('image')){
                // remove old image
                if($movie->image){
                    $exists = Storage::disk('public')->exists("product/image/{$movie->image}");
                    if($exists){
                        Storage::disk('public')->delete("product/image/{$movie->image}");
                    }
                }
            $imageName =$request->image.'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $request->image,$imageName);
            $movie->image = $imageName;
            $movie->save();
            }
            return response()->json([
                'message'=>'Movie Updated Successfully!!'
            ]);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while updating a movie!!'
                ],500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        try {
            if($movie->image){
                $exists = Storage::disk('public')->exists("product/image/{$movie->image}");
                if($exists){
                    Storage::disk('public')->delete("product/image/{$movie->image}");
                }
            }
            $movie->delete();
            return response()->json([
                'message'=>'Movie Deleted Successfully!!'
            ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while deleting a movie!!'
                ]);
            }
    }
}
