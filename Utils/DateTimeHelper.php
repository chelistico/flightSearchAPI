<?php

namespace App\Utils;

use DateTime;

class DateTimeHelper
{
    public static function getDifferenceInHours(DateTime $start, DateTime $end): int
    {
        $interval = $start->diff($end);
        return ($interval->days * 24) + $interval->h;
    }
}
