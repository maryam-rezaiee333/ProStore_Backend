<?php

namespace App\Http\Controllers;

use App\Http\Requests\addreviewsRequest;
use App\Http\Resources\addreveiwResource;
use App\Models\reviews;
use Illuminate\Http\Request;

class reveiwController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = reviews::with(['products' , 'users'])->get();
        return addreveiwResource::collection($review);
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(addreviewsRequest $request)
    {
        $review = reviews::create($request->validated());
        $review->load(['products' , 'users']);
        return new addreveiwResource($review);
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
