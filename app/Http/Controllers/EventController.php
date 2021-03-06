<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Event;

use App\User;

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
               
                if($value->assigned_to)
                    $user=User::select('name')->find($value->assigned_to);
                else
                    $user=  ['name'=>\App\Event::STATUS_UNASSIGNED ];
             
            $events[] = Calendar::event(
 
                 $value->title ,
 
                 false  ,
 
                 new \DateTime($value->start_date),
 
                 new \DateTime($value->end_date),

                 $value->status,
                 [

                        // 'status'=> $value->status,
                        'user_name' => $user,
                 ]

             );
             
           }
 
        }
        if(!$events)
        {
                    $calendar = Calendar::addEvents($events);
                    
            } else{
                    foreach($events as $event)
                    {
                        if ($event->id == Event::STATUS_COMPLETED )
                            {
                                            $calendar = \Calendar::addEvent($event,
                                    [
                                        'color' => '#2ecc71',
                                    ])->setOptions([ //set fullcalendar options
                                        'FirstDay' => 1,
                                        // 'contentheight' => 650,
                                        'editable' => false,
                                        'allDay' => false,
                                        'slotLabelFormat' => 'HH:mm:ss',
                                        'timeFormat' => 'HH:mm',
                                    ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                                        
                                        'eventClick' => 'function($events, jsEvent, view) {
                                            $("#modalTitle").html($events.title);
                                            $("#status").html($events.id);
                                            {$("#assigned_user").html($events.user_name.name);}
                                            var date = $events.start._i;
                                            var time =date.substr(11,5);
                                            $("#Start").html(time);
                                            var edate = $events.end._i;
                                            var etime = edate.substr(11,5);
                                            $("#End").html(etime);
                                            $("#calendarModal").modal();
                                        }',
                                        'eventRender' => 'function($events, element) {
                                                    
                                            $(element).tooltip({title: $events.title});             
                                        }',
                                        
                                    ]);
                                    // break;
                                        }else if ($event->id == Event::STATUS_CREATED)
                                        {
                                            $calendar = \Calendar::addEvent($event,
                                            [
                                                'color' => '#3498db',
                                            ])->setOptions([ //set fullcalendar options
                                                'FirstDay' => 1,
                                                // 'contentheight' => 650,
                                                'editable' => false,
                                                'allDay' => false,
                                                'slotLabelFormat' => 'HH:mm:ss',
                                                'timeFormat' => 'HH:mm',
                                            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                                        
                                                'eventClick' => 'function($events, jsEvent, view) {
                                                    $("#modalTitle").html($events.title);
                                                    $("#status").html($events.id);
                                                    {$("#assigned_user").html($events.user_name.name);}
                                                    var date = $events.start._i;
                                                    var time =date.substr(11,5);
                                                    $("#Start").html(time);
                                                    var edate = $events.end._i;
                                                    var etime = edate.substr(11,5);
                                                    $("#End").html(etime);
                                                    $("#calendarModal").modal();
                                                }',
                                                'eventRender' => 'function($events, element) {
                                                            
                                                    $(element).tooltip({title: $events.title});             
                                                }',
                                                
                                            ]);
                                        }else if ($event->id == Event::STATUS_ASSIGNED)
                                        {
                                            $calendar = \Calendar::addEvent($event,
                                            [
                                                'color' => '#8e44ad',
                                            ])->setOptions([ //set fullcalendar options
                                                'FirstDay' => 1,
                                                // 'contentheight' => 650,
                                                'editable' => false,
                                                'allDay' => false,
                                                'slotLabelFormat' => 'HH:mm:ss',
                                                'timeFormat' => 'HH:mm',
                                            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                                        
                                                'eventClick' => 'function($events, jsEvent, view) {
                                                    $("#modalTitle").html($events.title);
                                                    $("#status").html($events.id);
                                                    {$("#assigned_user").html($events.user_name.name);}
                                                    var date = $events.start._i;
                                                    var time =date.substr(11,5);
                                                    $("#Start").html(time);
                                                    var edate = $events.end._i;
                                                    var etime = edate.substr(11,5);
                                                    $("#End").html(etime);
                                                    $("#calendarModal").modal();
                                                }',
                                                'eventRender' => 'function($events, element) {
                                                            
                                                    $(element).tooltip({title: $events.title});             
                                                }',
                                                
                                            ]);
                                        }else if ($event->id == Event::STATUS_CANCELLED)
                                        {
                                            $calendar = \Calendar::addEvent($event,
                                            [
                                                'color' => '#e74c3c',
                                            ])->setOptions([ //set fullcalendar options
                                                'FirstDay' => 1,
                                                // 'contentheight' => 650,
                                                'editable' => false,
                                                'allDay' => false,
                                                'slotLabelFormat' => 'HH:mm:ss',
                                                'timeFormat' => 'HH:mm',
                                            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                                        
                                                'eventClick' => 'function($events, jsEvent, view) {
                                                    $("#modalTitle").html($events.title);
                                                    $("#status").html($events.id);
                                                    {$("#assigned_user").html($events.user_name.name);}
                                                    var date = $events.start._i;
                                                    var time =date.substr(11,5);
                                                    $("#Start").html(time);
                                                    var edate = $events.end._i;
                                                    var etime = edate.substr(11,5);
                                                    $("#End").html(etime);
                                                    $("#calendarModal").modal();
                                                }',
                                                'eventRender' => 'function($events, element) {
                                                            
                                                    $(element).tooltip({title: $events.title});             
                                                }',
                                                
                                            ]);
                                    }

                                
                            }
                    }


        // ->setOptions([ //set fullcalendar options
        //     	'firstDay' => 1
        //     ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        //         'eventClick' => 'function() {
        //             $("#showEvent").modal();
        //          }'
        //     ])


    //     $calendar = \Calendar::addEvents($events)
    // ->setOptions([ //set fullcalendar options
	// 	'firstDay' => 1
	// ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
    //     'eventClick' => 'function($events) {
    //         console.log( $events);
    //      }'
    // ]);
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
}