<?php


namespace App\Helpers;


use App\Lock;
use App\Worker;

/**
 * Class AccessControlSystem: Helper function for ACS
 * @package App\Helpers
 */
abstract class AccessControlSystem
{
    public const Closed = 'Closed';
    public const Checked = 'Checked';
    public const Open = 'Open';
    public const Operational = 'Operational';

    private static $status = self::Operational;
    private static $logged = true;

    /**
     * Get status if param is null, set status otherwise
     * @param string|null $status
     * @return int
     */
    public static function Status($status = null){
        if(!$status) return self::$status;
        self::$status = $status;
        return self::$status;
    }

    /**
     * Get logging if param is null, set status otherwise
     * @param bool|null $status
     * @return bool
     */
    public static function Logging($status = null){
        if(!$status) return self::$logged;
        self::$logged = $status;
        return self::$logged;
    }

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
}
