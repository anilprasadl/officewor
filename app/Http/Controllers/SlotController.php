<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Event;
use App\Http\Controllers\myEventController;

use DB;
use Auth;

class SlotController extends Controller
{
    protected $my_event_controller;
    function __construct(){

     $this->my_event_controller = new myEventController; 
      
    }
          /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slots');
    }


 /**
     * Display a listing of the eventtype.
     *
     * @return Datatable Booked Slots
     */
    public function listBookedSlots(Datatables $datatabels)
    {

        try{
            if(Auth::user()->is_admin)
            {    
            $user = Auth::user();
                // print_r($user);exit;

                $records = Event::select("id","title","start_date","assigned_to")
                ->where('status','!=','COMPLETED')
                ->orderBy('title')->get();

                // $name= User::find($records->assigned_to);
            
                return $datatabels::of($records)
                ->addColumn('assigned_to',function($record){
                    if($record->assigned_to)
                    {
                       $users= User::select('name')->where('id',$record->assigned_to)->get();
                    //    print_r($user);exit;
                        foreach ($users as $user)    
                        {
                            return $user->name;
                        }
                    }else
                    {
                        return "NONE";
                    }
                })
                ->addColumn('action', function ($record) {
                    $buttons='';
                    if(Auth::user()->is_super_user ) 
                    {
                        $buttons .= ' <button ng-click="assignUser(' . $record->id .')"  '
                            . 'title="Assign" alt="Assign" '
                            . 'class=" btn btn-circle btn-mn btn-success">'
                            . '<span class="fa fa-tasks"></span></button>' ;
                            // print_r(Auth::user()->is_super_user || Auth::user()->is_admin && $record->assigned_to == Auth::user()->id);exit;
                            $buttons .= ' <button ng-click="closeSlot(' . $record->id . ',\''.Event::STATUS_COMPLETED.'\')"  '
                            . 'title="Close" alt="Close" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span>Close</span></button>';  
                            return $buttons; 
                    }
                    if(Auth::user()->is_admin && $record->assigned_to === Auth::user()->id)
                    {
                            $buttons .= ' <button ng-click="closeSlot(' . $record->id . ',\''.Event::STATUS_COMPLETED.'\')"  '
                            . 'title="Close" alt="Close" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span>Close</span></button>';
                        }
                    else{

                        return "<button class='btn btn-circle btn-mn btn-danger' title='Not Assigned' disabled><span>Close</span></</button>";
                       
                    }
                    return $buttons;
                })->make();
            }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, $status)
    {
        try
        {
            
            $user=Auth::user();
            if($id){
            $event = Event::find($id);
            $event->updated_by = $user->id;
            }else {
            $event = new Event;
            $event->created_by = $user->id;
            }
            // print_r($event->all());exit;
            $event->status=$status;
            if($status==App\Event::STATUS_COMPLETED)
            {
                $event->completed_by=$user->id;
            }
            // print_r($event->all());exit;

            $event->save();

            $this->my_event_controller->userEventLogs($event->id,$user->id);

            return response([
                'data'=>[
                'status'=>'SUCCESS',
                'message'=>'Event Closed Completed'
                ],
            ]);


        }catch(\Exception $e)
        {
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
    public function taskAssign($id)
    {
        try
        {
            $event=Event::find($id);
          
// print_r($event['title']);exit;

            return response([
                'data' =>  [
                    'event_id' => $event['id'],
                    'title' => $event['title'],
                    'status' => $event['status'],
                    'assigned_to' => $event['assigned_to'],
                    // 'is_admin' => $user['is_admin']
                ]
             
                ]);
            // print_r($event);exit;
        }catch(\Exception $e)
        {
            return response($e);
        }
    }

    public function saveTasks(Request $request)
    {
        // print_r($request);exit;
        try
        {
            $user=Auth::user()->is_super_admin;
                // print_r($request->event_id);exit;
            if($request->event_id)
            {
            $event = Event::find($request->event_id);
            $event->updated_by = $user->id;
            }
            $event->assigned_to = $request->assigned_to;
            // $event->assigned_to = $user->id;
            $event->assigned_by =$user->id ;
            $event->status=Event::STATUS_ASSIGNED;
            $event->save();

            $this->my_event_controller->userEventLogs($event->id,$user->id);

            return response([
                'data'=>[
                'status'=>'SUCCESS',
                'message'=>'Event Closed Completed'
                ],
            ]);
        }catch(\Exception $e)
        {
            return response($e);
        }
    }
}
