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

// use app\admin\model\UserApply as uam;
use app\wechat\model\UserAddress as wuam;
use app\wechat\model\Goods as gm;
use app\wechat\model\Order as om;

use app\Services\OrderServices as oss;
class Order extends Api
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
    // 获取回收站点信息
    public function recyclingSite(Request $request,$address_id){
        try{
            $user_id = $this->auth->id;
            // 用户地址信息
            $address = (new wuam)->where(['user_id'=>$user_id,'id'=>$address_id])
            ->field('id,lng,lat')->find();

            $data = (new oss)->getRecyclingSite($address);

            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,$e);
        }
    }

    public function save(Request $request){
        try{
            $p = [
                'address_id'         => ['address_id',null,true,'用户地址id'],
                'the_door_time'      => ['the_door_time',null,true,'上门时间'],
                'goods_josn'         => ['goods_josn',null,true,'物品信息'],
                'goods_images'       => ['goods_images',null,true,'物品图片'],
                'administrator_id'   => ['administrator_id',null,true,'管理员id'],
                'administrator_name' => ['administrator_name',null,true,'管理员名称'],
                'administrator_tel'  => ['administrator_tel',null,true,'管理员联系方式'],
            ];
            $data = $this->ParamArr($p,$request->param());
            $data['user_id'] = $this->auth->id;   

            $data['goods_josn'] = html_entity_decode($data['goods_josn']);

            /* $goods = [
                ['name'=>'物品名称','price'=>'单价','unit'=>'单位','weight'=>'重量','amount'=>'金额'],
            ];
            $json = json_encode($goods,256);
            dump($json);exit(); */

            // 查询用户地址信息
            $address = (new wuam)->where(['user_id'=>$data['user_id'],'id'=>$data['address_id']])
            ->field('*')->find();
            if(empty($address)){
                throw new Myexception('用户地址信息错误');
            }
            $data['order_id']     = om::getNewOrderId();
            $data['user_name']    = $address['name']??'';
            $data['user_tel']     = $address['phone']??'';
            $data['user_address'] = $address['province']??''.$address['city']??''.$address['area']??''.$address['address']??'';
            unset($data['address_id']);
            om::create($data);
            return $this->json('ok',200,$data);
        }catch(Myexception $e){
            return $this->json($e->getMsg(),400,$e);
        }catch(\Exception $e){
            return $this->json($e->getMessage(),400,['getFile'=>$e->getFile(),'getLine'=>$e->getLine()]);
        }
    }

    /* ---------------------------------------- */

    /* public function index(Request $request){
        try{
            $user_id = $this->auth->id;
            $size = $request->get('size')??10;
            $page = $request->get('page')??10;
            $data = (new gm)->where('user_id',$user_id)->order('id','desc')->page($page,$size)->select();
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
            $info = (new gm)->where('user_id',$user_id)->where('id',$id)->find();

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
                'name'     => ['name',null,true,'物品名称'],
                'price'    => ['price',0.00,true,'价格'],
                'unit'     => ['unit',null,true,'单位'],
            ];
            $data = $this->ParamArr($p,$request->param());
            $data['user_id'] = $this->auth->id;   
            $row = (new gm)->where('user_id',$data['user_id'])->where('name',$data['name'])->find();
            if(!empty($row)){
                throw new Myexception('该物品已经存在！');
            }
            gm::create($data);
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
                'name'     => ['name',null,true,'物品名称'],
                'price'    => ['price',0.00,true,'价格'],
                'unit'     => ['unit',null,true,'单位'],
            ];
            $data = $this->ParamArr($p,$request->param());
            // $data['user_id'] = $this->auth->id;   
         
            $user_id = $this->auth->id;

            (new gm)->where('user_id',$user_id)->where('id',$id)->update($data);
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
            $info = (new gm)->where('user_id',$user_id)->where('id',$id)->find();

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
    } */


    

}
