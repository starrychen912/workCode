<?php

namespace app\admin\model\area;

use think\Model;


class Continent extends Model
{

    

    

    // 表名
    protected $name = 'continent';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'adddate_text'
    ];
    

    



    public function getAdddateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['adddate']) ? $data['adddate'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAdddateAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
