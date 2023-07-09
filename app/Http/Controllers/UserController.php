<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Interests;
use App\Models\UserInterests;


class UserController extends Controller
{

    protected $User;

    public function __construct(){
        $this->User = new User;

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::with('user_interests')->select(['id', 'email', DB::Raw("CONCAT(first_name, ' ', last_name) AS full_name"),  DB::raw("DATE_FORMAT(dob, '%m-%d-%Y') as dob")])->get();
        return response()->json([
            'message'=> 'All user data!',
            'sucess'=> true,
            'code'  => 200,
            'users' => $users->toArray()
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * createUser a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(UserRequest $request)
    {
        // dd( date("m-d-Y", strtotime($request->dob) ) );
       $interst_error = [];
       $request->validated();
       $this->User->first_name = $request->first_name;
       $this->User->last_name  = $request->last_name;
       $this->User->address    = $request->address;
       $this->User->dob        = date("Y-m-d", strtotime($request->dob) ) ;
       $this->User->email      = $request->email;
       $this->User->password   = bcrypt($request->password);
       $inserted               =  $this->User->save();
     
       if($inserted){
          $userId =  $this->User->id;
           foreach($request->interests as $key => $interst_id){

             $intId =  Interests::find($interst_id);
             if($intId){
                UserInterests::insert(
                    [
                        'user_id' => $userId, 
                        'interest_id' => $interst_id
                    ]
                  );
                  array_push($interst_error,"This interests id ".$interst_id." inserted");
             }
             else{
                array_push($interst_error,"This interests id ".$interst_id." does not exists");
             }
           }
      }

       return response()->json([
        'message'=> ['user' => 'Successfully created user!', 'interest' => $interst_error],
        'sucess'=> true,
        'code'  => 201
        ], 201);

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
