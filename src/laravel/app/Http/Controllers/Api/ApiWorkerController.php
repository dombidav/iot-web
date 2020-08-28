<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\FailedTo;
use App\Helpers\ApiKeyHelper;
use App\Helpers\ApiValidator;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
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
class ApiWorkerController extends Controller
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
        $workers = Worker::query();
        foreach (request()->all() as $key=>$value){
            $workers->orWhere($key,'like', '%'.$value.'%');
        }
        return WorkerResource::collection($workers->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return WorkerResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        ApiValidator::validate($request, [
            'name' => ['required', 'min:3'],
            'worker_rfid' => ['required']
        ]);

        $worker = new Worker;
        $worker->name = $request->input('name');
        $worker->worker_rfid = $request->input('worker_rfid');

        if($worker->save()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $worker, LogHelper::Worker, "Store");
            return new WorkerResource($worker);
        }
        return FailedTo::Store();
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
            return FailedTo::Find();
        return new WorkerResource($worker);
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
            return FailedTo::Find();
        $worker->name = $request->input('name') ?? $worker->name;
        $worker->worker_rfid = $request->input('rfid') ?? $worker->worker_rfid;

        if($worker->save()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom($request->header('api-key')), $worker, LogHelper::Worker, "Update");
            return new WorkerResource($worker);
        }
        return FailedTo::Update();
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
            return FailedTo::Find();
        if($worker->delete()) {
            LogHelper::Log(ApiKeyHelper::getUserFrom(request()->header('api-key')), $worker, LogHelper::Worker, "Destroy");
            return new WorkerResource($worker);
        }
        return FailedTo::Destroy();
    }
}
