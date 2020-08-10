<?php

namespace App\Http\Controllers;

use App\Lock;
use App\Worker;
use Illuminate\Http\Request;
use App\Helpers\ResponseWrapper;

class WorkerAccessController extends Controller
{
    /**
     * Checks if a worker can use a specific lock
     * @param Worker $worker
     * @param Lock $lock
     * @return bool
     */
    public static function WorkerCanUseLock(Worker $worker, Lock $lock): bool
    {
        foreach ($worker->groups as $group) {
            if ($lock->groups->contains($group)) {
                return true;
            }
        }
        return false;
    }

    public function access(Request $request)
    {
        if(!$request->filled('worker_rfid')) return(ResponseWrapper::wrap('Worker RFID missing', $request->all()) );
        if(!$request->filled('device_id')) return(ResponseWrapper::wrap('Device id missing', $request->all()) );

        $worker = Worker::rfid($request->get('worker_rfid'));
        if(!$worker) return ResponseWrapper::wrap('Worker not found', $request->all(), 404);

        $lock = Lock::find($request->get('device_id'));
        if(!$lock) return ResponseWrapper::wrap('Lock not found', $request->all(), 404);

        if(self::WorkerCanUseLock($worker, $lock)) return response(json_encode(["message" => "ok", "logged" => true]), 200);
        return response(json_encode(["message" => "denied", "logged" => true]), 403);
    }
}
