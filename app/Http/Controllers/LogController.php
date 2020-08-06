<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use App\Http\Resources;
use App\Http\Resources\LogResource;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log=Log::paginate(15);
        return response(LogResource::collection($log));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $log=new Log();
        $log->person_id=$request->input('person_id');
        $log->subject_id=$request->input('subject_id');
        $log->description=$request->input('description');
        $log->model=$request->input('model');

        if($log->save()){
            return response(new LogResource($log));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $log=Log::findOrFail($id);
        return response(new LogResource($log));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $log=Log::findOrFail($id);
        $log->person_id=$request->filled('person_id')? $request->input('person_id') : $log->person_id;
        $log->subject_id=$request->filled('subject_id')? $request->input('subject_id') : $log->subject_id;
        $log->description=$request->filled('description')? $request->input('description') : $log->description;
        $log->model=$request->filled('model')?$request->input('model'):$log->model;

        if($log->save()){
            return response(new LogResource($log));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $log=Log::findOrFail($id);
        if($log->delete()){
            return response("Log deleted");
        }
    }
}
