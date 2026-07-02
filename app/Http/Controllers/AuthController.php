<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
              "email"=>"reqired|email|min:3|max:12",
            "password"=>"reqired|password|min:6|max:16"
        ],
        [
            'email.required'=>'The email is required, please enter your email address!',
            'email.string'=>'The email must be a text!',
            'password.min'=>'The password should be at least 5 characters!',
        ]);
 $user=   User::where("email",$request->email)->first();
    if($user&&Hash::check($request->password,$user->password)){
        $token = $user->createToken("auth_token")->plainText;
         return response()->json([
        "data"=>$token,
        'success'=>true,
    ]);
    }
    else{
          return response()->json([
        "data"=>"Somthing went wrong!",
        'success'=>false,
    ]);
    }
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $token)
    {
        //
        $user = User::where('remember_token', $token)->first();
        return response()->json([
            'data' => $user
        ]);
    }
    public function register(string $id)
    {
        //
        return response()->json([
            'data'=>'Hi there,'
        ]);
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
}
