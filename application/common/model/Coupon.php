<?php
/**
 * Created by PhpStorm.
 * User: ROWIN
 * Date: 2018/7/22
 * Time: 14:31
 */

namespace app\common\model;


use think\Request;

class Coupon extends BaseModel
{
    protected $name = "coupon";

    protected $insert =['coupon_sn'];


    /**
     * 生成优惠码
     * @return string
     */
    protected function setCouponSnAttr(){
        return date('Ymd').mt_rand(100,999);
    }
    /**
     * 获取优惠卷列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($where=[])
    {
        $list = $this->where($where)->paginate(15, false, [
            'query' => Request::instance()->request()
        ]);
        return $list;
    }

    /**
     * 获取优惠卷详情
     * @param $id
     * @return Coupon|null
     * @throws \think\exception\DbException
     */
    public static function detail($id)
    {
        return self::get($id);
    }

}