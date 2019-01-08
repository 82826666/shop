<?php
/**
 * Created by PhpStorm.
 * User: ROWIN
 * Date: 2018/7/22
 * Time: 18:33
 */

namespace app\api\controller;

use app\api\model\Coupon as CouPonModel;
use app\api\model\CouponUser as CouponUerModel;
use app\api\model\CouponUser;

class Coupon extends Controller
{
    //优惠卷状态
    const COUPON_STATUS_NONE_USER = 1;//未使用
    const COUPON_STATUS__USER = 2;//已使用
    const COUPON_STATUS__OVERDUE = 3;//过期

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->user = $this->getUser();   // 用户信息
    }

    /**
     * 我的优惠卷列表
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function myLists()
    {
        $couponUserModel = new  CouponUser();
        $list = $couponUserModel->getCouponList($this->user->user_id);
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 领劵中心
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $model = new CouPonModel();
        $couponUserModel = new CouponUerModel();
        //筛选状态开启
        $where = array(
            'status' => 1,
            'is_delete' => 0
        );
        $couponList = $model->getLists($where);
        $user_id = $this->user->user_id;
        foreach ($couponList as $key => &$value) {
            //没有库存  将进度设为100%
            if ($value['total_number'] == $value['get_number']) {
                $value['percept'] = 100;
                continue;
            }
            //获取该用户的优惠卷状态  可用模型更改
            $info = $couponUserModel->checkCoupon($value['id'], $user_id);
            if (empty($info)) {
                $value['coupon_status'] = 0;
            } else {
                $value['coupon_status'] = $info['coupon_status'];
            }
            //如果为不限数量的优惠卷 则不用获取优惠卷领取数量
            if (!($value['total_number'] == -1)) {
                $value['percept'] = round($value['get_number'] / floatval($value['total_number']) * 100, 2);
            }

        }
        return $this->renderSuccess(compact('couponList'));
    }

    /**
     * 获取优惠卷
     * @param $coupon_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function getCoupon($coupon_id)
    {
        $model = new CouPonModel();
        //增加优惠卷领取数量
        if (!$model->incGetNumber($coupon_id)) {
            return $this->renderError('已无库存');
        }
        $couponUserModel = new CouponUerModel();
        $data['coupon_status'] = self::COUPON_STATUS_NONE_USER;
        //获得优惠卷
        $couponUserModel->add($this->user->user_id, $coupon_id, $data);
        return $this->renderSuccess([], '获取成功');
    }

    /**
     * 领取优惠卷  通过order_sn优惠码
     * @param $coupon_sn
     * @return array
     * @throws \think\exception\DbException
     */
    public function exchangeCoupon($coupon_sn)
    {
        $model = new CouPonModel();
        $info = $model->getDetail(['coupon_sn' => $coupon_sn]);
        if (empty($info)) {
            return $this->renderError('没有此优惠券！');
        }
        $couponUserModel = new CouponUerModel();
        $data['coupon_status'] = self::COUPON_STATUS_NONE_USER;//设置优惠卷状态为未领取  ....其实可以不用 将数据库字段设置默认值 但是我就是有脾气
        $info = $couponUserModel->add($this->user->user_id, $info['id'], $data);
        if (!$info) {
            return $this->renderError('你已经领取了该优惠卷');
        }
        return $this->renderSuccess([], '获取成功');
    }
}