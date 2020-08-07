<?php

namespace App\Http\Controllers;

use App\Lock;
use App\Worker;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workerGroup = Group::paginate(20);
        return GroupResource::collection($workerGroup);
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
        $workerGroup = new Group;

        $workerGroup->name = $request->input('name');

        if($workerGroup->save()) {
            return new GroupResource($worker);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Group $workerGroup)
    {
        $workerGroupObject = Group::findOrFail($workerGroup);
        return new GroupResource($workerGroupObject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $workerGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $workerGroup)
    {
        $workerGroup->name = $request->input('name');

        if($workerGroup->save()) {
            return new GroupResource($workerGroup);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Group $workerGroup
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Group $workerGroup)
    {
        if($workerGroup->delete()) {
            return new GroupResource($workerGroup);
        }
    }

    public function addWorker(Request $request){
        $worker = Worker::findOrFail($request->input('worker_id'));
        $workerGroup = Group::findOrFail($request->input('workergroup_id'));
        $worker->groups()->attach($workerGroup);

        if($workerGroup->save()){
            return new GroupResource($workerGroup);
        }
    }

    public function addLock(Request $request){
        $lock = Lock::findOrFail($request->input('lock_id'));
        $workerGroup = Group::findOrFail($request->input('workergroup_id'));
        $lock->groups()->attach($workerGroup);

        if($workerGroup->save()){
            return new GroupResource($workerGroup);
        }
    }
}
