<?php

namespace App\Http\Controllers;

use App\Lock;
use App\Worker;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $group = Group::paginate(20);
        return GroupResource::collection($group);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return GroupResource|Response
     */
    public function store(Request $request)
    {
        $group = new Group;

        $group->name = $request->input('name');

        if($group->save()) {
            return new GroupResource($group);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Group $workerGroup
     * @return Response
     */
    public function show(Group $workerGroup)
    {
        $workerGroupObject = Group::findOrFail($workerGroup);
        return new GroupResource($workerGroupObject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Group $workerGroup
     * @return Response
     */
    public function edit(Group $workerGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Group $workerGroup
     * @return GroupResource
     */
    public function update(Request $request, Group $workerGroup)
    {
        $workerGroup->name = $request->input('name');

        if($workerGroup->save()) {
            Helpers\LogHelper::Log($request->input('user_id'), $workerGroup, Helpers\LogHelper::Group, "Update"); //TODO Example logging
            return new GroupResource($workerGroup);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $workerGroup
     * @return Response
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
        return response("Save Failed", 500);
    }

    public function addLock(Request $request){
        $lock = Lock::findOrFail($request->input('lock_id'));
        $workerGroup = Group::findOrFail($request->input('workergroup_id'));
        $lock->groups()->attach($workerGroup);

        if($workerGroup->save()){
            return new GroupResource($workerGroup);
        }
    }

    public function deleteWorker(Request $request){
        $worker = $request->input('worker_id');
        $group = Group::findOrFail($request->input('workergroup_id'));
        $group->workers()->detach($worker);

        if($group->save()){
            return new GroupResource($group);
        }
         return response('Failed to Delete', 500);

    }

    public function deleteLock(Request $request){
        $lock = $request->input('lock_id');
        $group = Group::findOrFail($request->input('workergroup_id'));
        $group->locks()->detach($lock);

        if($group->save()){
             return new GroupResource($group);
        }
        return response('Failed to Delete', 500);
    }

}
