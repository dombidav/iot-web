<?php

namespace App\Http\Controllers;

use App\Lock;
use Illuminate\Http\Request;
use App\Http\Resources;
use App\Http\Resources\LockResource;

class LockController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $lock=Lock::paginate(10);
        return LockResource::collection($lock);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return LockResource|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lock = new Lock();
        $lock->name = $request->input('name');

        if($lock->save()){
            Helpers\LogHelper::Log($request->input('user_id'), $lock, Helpers\LogHelper::Lock, "Store"); 
            return new LockResource($lock);
           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lock  $lock
     * @return LockResource|\Illuminate\Http\Response
     */
    public function show(Lock $lock)

    {  Helpers\LogHelper::Log($request->input('user_id'), $lock, Helpers\LogHelper::Lock, "Show"); 

        return new LockResource($lock);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lock  $lock
     * @return \Illuminate\Http\Response
     */
    public function edit(Lock $lock)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lock  $lock
     * @return LockResource|\Illuminate\Http\Response
     */
    public function update(Request $request, Lock $lock)
    {

        $lock->name = $request->filled('name')? $request->input('name') : $lock->name;

        if($lock->save()){
            Helpers\LogHelper::Log($request->input('user_id'), $lock, Helpers\LogHelper::Lock, "Update"); 
            return new LockResource($lock);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Lock $lock
     * @return \Illuminate\Http\Response|string
     * @throws \Exception
     */
    public function destroy(Lock $lock)
    {
        if($lock->delete()){
            Helpers\LogHelper::Log($request->input('user_id'), $lock, Helpers\LogHelper::Lock, "Delete"); 
            return "Lock deleted.";
        }
    }
}
