<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Helpers;
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
     * @param string|null $category
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
     * @return DeviceResource|ResponseFactory|JsonResponse|Response
     */
    public function store(Request $request)
    {
        if(!$request->filled('name'))
            return ResponseWrapper::wrap('Name field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled('category'))
            return ResponseWrapper::wrap('Category field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        $device = new Device();
        $device->name = $request->input('name');
        $device->category = $request->input('category');

        if($device->save()){
            LogHelper::Log($request->header('api-key'), $device, LogHelper::Device, "Store");
            return new DeviceResource($device);
        }

        return ResponseWrapper::wrap('Device not saved', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Handles the device keep alive message
     * @param Request $request
     * @param Device $device
     * @return DeviceResource|JsonResponse
     */
    public function keepAlive(Request $request, Device $device){
        if($device->exists){
            $device->setUpdatedAt(Date::now())->save();
            return new DeviceResource($device);
        }
        return ResponseWrapper::wrap('Device not found', $request->all(), ResponseWrapper::NOT_FOUND);
    }

    /**
     * Display the specified resource.
     *
     * @param Device $device
     * @return DeviceResource|JsonResponse
     */
    public function show(Device $device)
    {
        if(!$device->exists)
            return ResponseWrapper::wrap('Device not found', request()->all(), ResponseWrapper::NOT_FOUND);
        return new DeviceResource($device);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Device $device
     * @return Response
     */
    public function edit(Device $device)
    {
        //
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
        if(!$device->exists)
            return ResponseWrapper::wrap('Device not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $device->name = $request->filled('name')? $request->input('name') : $device->name;
        $device->category = $request->filled('category')? $request->input('category') : $device->category;

        if($device->save()){
            LogHelper::Log($request->header('api-key'), $device, LogHelper::Device, "Update");
            return new DeviceResource($device);

        }
        return ResponseWrapper::wrap('Device not updated', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $device
     * @return JsonResponse|Response
     * @throws Exception ModelNotFoundException
     */
    public function destroy(Device $device)
    {
        if(!$device->exists)
            return ResponseWrapper::wrap('Device not found', request()->all(), ResponseWrapper::NOT_FOUND);
        if($device->delete()){
            LogHelper::Log(request()->header('api-key'), $device, LogHelper::Device, "Destroy");
            return response("Device deleted.");
        }
        return ResponseWrapper::wrap('Device not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }
}
