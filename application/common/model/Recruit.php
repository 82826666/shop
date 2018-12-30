<?php

namespace app\common\model;

use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\common\model
 */
class Recruit extends BaseModel
{
    protected $name = 'recruit';

    /**
     * 招聘图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'image_id');
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList(){
        $model = new static;
        $data = $model->with(['image'])->order(['sort' => 'asc'])->select();
        $all = !empty($data) ? $data->toArray() : [];
        return $all;
    }
}
