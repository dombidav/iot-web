<?php

namespace App\Http\Controllers\Api;

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
     * @return LogResource|JsonResponse|Response
     */
    public function store(Request $request)
    {
        if(!$request->filled('person_id'))
            return ResponseWrapper::wrap('Person_id field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled('subject_id'))
            return ResponseWrapper::wrap('Subject_id field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled('description'))
            return ResponseWrapper::wrap('Description field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        if(!$request->filled('model'))
            return ResponseWrapper::wrap('Model field missing', $request->all(), ResponseWrapper::BAD_REQUEST);
        $log = new Log();
        $log->person_id=$request->input('person_id');
        $log->subject_id=$request->input('subject_id');
        $log->description=$request->input('description');
        $log->model=$request->input('model');

        if($log->save()){
            return new LogResource($log);
        }
        return ResponseWrapper::wrap('Log not saved', $request->all(), ResponseWrapper::SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Log $log
     * @return LogResource|JsonResponse|Response
     */
    public function show(Log $log)
    {
        if(!$log->exists)
            return ResponseWrapper::wrap('Log not found', request()->all(), ResponseWrapper::NOT_FOUND);
        return new LogResource($log);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Log $log
     * @return Response
     */
    public function edit(Log $log)
    {
        //
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
        if(!$log->exists)
            return ResponseWrapper::wrap('Log not found', request()->all(), ResponseWrapper::NOT_FOUND);
        $log->person_id=$request->filled('person_id')? $request->input('person_id') : $log->person_id;
        $log->subject_id=$request->filled('subject_id')? $request->input('subject_id') : $log->subject_id;
        $log->description=$request->filled('description')? $request->input('description') : $log->description;
        $log->model=$request->filled('model')?$request->input('model'):$log->model;

        if($log->save()){
            return new LogResource($log);
        }
        return ResponseWrapper::wrap('Log not updated', $request->all(), ResponseWrapper::SERVER_ERROR);
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
        if(!$log->exists)
            return ResponseWrapper::wrap('Log not found', request()->all(), ResponseWrapper::NOT_FOUND);
        if($log->delete()){
            return new LogResource($log);
        }
        return ResponseWrapper::wrap('Log not deleted', request()->all(), ResponseWrapper::SERVER_ERROR);
    }
}
