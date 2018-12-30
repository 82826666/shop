<?php

namespace app\admin\model;

use app\common\model\Setting as SettingModel;
use think\Cache;

/**
 * 系统设置模型
 * @package app\store\model
 */
class Setting extends SettingModel
{
    /**
     * 设置项描述
     * @var array
     */
    private $describe = [
        'sms' => '短信通知',
        'storage' => '上传设置',
        'store' => '商城设置',
        'trade' => '交易设置',
        'small' => '小程序设置',
        'small_pay' => '小程序支付设置',
        'wechat' => '公众号设置',
        'wechat_pay' => '公众号支付设置'
    ];

    /**
     * 更新系统设置
     * @param $key
     * @param $values
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($key, $values)
    {
        $model = self::detail($key) ?: $this;
        // 删除系统设置缓存
        Cache::rm('setting');
        return $model->save([
            'key' => $key,
            'describe' => $this->describe[$key],
            'values' => $values,
        ]) !== false;
    }

}
