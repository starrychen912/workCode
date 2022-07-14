<?php

namespace app\admin\model\customer;

use think\Model;


class Customer extends Model
{

    

    

    // 表名
    protected $name = 'customer';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'accepts_marketing_text',
        'state_text',
        'marketing_opt_in_level_text',
        'tax_exempt_text',
        'create_time_text',
        'update_time_text',
        'delete_time_text'
    ];
    

    
    public function getAcceptsMarketingList()
    {
        return ['0' => __('Accepts_marketing 0'), '1' => __('Accepts_marketing 1')];
    }

    public function getStateList()
    {
        return ['0' => __('State 0'), '1' => __('State 1'), '2' => __('State 2'), '3' => __('State 3')];
    }

    public function getMarketingOptInLevelList()
    {
        return ['0' => __('Marketing_opt_in_level 0'), '1
' => __('Marketing_opt_in_level 1
'), '2' => __('Marketing_opt_in_level 2'), '3' => __('Marketing_opt_in_level 3')];
    }

    public function getTaxExemptList()
    {
        return ['0' => __('Tax_exempt 0'), '1' => __('Tax_exempt 1')];
    }


    public function getAcceptsMarketingTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['accepts_marketing']) ? $data['accepts_marketing'] : '');
        $list = $this->getAcceptsMarketingList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getMarketingOptInLevelTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['marketing_opt_in_level']) ? $data['marketing_opt_in_level'] : '');
        $list = $this->getMarketingOptInLevelList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTaxExemptTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['tax_exempt']) ? $data['tax_exempt'] : '');
        $list = $this->getTaxExemptList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUpdateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['update_time']) ? $data['update_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getDeleteTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['delete_time']) ? $data['delete_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setDeleteTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
