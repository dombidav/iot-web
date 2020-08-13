<?php

namespace App\Http\Controllers;

use App\Worker;
use Exception;
use App\Helpers\LogHelper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\WorkerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class WorkerController extends Controller
{
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
     * @return WorkerResource|Response
     */
    public function store(Request $request)
    {
        $worker = new Worker;

        $worker->name = $request->input('name');
        $worker->rfid = $request->input('rfid');

        if($worker->save()) {
            LogHelper::Log($request->input('user_id'), $worker, LogHelper::Worker, "Store");
            return new WorkerResource($worker);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Worker $worker
     * @return WorkerResource|Response
     */
    public function show(Worker $worker)
    {
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
     * @return WorkerResource
     */
    public function update(Request $request, Worker $worker)
    {
        $worker->name = $request->filled('name') ? $request->input('name') : $worker->name;
        $worker->rfid = $request->filled('rfid') ? $request->input('rfid') : $worker->rfid;

        if($worker->save()) {
            LogHelper::Log($request->input('user_id'), $worker, LogHelper::Worker, "Update");
            return new WorkerResource($worker);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Worker $worker
     * @return WorkerResource|Response
     * @throws Exception
     */
    public function destroy(Worker $worker)
    {
        if($worker->delete()) {
            LogHelper::Log($request->input('user_id'), $worker, LogHelper::Worker, "Destroy");
            return new WorkerResource($worker);

        }
    }
}
