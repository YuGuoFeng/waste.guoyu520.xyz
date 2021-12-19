<?php

namespace app\admin\model;

use think\Model;


class OrderModel extends Model
{

    

    

    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'the_door_time_text',
        'accepttime_text',
        'canceltime_text',
        'completetime_text'
    ];
    

    



    public function getTheDoorTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['the_door_time']) ? $data['the_door_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getAccepttimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['accepttime']) ? $data['accepttime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCanceltimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['canceltime']) ? $data['canceltime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCompletetimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['completetime']) ? $data['completetime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setTheDoorTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setAccepttimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCanceltimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCompletetimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
