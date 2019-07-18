<?php

if (!function_exists('getChineseWeekday')) {

    function getChineseWeekday($yourDate)
    {
        $weekday = ['日', '一', '二', '三', '四', '五', '六'];

        /*
         * w
         * Numeric representation of the day of the week * 0 (for Sunday) through 6 (for Saturday)
         */
        $dayOfWeek = date('w', strtotime($yourDate));

        $weekday = sprintf('星期%s', $weekday[$dayOfWeek]);

        return $weekday;

    }
}

if (!function_exists('isYmdDate')) {

    function isYmdDate($yourDate, $symbol = '-')
    {
        $dateArray = explode($symbol, $yourDate);

        if (count($dateArray) != 3) {
            return false;
        }

        return checkdate($dateArray[1],$dateArray[2],$dateArray[0]);
    }
}
