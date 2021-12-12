<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::group('v1',function(){

    Route::post('upload','api/common/upload');
    
    // 登陆
    Route::post('login','wechat/user/login');
    // 申请成为管理员
    Route::post('administrator/applyUser','wechat/administrator/applyUser');
    // 地址管理
    Route::resource('address','wechat/Address');

    // 根据用户地址返回站点信息
    Route::get('order/recyclingSite/:address_id','wechat/order/recyclingSite');
    // 提交订单
    Route::post('order/save','wechat/order/save');

    // 管理员
    // 物品管理
    Route::resource('goods','wechat/goods');
});
