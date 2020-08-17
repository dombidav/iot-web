<?php

namespace App\Http\Controllers\Api;

use App\Helpers\LogHelper;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
use App\Lock;
use App\Worker;
use App\Group;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class GroupController
 * @package App\Http\Controllers
 */
class ApiGroupController extends Controller
{
    /**
     * GroupController constructor. Applies API-Key authentication middleware
     */
    public function __construct()
    {
        $this->middleware('key.auth');
    }
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
     * @return GroupResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        $group = new Group;

        $group->name = $request->input('name');
        if(!$request->filled('name'))
            return ResponseWrapper::wrap('Name field missing', $request->all(), ResponseWrapper::BAD_REQUEST);

        if($group->save()) {
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Store");
            return new GroupResource($group);
        }
        return ResponseWrapper::wrap('Group not saved', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Group $workerGroup
     * @return GroupResource|JsonResponse
     */
    public function show($workerGroup)
    {
        $workerGroupObject = Group::find($workerGroup);
        if(!$workerGroupObject || !$workerGroupObject->exists){
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);
        }
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
     * @param Group $group
     * @return GroupResource|JsonResponse
     */
    public function update(Request $request, Group $group)
    {
        if(!$group->exists)
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $group->name = $request->input('name');

        if($group->save()) {
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Update");
            return new GroupResource($group);
        }
        return ResponseWrapper::wrap('Device not updated', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $workerGroup
     * @return GroupResource|JsonResponse|Response
     * @throws Exception
     */
    public function destroy($workerGroup)
    {
        $workerGroup = Group::find($workerGroup);
        if(!$workerGroup->exists)
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);
        if($workerGroup->delete()) {
            LogHelper::Log(request()->header('api-key'), $workerGroup, LogHelper::Group, "Destroy");
            return new GroupResource($workerGroup);
        }
        return ResponseWrapper::wrap('Group not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }

    public function addWorker(Request $request){
        if(!$request->filled(('worker_id')))
            return ResponseWrapper::wrap('Worker ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled(('group_id')))
            return ResponseWrapper::wrap('Group ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);
        $worker = Worker::find($request->input('worker_id'));
        if(!$worker || !$worker->exists)
            return ResponseWrapper::wrap('Worker not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $workerGroup = Group::find($request->input('group_id'));
        if(!$workerGroup->exists)
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $worker->groups()->attach($workerGroup);

        if($workerGroup->save()){
            LogHelper::Log($request->header('api-key'), $workerGroup, LogHelper::Group, "Added Worker");
            return new GroupResource($workerGroup);
        }
        return ResponseWrapper::wrap('Worker not added to Group', request()->all(), ResponseWrapper::SERVER_ERROR);
    }

    public function addLock(Request $request){
        if(!$request->filled('lock_id'))
            return ResponseWrapper::wrap('Lock ID not found', request()->all(), ResponseWrapper::BAD_REQUEST) ;
        if(!$request->filled(('group_id')))
            return ResponseWrapper::wrap('Group ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);

        $lock = Lock::find($request->input('lock_id'));
        if(!$lock || !$lock->exists)
            return ResponseWrapper::wrap('Lock not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $group = Group::find($request->input('group_id'));
        if(!$group->exists)
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $lock->groups()->attach($group);

        if($group->save()){
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Added Lock");
            return new GroupResource($group);
        }
        return ResponseWrapper::wrap('Worker not added', request()->all(), ResponseWrapper::SERVER_ERROR);
    }

    public function deleteWorker(Request $request){
        if(!$request->filled(('worker_id')))
            return ResponseWrapper::wrap('Worker ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled(('group_id')))
            return ResponseWrapper::wrap('Group ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);

        $worker = Worker::find($request->input('worker_id'));
        if(!$worker || !$worker->exists)
            return ResponseWrapper::wrap('Worker not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $group = Group::find($request->input('group_id'));
        if(!$group->exists)
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $group->workers()->detach($worker);

        if($group->save()){
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Removed Worker");
            return new GroupResource($group);
        }
        return ResponseWrapper::wrap('Worker not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);

    }

    public function deleteLock(Request $request)
    {
        if (!$request->filled(('lock_id')))
            return ResponseWrapper::wrap('Lock ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);
        if (!$request->filled(('group_id')))
            return ResponseWrapper::wrap('Group ID missing', request()->all(), ResponseWrapper::BAD_REQUEST);

        $lock = Lock::find($request->input('worker_id'));
        if (!$lock || !$lock->exists)
            return ResponseWrapper::wrap('Lock not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $group = Group::find($request->input('group_id'));
        if (!$group->exists)
            return ResponseWrapper::wrap('Group not found', request()->all(), ResponseWrapper::NOT_FOUND);

        $group->workers()->detach($lock);

        if ($group->save()) {
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Removed Worker");
            return new GroupResource($group);
        }
        return ResponseWrapper::wrap('Lock not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }
}
