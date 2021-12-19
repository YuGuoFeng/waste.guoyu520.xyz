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
    // 获取小程序openid
    Route::get('getWeiOpenId','wechat/Wechat/getWeiOpenId');
    // 获取微信手机号
    Route::post('getTel','wechat/Wechat/getTel');


    
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
    // 订单列表
    Route::get('order/list','wechat/order/list');
    // 订单详情
    Route::get('order/info/:id','wechat/order/info');
    // 订单状态更新
    Route::get('order/editStatus/:id','wechat/order/editStatus');
    



    // 管理员
    // 物品管理
    Route::resource('goods','wechat/goods');
});
