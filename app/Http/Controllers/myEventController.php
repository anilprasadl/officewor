<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Event;
use App\User;
use App\UserEventLogs;
 
use App\Mail\SendBookingMail;
use App\Mail\sendRegisterMail;
use App\Mail\sendCancelMail;
use App\Mail\sendBookingMailToAdmin;
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
                $records = Event::select("id","title","start_date","status")
                ->where("created_by",$user->id)
                ->whereNotIn("status",[\App\Event::STATUS_CANCELLED,\App\Event::STATUS_COMPLETED])
                ->orderBy('title')->get();
                // print_r($records[0]);exit;
                return $datatabels::of($records)
                ->addColumn('action', function ($record) {
                    if($record->status==\App\Event::STATUS_ASSIGNED)
                    return "<button class='btn btn-circle btn-danger' title='Task is in Progress' disabled>Cancel</button>";
                    else
                    $buttons = ' <button ng-click="deleteEventType(' . $record->id . ')"  '
                            . 'title="Delete" alt="Delete" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span >Cancel</span></button>';

                    return $buttons;
                })->make();
            }catch(\Exception $e){  
                return $this->respondInternalError($e->getMessage());
            }
    } 
    public function listDeletedEvents(Datatables $datatabels){

        try{
                
                $user = Auth::user();
                $records = Event::onlyTrashed()->where('status',\App\Event::STATUS_CANCELLED)->where('created_by',$user->id)->get();
                // print_r($records);exit;
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
    public function listAllTask(Datatables $datatabels){

        try{
            if(Auth::user()->is_admin){
                $records = Event::select("id","title","start_date","status","created_by","created_at","updated_by","updated_at")
                ->orderBy('title')->get();
                // print_r($records);exit;

                return $datatabels::of($records)
                ->addColumn('action', function ($record) {

                    $buttons = ' <button ng-click="showAllTask(' . $record->id . ')"  '
                            . 'title="Info" alt="Info" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span class="fa fa-info"></span></button>';

                    return $buttons;
                })->make();
            }else
            {            
                $user = Auth::user();
                $records = Event::select("id","title","start_date","status","created_by","created_at","updated_by","updated_at")
                ->where("created_by",$user->id)
                ->orderBy('title')->get();
                return $datatabels::of($records)
                ->addColumn('action', function ($record) {

                    $buttons = ' <button ng-click="showAllTask(' . $record->id . ')"  '
                            . 'title="Info" alt="Info" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span class="fa fa-info"></span></button>';

                    return $buttons;
                })->make();
            }               
            }catch(\Exception $e){  
                return $this->respondInternalError($e->getMessage());
            }
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        //    print_r(user()->is_admin);exit;
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
                            "error" => "Time Slot not Available Try Some Other Time Range.",
                            ],
                        ],206);
                }
             
            $event->title = $request->title;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->status = $request->status;
            $event->save();
            // print_r($event);


            $this->userEventLogs($event->id,$user->id);

           $this->sendBookingNotication($event->id,$user);
        //    if(user()->is_admin)
           $this->sendBookingNoticationToAdmin($event->id,$user);

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



    public function taskInfo($id)
    {
        // $event=Event::find($id);

        $logs = UserEventLogs::where('event_id',$id)->get();
        // print_r(count($logs));exit;
        // foreach($logs as $log)
        // print_r($logs);exit;
// {
        // if(!$event)
        // {
        // return response(
        //     ['error'=> "Event not found."
        //     ]);
        // }
        return response(['data'=>$this->transformAll($logs->toArray())]);
        return $records;
        
// }
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
    public function display()
    {
        return view('track.task'); 
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
            
            $record = Event::find($id);
            $record->status=\App\Event::STATUS_CANCELLED;
            $record->save();
            $this->userEventLogs($id,Auth::user()->id);
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
     * Send Mail to the Users who book Slots.
     *
     * @param int event_id - $id 
     * @return send a mail to respective user. 
     */

    public function sendBookingNotication($event_id, $user = array() ){
        
        $event = Event::find($event_id);
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['event_start_date'] = $event->start_date;
        
        Mail::send(new sendBookingMail($records));
    }


    
    /**
     * Send Mail to the Users who book Slots.
     *
     * @param int event_id - $id 
     * @return send a mail to respective user. 
     */

    public function sendBookingNoticationToAdmin($event_id, $user = array() ){
        
        $event = Event::find($event_id);
        // dd($event);exit;
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['event_start_date'] = $event->start_date;
        $records['event_end_date'] = $event->end_date;
        // print_r($records);exit;
        Mail::send(new sendBookingMailToAdmin($records));
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


public function userEventLogs($event_id,$user_id)
{
    $event=Event::find($event_id);
    if($event)
            {
                $logs=new UserEventLogs;
                $logs->event_id=$event->id;
                $logs->user_id=$user_id;
                $logs->status=$event->status;
                $logs->assigned_to=$this->getUserName($event->assigned_to);
                $logs->assigned_by=$this->getUserName($event->assigned_by);
                $logs->created_by=$this->getUserName($event->created_by);
                $logs->updated_by=$this->getUserName($event->updated_by);
                $logs->completed_by=$this->getUserName($event->completed_by);
                $logs->updated_at=$event->updated_at;
                $logs->deleted_at=$event->deleted_at;
                // print_r($logs);exit;
                $logs->save();
            }else{
                return response(['error'=>'No Events Found']);
            }
}
            public function timelineTrack($event,$log)
            {
                print_r($log);
                
            }

            public function transform($log)
            {   $event=Event::find($log['event_id']);
                return [
                        'id' => $event['id'],
                        'title' => $event['title'],
                        'start_date' => $event['start_date'],
                        'end_date' => $event['end_date'],
                        'status'=>$log['status'],
                        'assigned_to'=>$log['assigned_to'],
                        'assigned_by'=>$log['assigned_by'],
                        'created_by'=>$log['created_by'],
                        'created_at'=>$log['created_at'],
                        'description'=>$event['description'],
                        'created_by'=>$log['completed_by'],

                    ]
                
                  ;
            }
            public function transformAll($logs)
            {
                return array_map([$this,'transform'],$logs);
            }
            public function getUserName($id)
            {
               if($id)
                {
                    $user=User::find($id);
                    // print_r($user);exit;
                    return $user->name;
                }else
                {return Null;}
            }

}

