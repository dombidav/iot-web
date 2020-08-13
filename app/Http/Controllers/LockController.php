<?php

namespace App\Http\Controllers;

use App\Device;
use App\Helpers\ResponseWrapper;
use App\Http\Resources\DeviceResource;
use App\Lock;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;
use App\Http\Resources\LockResource;
use Illuminate\Support\Facades\Date;

class LockController extends Controller
{
    public function __construct()
    {
        $this->middleware('key.auth');
    }
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
        $lock->status = $request->input('status');

        if($lock->save()){
            LogHelper::Log($request->input('user_id'), $lock, LogHelper::Lock, "Store");
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
    {
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
        $lock->status = $request->filled('status') ? $request->input('status') : $lock->status;

        if($lock->save()){
            LogHelper::Log($request->input('user_id'), $lock, LogHelper::Lock, "Update");
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
            LogHelper::Log($request->input('user_id'), $lock, LogHelper::Lock, "Destroy");
            return "Lock deleted.";
        }
    }

    public function keepAlive(Request $request, Device $device){
        if($device->exists){
            $device->setUpdatedAt(Date::now())->save();
            return new DeviceResource($device);
        }
        return ResponseWrapper::wrap('Device not found', $request->all(), 404);
    }
}
