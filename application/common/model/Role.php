<?php

namespace app\common\model;

use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\common\model
 */
class Role extends BaseModel
{
    protected $name = 'role';

    /**
     * 获取列表
     * @return array
     */
    public function getList(){
        $model = new static;
        $data = $model->order(['id' => 'desc'])->select();
        $all = !empty($data) ? $data->toArray() : [];
        return $all;
    }
}
