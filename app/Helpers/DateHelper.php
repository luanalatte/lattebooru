<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function fuzzyDate($date)
    {
        if ($date === null) {
            return 'never';
        }

        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }

        $diff = (int) $date->diffInDays();

        if ($diff <= 1) {
            return 'recently';
        }

        if ($diff <= 7) {
            return 'this week';
        }

        if ($diff <= 31) {
            return 'this month';
        }

        if ($diff <= 60) {
            return 'last month';
        }

        if ($diff <= 365) {
            return 'this year';
        }

        return 'more than a year ago';
    }
}
