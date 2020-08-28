<?php


namespace App\Helpers;


use App\Log;
use App\User;
use App\Worker;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class LogHelper: Helper functions for Logging
 * @package App\Helpers
 */
class LogHelper
{
    public const Worker = "worker";
    public const Device = "device";
    public const Lock = "lock";
    public const Group = "group";
    public const User = "user";
    public const Access = "access-control";

    /**
     * Save a new Log Record
     * @param User|Worker|string $person
     * @param Model $subject
     * @param string $module
     * @param string | array $description
     */
    public static function Log($person, Model $subject, string $module, $description) : void {
        if(ApiKeyHelper::isValid($person))
            $person = User::where('apiKey', $person)->first();
        else if (is_string($person))
            $person = Worker::rfid($person);
        $log = new Log([
            'person_id' => $person ?? '',
            'subject_id' => $subject instanceof Model ? $subject->id : ($subject ?? ''),
            'module' => $module,
            'description' => $description
        ]);
        $log->save();
    }
}
