<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all bookings
        // $bookings = Booking::all();
        // return response()->json([
        //     'Success'=> true,
        //     'data'=> $bookings
        // ]);

        $bookings = Booking::with('showtime')->get();
        foreach($bookings as $booking){
            $booking->movie = Movie::select('id','title','description','price')->firstWhere('id',$booking->showtime->movie_id);
        }
        return response()->json([
                'Success'=> true,
                'data'=> $bookings
                ]);
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
        //Store new Booking
        $request->validate([
                        'showtime_id'=>'required',
                        'name'=>'required',
                        'phone_no'=>'required|regex:/^01[0-9]{1}[0-9]{7,8}$/',
                        'quantity'=>'required',
                        'total'=>'required|numeric'
                    ]);
        
        try {
            Booking::create($request->post());
            return response()->json([
                "message"=>"Booking created successfully"
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something went wrong while creating a movie',
                'error'=> $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //Get specific booking
        if(is_null($booking)){
            return response()->json([
                "success"=>false,
                "message"=> "Unable to retreive booking details (Not found)"
            ]);
        }

        return response()->json([
            "success"=>true,
            "data"=> $booking
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //Update specific booking
        $request->validate([
            'showtime_id'=>'required',
            'name'=>'required',
            'phone_no'=>'required|regex:/^01[0-9]{1}[0-9]{7,8}$/',
            'quantity'=>'required',
            'total'=>'required|numeric'
        ]);

        try {
            $booking->showtime_id = $request->showtime_id;
            $booking->name = $request->name;
            $booking->phone_no = $request->phone_no;
            $booking->quantity = $request->quantity;
            $booking->total = $request->total;

            $booking->save();
            return response()->json([
                "success"=>true,
                "message"=>"Booking updated successfully"
            ]);

        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something went wrong while updating a movie',
                'error'=> $e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //Delete specific booking
        try {
            $booking->delete();
            return response()->json([
                "success"=>true,
                "message"=>"Booking deleted successfully"
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something went wrong while deleting a movie',
                'error'=> $e->getMessage()
            ],500);
        }
    }
}
