<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Event;

use App\Mail\SendBookingMail;
use App\Mail\sendRegisterMail;
use App\Mail\sendCancelMail;
use Mail;
use DB;
use Auth;

class myEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('myevents.listing');
    }


    /**
     * Display a listing of the eventtype.
     *
     * @return Datatable eventtypes
     */
    public function listEventType(Datatables $datatabels){

        try{
                
                $user = Auth::user();
                $records = Event::select("id","title","start_date")
                ->where("created_by",$user->id)
                ->orderBy('title')->get();
                // print_r($records[0]);exit;
                return $datatabels::of($records)
                ->addColumn('action', function ($record) {

                    $buttons = ' <button ng-click="editEventType(' . $record->id . ')"  '
                            . 'title="Edit" alt="Edit" '
                            . 'class=" btn btn-circle btn-mn btn-primary">'
                            . '<span class="fa fa-edit"></span></button>';

                    $buttons .= ' <button ng-click="deleteEventType(' . $record->id . ')"  '
                            . 'title="Delete" alt="Delete" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span class="fa fa-times"></span></button>';

                    return $buttons;
                })->make();
            }catch(\Exception $e){  
                return $this->respondInternalError($e->getMessage());
            }
    } 
    public function listDeletedEvents(Datatables $datatabels){

        try{
                
                $user = Auth::user();
                $records = Event::withTrashed()->where('created_by',$user->id);
                // print_r($records[0]);exit;
                return $datatabels::of($records)
                ->addColumn('action', function ($record) {

                    
                })->make();
            }catch(\Exception $e){  
                return $this->respondInternalError($e->getMessage());
            }
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
            $rv = DB::transaction(function()use($request) {
                
            // print_r($request->id);exit;
            $user = Auth::user();
            if($request->id){
            $event = Event::find($request->id);
            $event->updated_by = $user->id;
            }else {
            $event = new Event;
            $event->created_by = $user->id;
            }
            if($request->start_date > $request->end_date)
              {
                return response([
                    'data' => [
                        "error" => "End Date should be greater thean Start Date ",
                        ],
                    ],206);
              }
            $query=Event::where('start_date','<=',$request->end_date)
               ->where('end_date','>',$request->start_date);

               if(isset($request->id))
                $query->whereNotIn('id',[$request->id]);               
                else
                $query->whereNotNull('id');
                $records = $query->get();

                if($records->count())
                {
                    return response([
                        'data' => [
                            "error" => "Resource not Available Try Some Other Time Range or Resource.",
                            ],
                        ],206);
                }
             
            $event->title = $request->title;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            // print_r($event->all());exit;
            $event->save();


           $this->sendBookingNotication($event->id,$user);

            return response([
            'data' => [
                "event_id" => $event->id,
                "message" => "Event update success.",
                ],
            ],200);
    
        });

        return $rv;

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
        $event = Event::find($id);
        if(!$event)
        {
        return response(
            ['error'=> "Event not found."
            ]);
        }
        return response([
        'data' =>  [
            'id' => $event['id'],
            'title' => $event['title'],
            'start_date' => $event['start_date'],
            'end_date' => $event['end_date'],
        ]
     
        ]);
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
        try
        {   $this->eventCancelNotification($id);
            $record = Event::destroy($id);
            return response([
                'data' => [
                    "message" => "Delete success.",
                    ],
                ]); 
           
        }catch(Exception $e){
                    return $this->respondInternalError($e->getMessage());
        
            }       
    }
      /**
     * Delete the eventtype.
     *
     * @param  int  eventtype_id - $id
     * @return Json with success or error message
     */

    public function delete($eventtype_id){

       
    }

    /**
     * Display a active eventtypes.
     *
     * @return Active eventtypes as json 
     */

    public function listactiveEventType(){
    
        try
        {
            $records = EventType::select("id","name","status")
            ->where('status',EventType::STATUS_ACTIVE)->get();
            return $this->respond([
            'data' => [
                "status" => "SUCCESS",
                "message" => $this->eventtype_transform->transformAllEventTypes($records->toArray()),
            ]
            ]);
        }catch(\Exception $e){
            return $this->respondInternalError($e->getMessage());
        }
    }
    public function sendBookingNotication($event_id, $user = array() ){
        
        $event = Event::find($event_id);
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['event_start_date'] = $event->start_date;
        
        Mail::send(new sendBookingMail($records));
    }


    public function sendRegisterNotication($user_name, $user_email){
        
        $records = array();
        $records['name'] = $user_name;
        $records['email'] = $user_email;
       
        Mail::send(new SendRegisterMail($records));
    }
/* eventCancelNotification Function to send the Mails  when the event is cancelled

* @param  int  event_id 
*/

public function eventCancelNotification($event_id){

    $event = Event::find($event_id);
        $user=Auth::user();

        $event = Event::find($event_id);
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['event_start_date'] = $event->start_date;
            Mail::send(new sendCancelMail($records));
}




}

