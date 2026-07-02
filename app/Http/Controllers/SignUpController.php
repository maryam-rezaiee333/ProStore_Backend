<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class SignUpController extends Controller
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
            'name'=>'required|string|min:3',
            'email'=>'required|string|min:5',
            'password'=>'required|string|min:8',
            'phone_number'=>'reuired|string|min:9|max:14',
        ],
        [
            'name.required'=>'The name field is required!',
            'name.string'=>'The name field should be a text! '
        ]);



        try{
             $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
                'phone_number'=> $request->phone_number,
             ]);
             $token = $user->createToken('auth_token')->plainTextToken;
             return response()->json([
               'message'=>'',
               'success'=> true,
             ]);
        }
           catch(Exception $error){
              return response()->json([
                'message'=>$error->getMessage(),
                'success'=> false,
              ]);
           }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
