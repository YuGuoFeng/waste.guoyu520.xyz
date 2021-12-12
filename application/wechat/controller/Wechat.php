<?php

namespace app\wechat\controller;

use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Config;
use think\Validate;
use think\Request;
use fast\Myexception;

use app\Services\WechatServices as ws;

/**
 * 会员接口
 */
class Wechat extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

    }

    // 获取小程序openid
    public function getWeiOpenId(Request $request){
        try{
            $code = $request->get('code');
            if($code == null){
                throw new Myexception('缺少code 值');
            }
            $data = (new ws)->getWeiOpenId($code);
            return $this->json('ok',200,$data);
            // return r::rMsgData(200,'ok',$data); 
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

    // 获取微信手机号
    public function getTel(Request $request){

        try{
            $session = $request->session;
            $iv = $request->iv;
            $encryptedData = $request->encryptedData;


            if($session == null){
                throw new Myexception('缺少code 值');
            }
            $data = (new ws)->decryptData($session, $iv, $encryptedData);

            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }
}
