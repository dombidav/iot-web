<?php


namespace App\Helpers;


use Spatie\Enum\Enum;

/**
 * @method static self other()
 * @method static self thermometer()
 * @method static self rfid_reader()
 * @method static self heater()
 * @method static self fan()
 */
class CategoryEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'other' => 1,
            'thermometer' => 2,
            'rfid_reader' => 3,
            'heater' => 4,
            'fan' => 5,
        ];
    }
}
