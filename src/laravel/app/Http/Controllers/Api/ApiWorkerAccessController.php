<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Helpers\AccessControlSystem;
use App\Helpers\ApiValidator;
use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Lock;
use App\Worker;
use Illuminate\Http\Request;
use App\Helpers\ResponseWrapper;
use Illuminate\Http\Response;

/**
 * Class WorkerAccessController
 * @package App\Http\Controllers
 */
class ApiWorkerAccessController extends Controller
{
    /**
     * WorkerAccessController constructor. Applies API-Key authentication middleware
     */
    public function __construct()
    {
        $this->middleware('key.auth');
    }

    public function access(Request $request)
    {
        ApiValidator::validate($request, [
            'worker_rfid' => ['required', 'exists:worker'],
            'device_id' => ['required', 'exists:lock']
        ]);

        $worker = Worker::rfid($request->input('worker_rfid'));
        $lock = Lock::deviceID($request->input('device_id'));
        $ok = AccessControlSystem::WorkerCanUseLock($worker, $lock);

        return response()->json(['allowed' => $ok])->setStatusCode($ok ? Response::HTTP_ACCEPTED : Response::HTTP_LOCKED);
    }

    public function getStatus()
    {
        return response()->json(['data' => AccessControlSystem::Status()]);
    }

    public function setStatus(Request $request)
    {
        ApiValidator::validate($request, [
            'new_status' => 'required' //TODO: Valid status?
        ]);

        AccessControlSystem::Status($request->get('new_status'));
        return response('', 204);

    }

    public function getLogging()
    {
        return response()->json(['data' => AccessControlSystem::Logging()]);
    }

    public function setLogging(Request $request)
    {
        ApiValidator::validate($request, [
            'new_logging' => 'required' //TODO: Valid status?
        ]);

        AccessControlSystem::Logging($request->get('new_logging'));
        return response('', 204);
    }
}
