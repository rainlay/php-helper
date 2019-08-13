<?php

if (!function_exists('cassandraRowsToPhpArray')) {

    function cassandraRowsToPhpArray($rows)
    {
        $result = [];
        if (get_class($rows) == 'Cassandra\Rows') {
            foreach ($rows as $value) {
                $result[] = cassandraArrayToPhpValue($value);
            }
        }
        return $result;
    }
}

if (!function_exists('cassandraArrayToPhpValue')) {

    /**
     * 轉換 cassandra array & object to php value
     * Not all object type support yet
     *
     * @param $array
     *
     * @return array|bool
     */
    function cassandraArrayToPhpValue($array)
    {
        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $key => $row) {
            if (gettype($row) == 'object') {
                switch (get_class($row)) {
                    case 'Cassandra\Timeuuid'  :
                        $array[$key] = cassandraTimeuuidToPhpValue($row);
                        break;
                    case 'Cassandra\Timestamp':
                        $array[$key] = cassandraTimestampToPhpValue($row);
                        break;
                    case 'Cassandra\Bigint':
                        $array[$key] = cassandraBigintToPhpValue($row);
                        break;
                }
            }
        }

        return $array;
    }

    function cassandraTimeuuidToPhpValue(Cassandra\Timeuuid $row)
    {
        return $row->uuid();
    }

    function cassandraTimestampToPhpValue(Cassandra\Timestamp $row)
    {
        $time = $row->time();
        return date('Y-m-d H:i:s', $time);
    }

    function cassandraBigintToPhpValue(Cassandra\Bigint $row)
    {
        return $row->value();
    }
}
