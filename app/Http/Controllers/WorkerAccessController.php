<?php

namespace App\Http\Controllers;

use App\Helpers\AccessControlSystem;
use App\Helpers\LogHelper;
use App\Lock;
use App\Worker;
use Illuminate\Http\Request;
use App\Helpers\ResponseWrapper;

class WorkerAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('key.auth');
    }

    public function access(Request $request)
    {
        if(!$request->filled('worker_rfid')) return(ResponseWrapper::wrap('Worker RFID missing', $request->all()) );
        if(!$request->filled('device_id')) return(ResponseWrapper::wrap('Device id missing', $request->all()) );

        $worker = Worker::rfid($request->get('worker_rfid'));
        if(!$worker) return ResponseWrapper::wrap('Worker not found', $request->all(), 404);

        $lock = Lock::find($request->get('device_id'));
        if(!$lock) return ResponseWrapper::wrap('Lock not found', $request->all(), 404);

        if(AccessControlSystem::WorkerCanUseLock($worker, $lock)) {
            LogHelper::Log($request->input('user_id'), $lock, LogHelper::Access, ['Operation' => 'Access', 'Worker' => $worker, 'Lock' => $lock, 'WasAllowed' => true]);
            return response()->json(["message" => "ok", "logged" => AccessControlSystem::Logging()])->setStatusCode(200);
        }

        LogHelper::Log($request->input('user_id'), $lock, LogHelper::Access, ['Operation' => 'Access', 'Worker' => $worker, 'Lock' => $lock, 'WasAllowed' => false]);
        return response()->json(["message" => "denied", "logged" => AccessControlSystem::Logging()])->setStatusCode(403);
    }

    public function getStatus(){
        return response()->json(['data' => AccessControlSystem::Status()]);
    }

    public function setStatus(Request $request){
        if($request->filled('new_status')) {
            AccessControlSystem::Status($request->get('new_status'));
            return response('', 204);
        }
        return response()->json(['message' => 'New status was missing', 'status' => 400])->setStatusCode(400);

    }

    public function getLogging(){
        return response()->json(['data' => AccessControlSystem::Logging()]);
    }

    public function setLogging(Request $request){
        if($request->filled('new_logging')) {
            AccessControlSystem::Logging($request->get('new_logging'));
            return response('', 204);
        }
        return response()->json(['message' => 'New logging was missing', 'status' => 400])->setStatusCode(400);
    }
}
