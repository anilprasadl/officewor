<?php

namespace App\Http\Controllers;


use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

use DB;
use Auth;


class AdminController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.listing');
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
            // print_r($request->name);exit;
            $rv = DB::transaction(function()use($request) {
                
            
           if( Auth::user()->is_admin)
           { 
            $user_add = User::find($request->id);
            $user_add->name = $request->name;
            $user_add->email = $request->email;
            $user_add->is_admin = $request->is_admin;
            $user_add->save();

            } else{
                return response([
                'data' => [
                    "error" => "You Are Not an Admin",
                    ],
                ],206);
            }
        //    $this->sendBookingNotication($user->id,$user);

            return response([
            'data' => [
                "User_id" => $user_add->id,
                "message" => "User update success.",
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
        $user = User::find($id);
        if(!$user)
        {
        return response(
            ['error'=> "User not found."
            ]);
        }
        return response([
        'data' =>  [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'is_admin' => $user['is_admin']
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
        {   
            $record = User::destroy($id);
            return response([
                'data' => [
                    "message" => "Delete success.",
                    ],
                ]); 
           
        }catch(Exception $e){
                    return $this->respondInternalError($e->getMessage());
        
            }       
    }


    
    public function listUsers(Datatables $datatabels)
    {
        try
        {
            if(Auth::user()->is_admin)
            {
                
            $records= User::select('id','name','email','is_admin')
            ->where('id','!=',Auth::user()->id)
            ->orderBy('name')->get();
            // print_r($records);exit;
            // if($records->is_admin)
            // {
            // $records[]->is_admin="Yes";
            // }else{
            // $records[]->is_admin="No";
            // }
            return $datatabels::of($records)
            ->addColumn('is_admin',function($record){
                if($record->is_admin)
                {
                    return User::STATUS_IS_ADMIN;
                }else{
                    return User::STATUS_IS_NOT_ADMIN;
                }
            })
            ->addColumn('action', function ($record) {
                $buttons = ' <button ng-click="editUser(' . $record->id . ')"  '
                        . 'title="Edit" alt="Edit" '
                        . 'class=" btn btn-circle btn-mn btn-primary">'
                        . '<span class="fa fa-edit"></span></button>';

                $buttons .= ' <button ng-click="deleteUser(' . $record->id . ')"  '
                        . 'title="Delete" alt="Delete" '
                        . 'class=" btn btn-circle btn-mn btn-danger">'
                        . '<span class="fa fa-times"></span></button>';

                return $buttons;
            
            })->make();
        }
        }catch(\Exception $e){  
            return response($e->getMessage());
        }
    }
    public function listAdmin(Datatables $datatabels)
    {
        try
        {
            // if(Auth::user()->is_super_admin)
            // {
                
            $records= User::select('id','name','email','is_admin')
            ->where('id','!=',Auth::user()->id)
            ->where('is_admin',1)
            ->orderBy('name')->get();


            return response(['data'=>$this->transformAll($records->toArray())]);
            return $records;
            
        // }
        }catch(\Exception $e){  
            return response($e->getMessage());
        }
    }
    public function transform($user)
    {   
        $record=[
            'id'=>$user['id'],
            'name'=>$user['name'],
            'email'=>$user['email']
        ];
        return $record;
    }
    public function transformAll($users)
    {
        return array_map([$this,'transform'],$users);
    }
    
}


