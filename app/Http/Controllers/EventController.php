<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Event;

use Auth;

use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $events = [];

        $request = Event::all();
 
        if($request->count()){
 
           foreach ($request as $key => $value) {
 
             $events[] = Calendar::event(
 
                 $value->title,
 
                 false,
 
                 new \DateTime($value->start_date),
 
                 new \DateTime($value->end_date),

                 null
 
             );
           }
 
        }
        

 
       $calendar = Calendar::addEvents($events); 
 
       return view('mycalender', compact('calendar')); 
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
       
        try{ 
            // print_r($request->id);exit;
            $user = Auth::user();
            if($request->id){
            $event = Event::find($request->id);
            $event->updated_by = $user->id;
            }else {
            $event = new Event;
            $event->created_by = $user->id;
            }

            $event->title = $request->title;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            // print_r($event->all());exit;
            $event->save();

            return response([
            'data' => [
                "event_id" => $event->id,
                "message" => "Event update success.",
                ],
            ]);
    
        }catch(\Exception $e){
            return response($e->getMessage());
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
        //
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
        //
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
    public function display()
    {
        
        return view("addEvent");

    }
}
