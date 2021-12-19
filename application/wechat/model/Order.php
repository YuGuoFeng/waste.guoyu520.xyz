<?php

namespace app\wechat\model;

use think\Model;

class Order extends Model
{

    // 表名
    protected $name = 'order';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    ];

    protected $type = [
        'createtime' => 'timestamp:Y-m-d H:i:s',
    ];

    // 生成订单号
    public static function getNewOrderId()
    {
        $count = (int) self::where('createtime',['>=',strtotime(date("Y-m-d"))],['<',strtotime(date("Y-m-d",strtotime('+1 day')))])->count();
        return date('YmdHis',time()).(10000+$count+1);
    }

}
