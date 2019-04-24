<?php
/**
 * Date: 2019/4/24
 * Time: 下午 02:34
 */

if (!function_exists('unique_multidim_array')) {

    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i          = 0;
        $key_array  = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i]  = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}

if (!function_exists('resetArrayIndex')) {

    function resetArrayIndex($array)
    {
        $is_number = false;
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = resetArrayIndex($value);
                if (is_numeric($key)) {
                    $is_number = true;
                }
            }
        }
        if ($is_number) {
            return array_values($array);
        } else {
            return $array;
        }
    }
}

