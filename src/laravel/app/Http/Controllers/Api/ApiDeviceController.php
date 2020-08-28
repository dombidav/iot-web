<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Exceptions\FailedTo;
use App\Helpers;
use App\Helpers\ApiKeyHelper;
use App\Helpers\ApiValidator;
use App\Helpers\LogHelper;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;

/**
 * Class DeviceController
 * @package App\Http\Controllers
 */
class ApiDeviceController extends Controller
{
    /**
     * DeviceController constructor. Applies API-Key authentication middleware
     */
    public function __construct()
    {
        $this->middleware('key.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResponseFactory|AnonymousResourceCollection|Response
     */
    public function index()
    {
        $devices = Device::query();
       foreach (request()->all() as $key => $value){
            $devices->orWhere($key, 'like', '%' . $value . '%');
        }
        return DeviceResource::collection($devices->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return DeviceResource|JsonResponse|object
     */
    public function store(Request $request)
    {
        ApiValidator::validate($request, [
            'category' => ['required']
        ]);

        $device = new Device();
        $device->name = $request->input('name') ?? Str::random();

        foreach ($request->all() as $key => $value){
            $device->$key = $value;
        }

        if(!$request->input('timeout'))
            $device->timeout = 30;

        if($device->save()){
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $device, LogHelper::Device, "Store");
            return new DeviceResource($device);
        }
        return FailedTo::Store();
    }

    /**
     * Handles the device keep alive message
     * @param Request $request
     * @param Device $device
     * @return DeviceResource|JsonResponse
     */
    public function keepAlive(Request $request, Device $device){
        if(!$device || !$device->exists)
            return FailedTo::Find();
        $device->setUpdatedAt(Date::now())->save();
        return new DeviceResource($device);
    }

    /**
     * Display the specified resource.
     *
     * @param Device $device
     * @return DeviceResource|JsonResponse
     */
    public function show(Device $device)
    {
        if(!$device || !$device->exists)
            return FailedTo::Find();
        return new DeviceResource($device);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Device $device
     * @return DeviceResource|ResponseFactory|JsonResponse|Response
     */
    public function update(Request $request, Device $device)
    {
        if(!$device || !$device->exists)
            return FailedTo::Find();

        $device->name = $request->input('name') ?? $device->name;

        foreach ($request->all() as $key => $value){
            $device->$key = $value;
        }

        if($device->save()){
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $device, LogHelper::Device, "Update");
            return new DeviceResource($device);

        }
        return FailedTo::Update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $device
     * @return DeviceResource|JsonResponse|Response
     * @throws Exception ModelNotFoundException
     */
    public function destroy(Device $device)
    {
        if(!$device || !$device->exists)
           return FailedTo::Find();

        if($device->delete()){
            LogHelper::Log(ApiKeyHelper::getUserFrom(request()->header('api-key')), $device, LogHelper::Device, "Destroy");
            return new DeviceResource($device);
        }
        return FailedTo::Destroy();
    }
}
