<?php

namespace app\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use EasyWeChat\Factory;
use app\wechat\model\UserAddress as uam;
class AddressServices
{  
    
    public function editStatus($uid){
        // $row = (new uam)->where('user_id',$uid)->find();
        (new uam)->where('user_id',$uid)->update(['status'=>1]);
        /* if($row){
            
        } */
    }
}
?>