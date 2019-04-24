<?php
if (!function_exists("getStrBefore")) {

    function getStrBefore($str, $before)
    {
        $pos = strpos($str, $before);

        if ($pos === false) {
            return $str;
        }

        return substr($str, 0, $pos);
    }
}

if (!function_exists("cutStr")) {

    function cutStr($str, $length)
    {
        $word  = "";
        $chars = preg_split('//u', $str, null, PREG_SPLIT_NO_EMPTY);

        foreach ($chars as $char) {
            $currentLen = mixStrLen($word);
            if ($currentLen < $length) {
                $word .= $char;
            }
        }

        if (mixStrLen($word) > $length) {
            $word = mb_substr($word, 0, mb_strlen($word) - 1);
        }

        return $word;
    }
}

if (!function_exists("mixStrLen")) {

    function mixStrLen($str)
    {
        return (strlen($str) + mb_strlen($str, 'UTF-8')) / 2;
    }
}

if (!function_exists("engToLower")) {

    function engToLower($str)
    {
        $chars = preg_split('//u', $str, null, PREG_SPLIT_NO_EMPTY);

        $final = '';

        foreach ($chars as $char) {
            $ordStr = ord($char);
            if ($ordStr >= 65 && $ordStr <= 90) {
                $ordStr += 32;

                $char = chr($ordStr);
            }

            $final .= $char;
        }
        return $final;
    }
}

if (!function_exists("randomAlphaBet")) {

    function randomAlphaBet($length = 6)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        srand((double)microtime() * 1000000);

        $i = 0;

        $range = strlen($chars) - 1;

        $str = "";

        while ($i < $length) {
            $index = rand() % $range;
            $str   .= substr($chars, $index, 1);
            $i++;
        }

        return $str;
    }
}
