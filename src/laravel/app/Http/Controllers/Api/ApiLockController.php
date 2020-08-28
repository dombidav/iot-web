<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Exceptions\FailedTo;
use App\Helpers\AccessControlSystem;
use App\Helpers\ApiKeyHelper;
use App\Helpers\ApiValidator;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use App\Lock;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;
use App\Http\Resources\LockResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

/**
 * Class LockController
 * @package App\Http\Controllers
 */
class ApiLockController extends Controller
{
    /**
     * LockController constructor. Applies API-Key authentication middleware
     */
    public function __construct()
    {
        $this->middleware('key.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        $locks = Lock::query();
        foreach (request()->all() as $key=>$value){
            $locks->orWhere($key, 'like', '%'.$value.'%');
        }
        return LockResource::collection($locks->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return LockResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        ApiValidator::validate($request, [
            'device_id' => 'required'
        ]);

        $lock = new Lock();
        $lock->device_id = $request->input('device_id');
        $lock->name = $request->input('name') ?? Str::random(16);
        $lock->status = $request->input('status') ?? AccessControlSystem::Operational;

        if($lock->save()){
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $lock, LogHelper::Lock, "Store");
            return new LockResource($lock);
        }
        return FailedTo::Store();
    }

    /**
     * Display the specified resource.
     *
     * @param Lock $lock
     * @return LockResource|JsonResponse|Response|object
     */
    public function show(Lock $lock)
    {
        if(!$lock || !$lock->exists)
            return FailedTo::Find();
        return new LockResource($lock);
    }

    /**
     * Handles the lock keep alive message
     * @param Request $request
     * @param Lock $lock
     * @return LockResource|JsonResponse
     */
    public function keepAlive(Request $request, Lock $lock){
        if(!$lock || !$lock->exists)
            return FailedTo::Find();
        $lock->setUpdatedAt(Date::now())->save();
        return new LockResource($lock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Lock $lock
     * @return LockResource|JsonResponse|Response
     */
    public function update(Request $request, Lock $lock)
    {
        if(!$lock || !$lock->exists)
            return FailedTo::Find();

        $lock->name = $request->input('name') ?? $lock->name;
        $lock->status = $request->input('status') ?? $lock->status;

        if($lock->save()){
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $lock, LogHelper::Lock, "Update");
            return new LockResource($lock);
        }
        return FailedTo::Update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lock $lock
     * @return Response|string
     * @throws Exception
     */
    public function destroy(Lock $lock)
    {
        if(!$lock || !$lock->exists)
            return FailedTo::Find();
        if($lock->delete()){
            LogHelper::Log(ApiKeyHelper::getUserFrom(request()->header('api-key')), $lock, LogHelper::Lock, "Destroy");
            return new LockResource($lock);
        }
        return FailedTo::Destroy();
    }
}
