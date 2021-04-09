<?php

namespace backend\helpers;

class ActivityType
{
    private static $data = [
        '1' => 'รับเข้าผลิต',
        '2' => 'เบิกขึ้นรถ',
        '3' => 'เบิกเติม',
        '4' => 'คืนขายหน่วยรถ',
        '5' => 'เบิกขาย POS',
        '6' => 'ปรับยอด',
        '7' => 'โอนระหว่างสาขา'
    ];

    private static $dataobj = [
        ['id' => '1', 'name' => 'รับเข้าผลิต'],
        ['id' => '2', 'name' => 'เบิกขึ้นรถ'],
        ['id' => '3', 'name' => 'เบิกเติม'],
        ['id' => '4', 'name' => 'คืนขายหน่วยรถ'],
        ['id' => '5', 'name' => 'เบิกขาย POS'],
        ['id' => '6', 'name' => 'ปรับยอด'],
        ['id' => '7', 'name' => 'โอนระหว่างสาขา']
    ];

    public static function asArray()
    {
        return self::$data;
    }

    public static function asArrayObject()
    {
        return self::$dataobj;
    }

    public static function getTypeById($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }

    public static function getTypeByName($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
}
