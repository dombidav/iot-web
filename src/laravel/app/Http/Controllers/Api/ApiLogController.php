<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\FailedTo;
use App\Helpers\ApiValidator;
use App\Helpers\ResponseWrapper;
use App\Http\Controllers\Controller;
use App\Log;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources;
use App\Http\Resources\LogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class ApiLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        $logs=Log::query();
        foreach (request()->all() as $key=>$value){
            $logs->orWhere($key,'like', '%'.$value.'%');
        }
        return LogResource::collection($logs->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return LogResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        ApiValidator::validate($request, [
            'person_id' => ['required'],
            'subject_id' => ['required'],
            'description' => ['required'],
            'model' => ['required']
        ]);
        $log = new Log();
        $log->person_id=$request->input('person_id');
        $log->subject_id=$request->input('subject_id');
        $log->description=$request->input('description');
        $log->model=$request->input('model');

        if($log->save()){
            return new LogResource($log);
        }
        return FailedTo::Store();
    }

    /**
     * Display the specified resource.
     *
     * @param Log $log
     * @return LogResource|JsonResponse|Response
     */
    public function show(Log $log)
    {
        if(!$log || !$log->exists)
            return FailedTo::Find();
        return new LogResource($log);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Log $log
     * @return LogResource|JsonResponse|Response
     */
    public function update(Request $request, Log $log)
    {
        if(!$log || !$log->exists)
            return FailedTo::Find();
        $log->person_id =   $request->input('person_id')   ?? $log->person_id;
        $log->subject_id =  $request->input('subject_id')  ?? $log->subject_id;
        $log->description = $request->input('description') ?? $log->description;
        $log->model =       $request->input('model')       ?? $log->model;

        if($log->save()){
            return new LogResource($log);
        }
        return FailedTo::Update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Log $log
     * @return Response|string
     * @throws Exception
     */
    public function destroy(Log $log)
    {
        if(!$log || !$log->exists)
            return FailedTo::Find();
        if($log->delete()){
            return new LogResource($log);
        }
        return FailedTo::Destroy();
    }
}
