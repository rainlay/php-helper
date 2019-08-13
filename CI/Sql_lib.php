<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sql_lib
{

    private $CI;

    /**
     * sql_lib constructor.
     */
    public function __construct()
    {
        $this->CI = & get_instance();
    }

    /**
     * TODO: 陣列格式檢查
     *
     * @param $tableName
     * @param $insertData
     * @param $noEscapeString
     * @return string
     */
    public function batchInsertQuery($tableName, $insertData, $noEscapeString = [])
    {
        $str = 'INSERT INTO ' . $tableName . ' ';
        $colStr = '(' . implode(',',array_keys($insertData[0])) . ')';

        $insertValues = [];
        foreach ($insertData as $row_key=> $row) {
            foreach ($row as $key => $value) {
                if (in_array($key,$noEscapeString)) {
                    $insertValues[$row_key][$key] = $value;
                } else {
                    $insertValues[$row_key][$key] = $this->CI->db->escape($value);
                }
            }
        }

        foreach($insertValues as $row)
        {
            $insertString[] =  ("(" . implode(",",$row) . ")");
        }

//        echo $str . $colStr . " Values " . implode(",",$insertString);
        return $str . $colStr . " Values " . implode(",",$insertString);
    }

    public function batchDeleteQuery($tableName, $where)
    {
//        $noEscapeString = ['updated_at'];

        $str = 'DELETE FROM ' . $tableName . ' WHERE ';

        $whereValues = [];

        $whereKeys = '(' .  implode(',',array_keys($where[0])) . ')';
//        echo $whereKeys;
        foreach ($where as $rowKey => $rowValue) {

            foreach($rowValue as $value_key => $value) {
                $where[$rowKey][$value_key] = $this->CI->db->escape($value);
            }

            array_push($whereValues,'(' . implode(',', $where[$rowKey]) . ')');
        }

        return $str . $whereKeys . " IN " . '(' . implode(',', $whereValues) . ')';

    }

    /**
     * 取得多筆新增的 id
     * @return array
     */ 
    public function getBatchInsertIds()
    {
        // 取得第一筆 insert id
        $first_id = $this->CI->db->insert_id();

        // 取得總共新增了幾筆資料
        $insert_nums = $this->CI->db->affected_rows();

        // 計算最後一筆 insert id
        $last_id = $first_id + $insert_nums - 1;

        // 填充所有 id
        $ids = [];
        for ($i=$first_id; $i<=$last_id; $i++) {
            $ids[] = $i;
        }

        return $ids;
    }

    /**
     * 把 insert id append 到 data 上
     * @return array data
     */ 
    public function appendDataInsertIds($data)
    {
        // 取得 insert ids
        $ids = $this->getBatchInsertIds();
        
        // 把 id 加回 data
        foreach ($data as $i => $row) {
            $data[$i]['id'] = $ids[$i];
        }
        return $data;
    }
}