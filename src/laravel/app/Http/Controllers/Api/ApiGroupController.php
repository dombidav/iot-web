<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\FailedTo;
use App\Helpers\ApiKeyHelper;
use App\Helpers\ApiValidator;
use App\Helpers\LogHelper;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerResource;
use App\Lock;
use App\Worker;
use App\Group;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
     * @return GroupResource|AnonymousResourceCollection
     */
    public function index()
    {
        $search = request()->query('search');
        $search = Str::length($search) > 0 ? $search : '.*';

        $groups = Group::where('name', 'regexp', '/' . $search . '/i');

        $length = intval(request()->query('length') ?? 10);
        $order = request()->query('column') ?? '_id';
        if ($order == 'id')
            $order = '_id';
        $direction = request()->query('dir') ?? 'ASC';

        $groups->orderBy($order, $direction);

        return new GroupResource($groups->paginate($length));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return GroupResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        ApiValidator::validate($request, [
            'name' => ['required', 'min:10']
        ]);
        $group = new Group;
        $group->name = $request->input('name');

        if($group->save()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $group, LogHelper::Group, "Store");
            return new GroupResource($group);
        }
        return FailedTo::Store();
    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return GroupResource|JsonResponse
     */
    public function show($group)
    {
        if(!$group || !$group->exists)
            return FailedTo::Find();
        return new GroupResource($group);
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
        if(!$group || !$group->exists)
            return FailedTo::Find();

        $group->name = $request->input('name') ?? $group->name;

        if($group->save()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $group, LogHelper::Group, "Update");
            return new GroupResource($group);
        }
        return FailedTo::Update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return GroupResource|JsonResponse|Response
     * @throws Exception
     */
    public function destroy($group)
    {
        if(!$group || !$group->exists)
            FailedTo::Find();
        if($group->delete()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom(request()->header('api-key')), $group, LogHelper::Group, "Destroy");
            return new GroupResource($group);
        }
        return FailedTo::Destroy();
    }

    public function addWorker(Request $request){
        ApiValidator::validate($request, [
            'worker_id' => ['required', 'exists:worker'],
            'group_id' => ['required', 'exists:group']
        ]);

        $worker = Worker::find($request->input('worker_id'));
        $group = Group::find($request->input('group_id'));

        $worker->groups()->attach($group);

        if($group->save()){
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Added Worker");
            return new GroupResource($group);
        }
        return FailedTo::Attach();
    }

    public function addLock(Request $request){
        ApiValidator::validate($request, [
            'lock_id' => ['required', 'exists:lock'],
            'group_id' => ['required', 'exists:group']
        ]);

        $lock = Lock::find($request->input('lock_id'));
        $group = Group::find($request->input('group_id'));

        $lock->groups()->attach($group);

        if($group->save()){
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Added Lock");
            return new GroupResource($group);
        }
        return FailedTo::Attach();
    }

    public function deleteWorker(Request $request){
        ApiValidator::validate($request, [
            'worker_id' => ['required', 'exists:worker'],
            'group_id' => ['required', 'exists:group']
        ]);

        $worker = Worker::find($request->input('worker_id'));
        $group = Group::find($request->input('group_id'));

        $group->workers()->detach($worker);

        if($group->save()){
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Removed Worker");
            return new GroupResource($group);
        }

        return FailedTo::Detach();

    }

    public function deleteLock(Request $request)
    {
        ApiValidator::validate($request, [
            'lock_id' => ['required', 'exists:lock'],
            'group_id' => ['required', 'exists:group']
        ]);

        $lock = Lock::find($request->input('lock_id'));
        $group = Group::find($request->input('group_id'));

        $group->workers()->detach($lock);

        if ($group->save()) {
            LogHelper::Log($request->header('api-key'), $group, LogHelper::Group, "Removed Worker");
            return new GroupResource($group);
        }

        return FailedTo::Detach();
    }
}
