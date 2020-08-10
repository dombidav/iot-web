<?php

namespace App\Http\Controllers;

use App\Helpers\AccessControlSystem;
use App\Lock;
use App\Worker;
use Illuminate\Http\Request;
use App\Helpers\ResponseWrapper;

class WorkerAccessController extends Controller
{


    public function access(Request $request)
    {
        if(!$request->filled('worker_rfid')) return(ResponseWrapper::wrap('Worker RFID missing', $request->all()) );
        if(!$request->filled('device_id')) return(ResponseWrapper::wrap('Device id missing', $request->all()) );

        $worker = Worker::rfid($request->get('worker_rfid'));
        if(!$worker) return ResponseWrapper::wrap('Worker not found', $request->all(), 404);

        $lock = Lock::find($request->get('device_id'));
        if(!$lock) return ResponseWrapper::wrap('Lock not found', $request->all(), 404);

        if(AccessControlSystem::WorkerCanUseLock($worker, $lock)) return response(json_encode(["message" => "ok", "logged" => AccessControlSystem::Logging()]), 200);
        return response(json_encode(["message" => "denied", "logged" => AccessControlSystem::Logging()]), 403);
    }

    public function getStatus(){
        return response(json_encode(['status' => AccessControlSystem::Status()]));
    }

    public function setStatus(Request $request){
        if($request->filled('new_status')) {
            AccessControlSystem::Status($request->get('new_status'));
            return response('', 204);
        }
        return response(json_encode(['message' => 'New status was missing', 'status' => 400]), 400);

    }

    public function getLogging(){
        return response(json_encode(['status' => AccessControlSystem::Logging()]));
    }
}
