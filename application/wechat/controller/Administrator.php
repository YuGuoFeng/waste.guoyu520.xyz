<?php

namespace app\wechat\controller;

use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Config;
use think\Validate;

use fast\Myexception;
use think\Request;

use app\admin\model\UserApply as uam;

/**
 * 会员接口
 */
class Administrator extends Api
{
    protected $noNeedLogin = ['index'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

    }
    public function index(){
        return [];
    }
    /**
     * 申请成为管理员
     */
    public function applyUser(Request $request)
    {
        try{
            $p = [
                'the_name'        => ['the_name',null,true,'姓名'],
                'gender'          => ['gender',1,false,'性别[0:女 1:男]'],
                'mobile'          => ['mobile',null,true,'手机号'],
                'home_address'    => ['home_address',null,true,'家庭住址'],
                'management_area' => ['management_area',null,true,'管理区域地址'],
                'lng'             => ['lng',0,true,'经度'],
                'lat'             => ['lat',0,true,'纬度'],
                'state'           => ['state',0,false,'状态值:0=禁用,1=正常,2=推荐'],
            ];
            $data = $this->ParamArr($p,$request->param());
            $data['user_id'] = $this->auth->id;   
            
            $row = (new uam())->where('user_id',$data['user_id'])->find();
            if(!empty($row)){
                throw new Myexception('您已经申请过啦！');
            }
            uam::create($data);
            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

}
