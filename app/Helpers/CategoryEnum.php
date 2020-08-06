<?php


namespace App\Helpers;


use Spatie\Enum\Enum;

/**
 * @method static self thermometer()
 * @method static self rfid_reader()
 * @method static self heater()
 * * @method static self fan()
 */
class CategoryEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'thermometer' => 1,
            'rfid_reader' => 2,
            'heater' => 3,
            'fan' => 4
        ];
    }
}
