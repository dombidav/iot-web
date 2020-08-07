<?php

namespace App\Http\Controllers;

use App\Lock;
use App\Worker;
use App\WorkerGroup;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\WorkerGroupResource;

class WorkerGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workerGroup = WorkerGroup::paginate(20);
        return WorkerGroupResource::collection($workerGroup);
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
        $workerGroup = new WorkerGroup;

        $workerGroup->name = $request->input('name');

        if($workerGroup->save()) {
            return new WorkerGroupResource($worker);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkerGroup  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function show(WorkerGroup $workerGroup)
    {
        $workerGroupObject = WorkerGroup::findOrFail($workerGroup);
        return new WorkerGroupResource($workerGroupObject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkerGroup  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkerGroup $workerGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkerGroup  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkerGroup $workerGroup)
    {
        $workerGroup->name = $request->input('name');

        if($workerGroup->save()) {
            return new WorkerGroupResource($workerGroup);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\WorkerGroup $workerGroup
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(WorkerGroup $workerGroup)
    {
        if($workerGroup->delete()) {
            return new WorkerGroupResource($workerGroup);
        }
    }

    public function addWorker(Request $request){
        $worker = Worker::findOrFail($request->input('worker_id'));
        $workerGroup = WorkerGroup::findOrFail($request->input('workergroup_id'));
        $worker->groups()->attach($workerGroup);

        if($workerGroup->save()){
            return new WorkerGroupResource($workerGroup);
        }
    }

    public function addLock(Request $request){
        $lock = Lock::findOrFail($request->input('lock_id'));
        $workerGroup = WorkerGroup::findOrFail($request->input('workergroup_id'));
        $lock->groups()->attach($workerGroup);

        if($workerGroup->save()){
            return new WorkerGroupResource($workerGroup);
        }
    }
}
