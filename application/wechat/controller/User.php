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
/**
 * 会员接口
 */
class User extends Api
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

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    
    /**
     * 手机验证码登录
     */
    public function login(Request $request)
    {

        try{
            $p = [
                'nickname' => ['nickname',null,true,'微信昵称'],
                'username' => ['username',null,true,'微信手机号'],
                'avatar'   => ['avatar',null,true,'微信头像'],
            ];
            $data = $this->ParamArr($p,$request->param());

            $mobile = $data['username'];

            $user = \app\common\model\User::getByMobile($mobile);
            if ($user) {
                if ($user->status != 'normal') {
                    $this->error(__('Account is locked'));
                }
                //如果已经有账号则直接登录
                $ret = $this->auth->direct($user->id);
            } else {
                $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, ['nickname'=>$data['nickname'],'avatar'=>$data['avatar']]);
            }
            if ($ret) {
                $data = ['userinfo' => $this->auth->getUserinfo()];
                // $this->success(__('Logged in successful'), $data);
                return $this->json('ok',200,$data);
            } else {
                throw new Myexception($this->auth->getError());
            }
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }

    }

    

    /**
     * 退出登录
     * @ApiMethod (POST)
     */
    public function logout()
    {
        if (!$this->request->isPost()) {
            $this->error(__('Invalid parameters'));
        }
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    
    

    
}
