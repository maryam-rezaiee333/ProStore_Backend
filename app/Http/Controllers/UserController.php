<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
              "email"=>"required|email|min:3|max:12",
            "password"=>"required|password|min:6|max:16"
        ]);
 $user=   User::where("email",$request->email)->first();
    if($user&&Hash::check($request->password,$user->password)){
        $user->createToken("auth_token")->plainTextToken;
         return response()->json([
        "data"=>$user->token,
        "success"=>true
    ]);
    }
    else{
          return response()->json([
        "data"=>"somthing went wrong",
    ]);
    }
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $token)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getCurrentMonthUser()  {
       $users= User::whereDate('created_at','<',now(),true)->whereDate('created_at','>',Carbon::now()->subDays(30))->count();
    return response()->json([
        "currentUser"=>$users
    ]);
        }
        public function getPrevMonthUser(){
            try{
            $prev_user= User::whereDate('created_at','<=',Carbon::now()->subDays(30),true)->whereDate('created_at','>=',Carbon::now()->subdays(60))->count();
           return response()->json([
            "prev_user" => $prev_user
           ]);}
           catch(Exception $err){
            return response()->json([
                "message"=>$err->getMessage()
            ]);
           }
        }
}
