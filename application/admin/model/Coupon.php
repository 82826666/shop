<?php
/**
 * Created by PhpStorm.
 * User: ROWIN
 * Date: 2018/7/22
 * Time: 14:30
 */

namespace app\admin\model;


use app\common\model\Coupon as CouponModel;
use think\Db;

class Coupon extends CouponModel
{
    /**
     * 添加优惠卷
     * @param array $data
     * @return bool
     */
    public function add(array $data)
    {

        // 开启事务
        Db::startTrans();
        try {
            // 添加优惠卷
            $this->allowField(true)->save($data);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
        }
        return false;
    }
    /**
     * 编辑优惠卷
     * @param $data
     * @return bool
     */
    public function edit($data)
    {

        // 开启事务
        Db::startTrans();
        try {
            // 保存优惠卷
            $this->allowField(true)->save($data);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
        }
        return false;
    }
    /**
     * 删除优惠卷
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        Db::startTrans();
        $this->delete();
        Db::commit();
        return true;
    }

}