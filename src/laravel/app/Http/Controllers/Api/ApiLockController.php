<?php

namespace App\Http\Controllers\Api;

use App\Device;
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return LockResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        if(!$request->filled('name'))
            return ResponseWrapper::wrap('Name field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled('category'))
            return ResponseWrapper::wrap('Category field missing', $request->all(), ResponseWrapper::BAD_REQUEST);

        $lock = new Lock();
        $lock->name = $request->input('name');
        $lock->status = $request->input('status');

        if($lock->save()){
            LogHelper::Log($request->input('user_id'), $lock, LogHelper::Lock, "Store");
            return new LockResource($lock);
        }
        return ResponseWrapper::wrap('Lock not saved', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Lock $lock
     * @return LockResource|Response
     */
    public function show(Lock $lock)
    {
        return new LockResource($lock);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lock $lock
     * @return Response
     */
    public function edit(Lock $lock)
    {

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
        if(!$lock->exists)
            return ResponseWrapper::wrap('Lock not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $lock->name = $request->filled('name')? $request->input('name') : $lock->name;
        $lock->status = $request->filled('status') ? $request->input('status') : $lock->status;

        if($lock->save()){
            LogHelper::Log($request->input('user_id'), $lock, LogHelper::Lock, "Update");
            return new LockResource($lock);
        }
        return ResponseWrapper::wrap('Device not updated', $request->all(), ResponseWrapper::SERVER_ERROR);
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
        if(!$lock->exists)
            return ResponseWrapper::wrap('Device not found', request()->all(), ResponseWrapper::NOT_FOUND);
        if($lock->delete()){
            LogHelper::Log(request()->input('user_id'), $lock, LogHelper::Lock, "Destroy");
            return "Lock deleted.";
        }
        return ResponseWrapper::wrap('Lock not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }

    public function keepAlive(Request $request, Device $device){
        if($device->exists){
            $device->setUpdatedAt(Date::now())->save();
            return new DeviceResource($device);
        }
        return ResponseWrapper::wrap('Device not found', $request->all(), 404);
    }
}
