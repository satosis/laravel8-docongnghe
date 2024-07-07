<?php

namespace App\HelpersClass;
use Carbon\Carbon;

class Date
{
    public static function getListDayInMonth($month)
    {
        $arrayDay = [];
        $year     = date('Y');
        $maxDay = Carbon::now()->month($month)->daysInMonth;
        // Lấy tất cả các ngày trong tháng
        for ($day =  1; $day <= $maxDay ; $day ++)
        {
            $time = mktime(12,0,0, $month, $day, $year);
                if (date('m', $time) == $month)
                    $arrayDay[] = date('Y-m-d', $time);
        }

        return $arrayDay;
    }
}
