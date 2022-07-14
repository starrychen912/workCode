<?php

namespace app\admin\model\order;

use think\Model;


class Order extends Model
{

    

    

    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'buyer_accepts_marketing_text',
        'estimated_taxes_text',
        'financial_status_text',
        'taxes_included_text',
        'test_text',
        'create_time_text',
        'update_time_text',
        'delete_time_text'
    ];
    

    
    public function getBuyerAcceptsMarketingList()
    {
        return ['0' => __('Buyer_accepts_marketing 0'), '1' => __('Buyer_accepts_marketing 1')];
    }

    public function getEstimatedTaxesList()
    {
        return ['0' => __('Estimated_taxes 0'), '1' => __('Estimated_taxes 1')];
    }

    public function getFinancialStatusList()
    {
        return ['0' => __('Financial_status 0'), '1' => __('Financial_status 1'), '2' => __('Financial_status 2'), '3' => __('Financial_status 3'), '4' => __('Financial_status 4'), '5' => __('Financial_status 5'), '6' => __('Financial_status 6')];
    }

    public function getTaxesIncludedList()
    {
        return ['0' => __('Taxes_included 0'), '1' => __('Taxes_included 1')];
    }

    public function getTestList()
    {
        return ['0' => __('Test 0'), '1' => __('Test 1')];
    }


    public function getBuyerAcceptsMarketingTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['buyer_accepts_marketing']) ? $data['buyer_accepts_marketing'] : '');
        $list = $this->getBuyerAcceptsMarketingList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getEstimatedTaxesTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['estimated_taxes']) ? $data['estimated_taxes'] : '');
        $list = $this->getEstimatedTaxesList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getFinancialStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['financial_status']) ? $data['financial_status'] : '');
        $list = $this->getFinancialStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTaxesIncludedTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['taxes_included']) ? $data['taxes_included'] : '');
        $list = $this->getTaxesIncludedList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTestTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['test']) ? $data['test'] : '');
        $list = $this->getTestList();
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
