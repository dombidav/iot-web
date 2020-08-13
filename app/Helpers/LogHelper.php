<?php


namespace App\Helpers;


use App\Log;
use App\User;
use App\Worker;
use Jenssegers\Mongodb\Eloquent\Model;

class LogHelper
{
    public const Worker = "worker";
    public const Device = "device";
    public const Lock = "lock";
    public const Group = "group";
    public const User = "user";
    public const Access = "access-control";

    /**
     * @param User|Worker $person
     * @param Model $subject
     * @param string $module
     * @param string | array $description
     */
    public static function Log($person, Model $subject, string $module, $description) : void {
        $log = new Log([
            'person_id' => $person ?? '',
            'subject_id' => $subject instanceof Model ? $subject->id : ($subject ?? ''),
            'module' => $module,
            'description' => $description
        ]);
        $log->save();
    }
}
