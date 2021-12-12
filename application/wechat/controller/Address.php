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
use app\wechat\model\UserAddress as wuam;

use app\Services\AddressServices as ass;
class Address extends Api
{
    protected $noNeedLogin = [''];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

    }
    public function index(Request $request){
        try{
            $user_id = $this->auth->id;
            $size = $request->get('size')??10;
            $page = $request->get('page')??10;
            $data = (new wuam)->where('user_id',$user_id)->order('id','desc')->page($page,$size)->select();
            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

    public function read($id){
        try{
            $user_id = $this->auth->id;
            $info = (new wuam)->where('user_id',$user_id)->where('id',$id)->find();

            if(empty($info)){
                throw new Myexception('数据不存在！');
            }

            return $this->json('ok',200,$info);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

    public function save(Request $request){
        try{
            $p = [
                'name'     => ['name',null,true,'姓名'],
                'phone'    => ['phone',null,true,'联系方式'],
                'province' => ['province',null,true,'省份'],
                'city'     => ['city',null,true,'市'],
                'area'     => ['area',null,true,'区'],
                'address'  => ['address',null,true,'详细地址'],
                'lng'      => ['lng',0,true,'经度'],
                'lat'      => ['lat',0,true,'纬度'],
                'status'   => ['status',0,false,'状态[0:否,1:默认]'],
            ];
            $data = $this->ParamArr($p,$request->param());
            $data['user_id'] = $this->auth->id;   
            if($data['status'] == 1){
                (new ass)->editStatus($data['user_id']);
            }
            wuam::create($data);
            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

    public function update(Request $request,$id){
        try{
            $p = [
                'name'     => ['name',null,true,'姓名'],
                'phone'    => ['phone',null,true,'联系方式'],
                'province' => ['province',null,true,'省份'],
                'city'     => ['city',null,true,'市'],
                'area'     => ['area',null,true,'区'],
                'address'  => ['address',null,true,'详细地址'],
                'lng'      => ['lng',0,true,'经度'],
                'lat'      => ['lat',0,true,'纬度'],
                'status'   => ['status',0,false,'状态[0:否,1:默认]'],
            ];
            $data = $this->ParamArr($p,$request->param());
            // $data['user_id'] = $this->auth->id;   
            if($data['status'] == 1){
                (new ass)->editStatus($data['user_id']);
            }

            $user_id = $this->auth->id;

            (new wuam)->where('user_id',$user_id)->where('id',$id)->update($data);
            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

    public function delete($id){
        try{
            $user_id = $this->auth->id;
            $info = (new wuam)->where('user_id',$user_id)->where('id',$id)->find();

            if(empty($info)){
                throw new Myexception('数据不存在！');
            }
            $info->delete();
            return $this->json('ok',200,[]);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }


    

}
