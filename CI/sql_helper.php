<?php

/*
 *
 *
 *
 */

if (!function_exists("getWhereStr")) {
    /**
     * @param $data
     *
     * @return string
     */
    function getWhereStr($data)
    {
        $ci =& get_instance();

        if (!is_array($data) && !count($data) > 0) {
            return "";
        }

        $whereIn = "(" . implode(array_map(function ($data) use (&$ci) {
                return $ci->db->escape($data);
            }, $data), ',') . ")";

        return $whereIn;
    }
}
