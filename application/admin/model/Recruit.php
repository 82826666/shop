<?php

namespace app\admin\model;

use app\common\model\Recruit as RecruitModel;
use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\store\model
 */
class Recruit extends RecruitModel
{
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
    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        if (!empty($data['image'])) {
            $data['image_id'] = UploadFile::getFildIdByName($data['image']);
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
