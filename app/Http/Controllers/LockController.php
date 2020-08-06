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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lock=Lock::paginate(10);
        return response(LockResource::collection($lock));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lock = new Lock();
        $lock->name = $request->input('name');

        if($lock->save()){
            return response(new LockResource($lock));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lock  $lock
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lock = Lock::findOrFail($id);
        return response(new LockResource($lock));
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lock=Lock::findOrFail($id);
        $lock->name = $request->filled('name')? $request->input('name') : $lock->name;

        if($lock->save()){
            return response(new LockResource($lock));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lock  $lock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lock=Lock::findOrFail($id);
        if($lock->delete()){
            return response("Lock deleted.");
        }
    }
}
