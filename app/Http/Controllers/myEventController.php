<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Event;
use App\User;
use App\UserEventLogs;
 
use App\Mail\sendBookingMail;
use App\Mail\sendBookingMailToAdmin;
use App\Mail\sendCancelMail;
use App\Mail\sendCancelMailToAdmin;
use App\Mail\sendClosedMail;
use App\Mail\sendClosedMailToAdmin;
use App\Mail\sendAssignedMail;
use App\Mail\sendAssignedMailToAdmin;
use App\Mail\sendRegisterMail;
use Mail;
use DB;
use Auth;
use Carbon\Carbon;
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
                // print_r( Carbon::now()->toDateTimeString());exit;
                return $datatabels::of($records)
                ->addColumn('action', function ($record) {
                    if($record->status==\App\Event::STATUS_ASSIGNED && $record->start_date <= Carbon::now()->toDateTimeString())
                    return "<button class='btn btn-circle btn-danger' title='Task is in Progress' disabled>Cancel</button>";
                    else
                    $buttons = ' <button ng-click="cancelEvent(' . $record->id .  ',\''.Event::STATUS_CANCELLED.'\')"  '
                            . 'title="Cancel" alt="Cancel" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span >Cancel</span></button>';

                    return $buttons;
                })
                ->editColumn('activated','@if($activated)
                        Activated
                    @else
                        Processing
                    @endif')
                    ->editColumn('start_date',Carbon::parse($start_date)->format("M d Y")) 
            ->make();
            }catch(\Exception $e){  
                return response($e->getMessage());
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
                return response($e->getMessage());
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
                $records = Event::withTrashed()->select("id","title","start_date","status","created_by","created_at","updated_by","updated_at")
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
                $records = Event::withTrashed()->select("id","title","start_date","status","created_by","created_at","updated_by","updated_at")
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
                return response($e->getMessage());
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
            $this->userEventLogs($event->id,$user->id);
            $this->sendBookingNotication($event->id,$user);
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
     * Display the specified Event.
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
     * Show the Detailed information of a Task 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function taskInfo($id)
    {
        $logs = UserEventLogs::where('event_id',$id)->get();
    
        return response(['data'=>$this->transformAll($logs->toArray())]);
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
        return view('timeline.listing'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEvent(Request $request)
    {
        try
        {   
            $record = Event::find($request->id);
            $record->status = $request->status;
            $record->description = $request->comments;
            $record->state = $request->state['name'];
            $record->save();
            $this->eventCancelNotification($request->id);
            $this->eventCancelNotificationToAdmin($request->id);
            $this->userEventLogs($request->id,Auth::user()->id);
            $record = Event::destroy($request->id);
            return response([
                'data' => [
                    "message" => "Delete success.",
                    ],
                ]); 
           
        }catch(Exception $e){
                    return response($e->getMessage());
        
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
     * Send Mail to the Admin when user books Slots.
     *
     * @param int event_id - $id 
     * @return send a mail to respective user. 
     */

    public function sendBookingNoticationToAdmin($event_id, $user = array() ){
        
        $event = Event::find($event_id);
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['event_start_date'] = $event->start_date;
        $records['event_end_date'] = $event->end_date;
            Mail::send(new sendBookingMailToAdmin($records));
    }
    /**
     * Send Mail to the Admin when user books Slots.
     *
     * @param int event_id - $id 
     * @return send a mail to respective user. 
     */

    public function sendRegisterNotication($user_name, $user_email){
        
        $records = array();
        $records['name'] = $user_name;
        $records['email'] = $user_email;
            Mail::send(new SendRegisterMail($records));
    }

    /* eventCancelNotification Function to send the Mails to user when the event is assigned to admin

    * @param  int  event_id 
    */
    public function eventAssignedNotification($event_id){

        $event = Event::find($event_id);
        $user=User::find($event->created_by);
        $event = Event::find($event_id);
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['assigned_to'] = $this->getUserName($event->assigned_to);
        $records['event_start_date'] = $event->start_date;
            Mail::send(new sendAssignedMail($records));
    }

    /* eventAssignedNotificationToAdmin Function to send the Mails to Admin when the event is assigned to admin

    * @param  int  event_id 
    */
    public function eventAssignedNotificationToAdmin($event_id){

        $event = Event::find($event_id);
        $user=User::find($event->assigned_to);
        $event = Event::find($event_id);
        $records = array();
        $records['name'] = $user->name;
        $records['email'] = $user->email;
        $records['event_name'] = $event->title;
        $records['assigned_to'] = $this->getUserName($event->assigned_to);
        $records['event_start_date'] = $event->start_date;
            Mail::send(new sendAssignedMailToAdmin($records));
    }

    /* eventCancelNotification Function to send the Mails to user when the event is cancelled

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

    /* eventCancelNotificationToAdmin Function to send the Mails to admin when the event is cancelled

    * @param  int  event_id 
    */
    public function eventCancelNotificationToAdmin($event_id){

            $event = Event::find($event_id);
            $user=Auth::user();
            $event = Event::find($event_id);
            $records = array();
            $records['name'] = $user->name;
            $records['email'] = $user->email;
            $records['event_name'] = $event->title;
            $records['event_start_date'] = $event->start_date;
                Mail::send(new sendCancelMailToAdmin($records));
    }
    /* eventCloseNotification Function to send the Mails to user when the event is closed

    * @param  int  event_id 
    */
    public function eventCloseNotification($event_id){

            $event = Event::find($event_id);
            $user=User::find($event->created_by);
            $records = array();
            $records['name'] = $user->name;
            $records['email'] = $user->email;
            $records['event_name'] = $event->title;
            $records['assigned_to'] = $this->getUserName($event->assigned_to);
            $records['event_start_date'] = $event->start_date;
                Mail::send(new sendClosedMail($records));
    }
    /* eventCloseNotificationToAdmin Function to send the Mails to admin when the event is closed

    * @param  int  event_id 
    */
    public function eventCloseNotificationToAdmin($event_id){

            $event = Event::find($event_id);
            if($event->assigned_to)
            {
                $user=User::find($event->assigned_to);
            }
            else
            {
                $user=Auth::user();
            }
            $event = Event::find($event_id);
            $records = array();
            $records['name'] = $user->name;
            $records['email'] = $user->email;
            $records['event_name'] = $event->title;
            $records['assigned_to'] = $this->getUserName($event->assigned_to);
            $records['event_start_date'] = $event->start_date;
                Mail::send(new sendClosedMailToAdmin($records));
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
                    $logs->description=$event->description;
                    $logs->state=$event->state;
                    $logs->updated_at=$event->updated_at;
                    $logs->deleted_at=$event->deleted_at;
                    $logs->save();
                }else{
                    return response([
                        'data'=>[
                            'error'=>'No Events Found'
                            ]
                        ]);
                }

        }

    public function transform($log)
    {   $event=Event::withTrashed()->find($log['event_id']);
        return [
                'id' => $event['id'],
                'title' => $event['title'],
                'start_date' => $event['start_date'],
                'end_date' => $event['end_date'],
                'status'=>$log['status'],
                'assigned_to'=>$log['assigned_to'],
                'assigned_by'=>$log['assigned_by'],
                'updated_at_date'=>Carbon::parse($log['updated_at'])->format('M d Y'),
                'updated_at_time'=>Carbon::parse($log['updated_at'])->format('H:i'),
                'created_by'=>$log['created_by'],
                'created_at'=>$log['created_at'],
                'completed_by'=>$log['completed_by'],
                'reason'=>$log['state'],
                'description'=>$log['description'],
            ];
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
            return $user->name;
        }else
        {
            return Null;
        }
    }

}

