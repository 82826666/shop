<?php

namespace app\admin\model;

use app\common\model\Role as roleModel;
use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\store\model
 */
class Role extends roleModel
{
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
    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        if (!empty($data['act'])) {
            $data['act'] = serialize($data['act']);
        }
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        if (!empty($data['act'])) {
            $data['act'] = serialize($data['act']);
        }
        return $this->allowField(true)->save($data);
    }

    /**
     * 删除商品分类
     * @param $id
     * @return bool|int
     */
    public function remove($id)
    {
        return $this->delete();
    }
}
