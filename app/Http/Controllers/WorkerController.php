<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseWrapper;
use App\Worker;
use Exception;
use App\Helpers\LogHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\WorkerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class WorkerController
 * @package App\Http\Controllers
 */
class WorkerController extends Controller
{
    /**
     * WorkerController constructor. Applies API-Key authentication middleware
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
        $workers = Worker::paginate(20);
        return WorkerResource::collection($workers);
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
     * @return WorkerResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        if(!$request->filled('name'))
            return ResponseWrapper::wrap('Name field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled('rfid'))
            return ResponseWrapper::wrap('rfid field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        $worker = new Worker;
        $worker->name = $request->input('name');
        $worker->rfid = $request->input('rfid');

        if($worker->save()) {
            LogHelper::Log($request->input('user_id'), $worker, LogHelper::Worker, "Store");
            return new WorkerResource($worker);
        }
        return ResponseWrapper::wrap('Worker not saved', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Worker $worker
     * @return WorkerResource|JsonResponse|Response
     */
    public function show(Worker $worker)
    {
        if(!$worker->exists)
            return ResponseWrapper::wrap('Worker not found', request()->all(), ResponseWrapper::NOT_FOUND);
        return new WorkerResource($worker);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Worker $worker
     * @return Response
     */
    public function edit(Worker $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Worker $worker
     * @return WorkerResource|JsonResponse
     */
    public function update(Request $request, Worker $worker)
    {
        if(!$worker->exists)
            return ResponseWrapper::wrap('Worker not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $worker->name = $request->filled('name') ? $request->input('name') : $worker->name;
        $worker->RFID = $request->filled('rfid') ? $request->input('rfid') : $worker->RFID;

        if($worker->save()) {
            LogHelper::Log($request->input('user_id'), $worker, LogHelper::Worker, "Update");
            return new WorkerResource($worker);
        }
        return ResponseWrapper::wrap('Worker not updated', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Worker $worker
     * @return WorkerResource|JsonResponse|Response
     * @throws Exception
     */
    public function destroy(Worker $worker)
    {
        if(!$worker->exists)
            return ResponseWrapper::wrap('Worker not found', request()->all(), ResponseWrapper::NOT_FOUND);
        if($worker->delete()) {
            LogHelper::Log(request()->input('user_id'), $worker, LogHelper::Worker, "Destroy");
            return new WorkerResource($worker);
        }
        return ResponseWrapper::wrap('Worker not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }
}
