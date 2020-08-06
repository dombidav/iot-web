<?php

namespace App\Http\Controllers;

use App\Device;
use App\Helpers\CategoryEnum;
use App\Http\Resources\DeviceResource;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoryEnum|null $category
     * @return AnonymousResourceCollection
     */
    public function index(CategoryEnum $category = null)
    {
        if($category != null){
            $devices=Device::where('category', '=', $category->value)->paginate(10);
        }else{
            $devices=Device::paginate(10);
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
        //
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

        if($device->save()){
            return new DeviceResource($device);
        }
        return response('Failed to Save', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Device $device
     * @return Response
     */
    public function show(Device $device)
    {
        return response(new DeviceResource($device));
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

        if($device->save()){
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
            return response("Device deleted.");
        }
        return response('Failed to Delete', 500);
    }
}
