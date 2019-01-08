<?php

namespace app\admin\controller\coupon;
use app\admin\controller\Controller;
use app\admin\model\Coupon as CouponModel;


/**
 * 优惠卷管理控制器
 * @package app\admin\controller
 */
class Coupon extends Controller
{
    /**
     * 优惠卷列表
     * @return mixed
     */
    public function index()
    {
        $model = new CouponModel;
        $where=array(
            'is_delete'=>0
        );
        $list = $model->getList($where);
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加优惠卷
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function add()
    {

        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        $model = new CouponModel();
        if ($model->add($this->postData('coupon'))) {
            return $this->renderSuccess('添加成功', url('coupon.coupon/index'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }

    /**
     * 删除优惠卷
     * @param $id
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function delete($id)
    {
        $model = CouponModel::get($id);
        $model->is_delete=1;
        if (!$model->save()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 优惠卷编辑
     * @param $id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($id)
    {
        // 商品详情
        $model = CouponModel::detail($id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        if ($model->edit($this->postData('coupon'))) {
            return $this->renderSuccess('更新成功', url('coupon.coupon/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

}
