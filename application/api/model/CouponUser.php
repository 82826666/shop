<?php
/**
 * Created by PhpStorm.
 * User: ROWIN
 * Date: 2018/7/22
 * Time: 19:43
 */

namespace app\api\model;

use app\common\model\CouponUser as CouponUserModel;
use think\Db;

class CouponUser extends CouponUserModel
{
    /**
     * 改变优惠卷使用状态
     * @param $coupon_user_id
     * @param $coupon_status
     * @return false|int
     */
    public static function changeCouponUserStatus($coupon_user_id, $coupon_status)
    {
        $model = self::get($coupon_user_id);
        $model->coupon_status = $coupon_status;

        return $model->save();
    }

    /**
     * 获取该用户所有类型的优惠卷
     * @param $user_id
     * @param $wxapp_id
     * @return CouponUser[]|false
     * @throws \think\exception\DbException
     */
    public function getMyCoupon($user_id)
    {
        $where = array(
            'user_id' => $user_id,
        );
        $list = CouponUser::order('id','desc')->where($where)->select();
        return $list;
    }

    /**
     * 获取已领取的优惠卷详情
     * @param $where
     * @return CouponUser|null
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        $info = self::get($where);
        return $info;
    }

    /**
     * 获取我的优惠卷
     * @param $user_id
     * @param $wxapp_id
     * @param $coupon_status
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCouponList($user_id)
    {
        $couponList = [];
        $usedcouponList = [];
        $unablecouponList = [];
        $where = array(
            'user_id' => $user_id,
        );
        $list = CouponUser::all($where)->toArray();
        foreach ($list as $key => &$value) {
            $coupon = Coupon::get($value['coupon_id'])->toArray();
            if ($value['coupon_status'] == 1 && !self::checkIsExpire($coupon, $value['create_time'])) {
                $coupon['min_price'] = round(floatval($coupon['min_price']), 2);
                $value = array_merge($value, $coupon);
                $couponList[] = $value;
            } else if ($value['coupon_status'] == 1 && self::checkIsExpire($coupon, $value['create_time'])) {
                $coupon['min_price'] = round(floatval($coupon['min_price']), 2);
                $value = array_merge($value, $coupon);
                $unablecouponList[] = $value;
            } else if ($value['coupon_status'] == 2) {
                $coupon['min_price'] = round(floatval($coupon['min_price']), 2);
                $value = array_merge($value, $coupon);
                $usedcouponList[] = $value;
            }
        }
        $list = compact('couponList', 'usedcouponList', 'unablecouponList');
        return $list;
    }

    /**
     * 用户获取优惠卷
     * @param $user_id
     * @param $coupon_id
     * @param $coupon
     * @return bool
     */
    public function add($user_id, $coupon_id, $data)
    {
        $info = self::checkCoupon($coupon_id, $user_id);
        //用户已经领取改优惠卷
        if ($info) {
            return false;
        }
        Db::startTrans();
        $coupon = Coupon::get($coupon_id);
        // 保存优惠卷
        $this->save([
            'user_id' => $user_id,
            'coupon_id' => $coupon_id,
            'sub_price' => $coupon['sub_price'],
            'expire_day' => $coupon['expire_day'],
            'coupon_name' => $coupon['coupon_name'],
            'min_price' => $coupon['min_price'],
            'wxapp_id' => self::$wxapp_id,
            'coupon_status' => $data['coupon_status']
        ]);
        Db::commit();
        return true;
    }

    /**
     * 检查优惠卷是否领取
     * @param $coupon_id
     * @param $user_id
     * @return CouponUser|null
     * @throws \think\exception\DbException
     */
    public function checkCoupon($coupon_id, $user_id)
    {
        $where = array(
            'coupon_id' => $coupon_id,
            'user_id' => $user_id
        );
        $info = CouponUser::get($where);
        return $info;
    }

    /**
     * 检验是否过期
     * @param $coupon
     * @param $getCouponTime
     * @return bool
     */
    public function checkIsExpire($coupon, $getCouponTime)
    {
        $now = time();
        $oneDayTime = 86400;
        $getCouponTime = strtotime($getCouponTime);
        $expireTime = $coupon['expire_day'] * $oneDayTime;
//        var_dump($expireTime);
//        echo $now.'|',$getCouponTime.'|',$expireTime.'|';
//        die();
        //超过有效期 过期
        if (($now - $getCouponTime) > $expireTime) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 获取优惠卷数量
     * @param $coupon_id
     * @return int|string
     */
    public function getCouponNumber($coupon_id)
    {
        $where = array(
            'coupon_id' => $coupon_id,
        );
        $info = CouponUser::where($where)->count();
        return $info;
    }
}