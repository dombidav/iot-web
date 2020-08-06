<?php

namespace App\Http\Controllers;

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
     * @param  \App\WorkerGroup  $workerGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkerGroup $workerGroup)
    {
        if($workerGroup->delete()) {
            return new WorkerGroupResource($workerGroup);
        }
    }
}
