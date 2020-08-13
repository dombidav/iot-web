<?php

namespace App\Http\Controllers;

use App\Device;
use App\Helpers;
use App\Helpers\LogHelper;
use App\Http\Resources\DeviceResource;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoryEnum|null $category
     * @return ResponseFactory|AnonymousResourceCollection|Response
     */
    public function index($category = null)
    {
        if($category){
            $devices=Device::where('category', '=', $category)->paginate(50);
        }else{
            $devices=Device::paginate(50);
        }
        return DeviceResource::collection($devices);
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
     * @return DeviceResource|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $device = new Device();
        $device->name = $request->input('name');
        $device->category = $request->input('category');

        if($device->save()){
            LogHelper::Log($request->input('user_id'), $device, LogHelper::Device, "Store");
            return new DeviceResource($device);
        }


        return response('Failed to Save', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Device $device
     * @return DeviceResource
     */
    public function show(Device $device)
    {
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
     * @return DeviceResource|ResponseFactory|Response
     */
    public function update(Request $request, Device $device)
    {
        $device->name = $request->filled('name')? $request->input('name') : $device->name;
        $device->category = $request->filled('category')? $request->input('category') : $device->category;



        if($device->save()){
            LogHelper::Log($request->input('user_id'), $device, LogHelper::Device, "Update");
            return new DeviceResource($device);

        }
        return response('Failed to Update', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $device
     * @return Response
     * @throws Exception ModelNotFoundException
     */
    public function destroy(Device $device)
    {
        if($device->delete()){
            LogHelper::Log(request()->input('user_id'), $device, LogHelper::Device, "Destroy");
            return response("Device deleted.");
        }
        return response('Failed to Delete', 500);
    }
}
