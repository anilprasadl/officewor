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
 
                 new \DateTime($value->end_date)

                 
                //  [
                //     'color' => '#444444',
                //     'url' => '#',
                //     'description' => "Event Description",
                //     'textColor' => '#0A0A0A'
                // ]
             );
             
           }
 
        }
        $calendar = \Calendar::addEvents($events,
        [
            'color' => '#444444',
            'url' => '#',
            'description' => "Event Description",
            'textColor' => '#0A0A0A'
        ]) //add an array with addEvents
    ->setOptions([ //set fullcalendar options
		'firstDay' => 1
	])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        'eventClick' => 'function(calEvent, jsEvent, view) {
            $("#addSlot").modal();
         }'
    ]);
    // $calendar = \Calendar::addEvents($events) //add an array with addEvents
    // ->setOptions([ //set fullcalendar options
	// 	'firstDay' => 1
	// ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
    //     'eventClick' => 'function(calEvent, jsEvent, view) {
    //         $("#start_time").val(moment(calEvent.start).format("YYYY-MM-DD HH:mm:ss"));
    //         $("#finish_time").val(moment(calEvent.end).format("YYYY-MM-DD HH:mm:ss"));
    //         $("#editModal").modal();
    //     }'
    // ]);

 
    //    $calendar = Calendar::addEvents($events,
    //    [
    //         'color' => '#444444',
    //         'url' => '#',
    //         'description' => "Event Description",
    //         'textColor' => '#0A0A0A'
    //     ]
    // ); 
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
        

    }

}