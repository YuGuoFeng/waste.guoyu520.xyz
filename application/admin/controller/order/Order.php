<?php

namespace app\admin\controller\order;

use app\common\controller\Backend;

/**
 * 订单信息
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    
    /**
     * OrderModel模型对象
     * @var \app\admin\model\OrderModel
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\OrderModel;

    }

    public function import()
    {
        parent::import();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
    public function detail($ids){
        $row = $this->model->get(['id' => $ids]);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($this->request->isAjax()) {
            $this->success("Ajax请求成功", null, ['id' => $ids]);
        }

        $info = $row->toArray();
        $info['goods_arr'] = json_decode($info['goods_josn'],true);
        $info['goods_images_arr'] = explode(',',$info['goods_images']);
        $this->view->assign("row", $info);
        return $this->view->fetch();
    }
}
