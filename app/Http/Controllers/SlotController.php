<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Event;

use DB;
use Auth;

class SlotController extends Controller
{
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

                $records = Event::select("id","title","start_date")
                ->where('status','ACTIVE')
                ->orderBy('title')->get();
                // print_r($records);exit;
                return $datatabels::of($records)
                ->addColumn('action', function ($record) {

                    $buttons = ' <button ng-click="closeSlot(' . $record->id . ',\''.Event::STATUS_COMPLETED.'\')"  '
                            . 'title="Edit" alt="Edit" '
                            . 'class=" btn btn-circle btn-mn btn-danger">'
                            . '<span class="fa fa-times"></span></button>';


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
            // print_r($event->all());exit;

            $event->save();


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
}
