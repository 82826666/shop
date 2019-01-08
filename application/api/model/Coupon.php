<?php
/**
 * Created by PhpStorm.
 * User: ROWIN
 * Date: 2018/7/22
 * Time: 18:36
 */

namespace app\api\model;

use app\common\model\Coupon as CouponModel;
use think\Db;
use think\Request;

class Coupon extends CouponModel
{
    /**
     * 获取优惠卷详情
     * @param $where
     * @return Coupon|null
     * @throws \think\exception\DbException
     */
    public function getDetail($where)
    {
        $info = Coupon::get($where);
        return $info;
    }

    /**
     * 获取优惠卷列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getLists($where)
    {

        $list = $this->order('id', 'desc')->where($where)->paginate(15, false, [
            'query' => Request::instance()->request()
        ]);
        return $list;
    }

    /**
     * 增加优惠卷领取数量
     * @param $coupon_id
     * @return bool
     * @throws \think\exception\DbException
     */
    public function incGetNumber($coupon_id)
    {
        $coupon = self::get($coupon_id);
        //该优惠卷为不限数量
        if ($coupon->total_number == -1) {
            return true;
        }
        //没有库存了
        if ($coupon->total_number == $coupon->get_number) {
            return false;
        }
        //增加优惠卷领取数量
        Db::startTrans();
        try {
            $this->where('id', $coupon_id)->setInc('get_number');
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }
        return true;
    }

    /**
     *  检查优惠卷是否能用 金额是否超出
     * @param $coupon_id
     * @param $total_price
     * @return bool
     * @throws \think\exception\DbException
     */
    public static function canUseCoupon($coupon_id, $total_price)
    {
        $coupon = self::get($coupon_id);
        //对比金额是否超出
        if ($coupon['min_price'] <= $total_price) {
            return true;
        }
        return false;
    }

}