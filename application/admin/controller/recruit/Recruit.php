<?php

namespace app\admin\controller\recruit;
use app\admin\controller\Controller;
use app\admin\model\Recruit as RecruitModel;

/**
 * 商品分类
 * Class Category
 * @package app\store\controller\goods
 */
class Recruit extends Controller
{
    /**
     * 商品分类列表
     * @return mixed
     */
    public function index()
    {
        $model = new RecruitModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 删除商品分类
     * @param $id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($id)
    {
        $model = RecruitModel::get($id);
        if (!$model->remove($id)) {
            $error = $model->getError() ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 添加商品分类
     * @return array|mixed
     */
    public function add()
    {
        $model = new RecruitModel;
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        if ($model->add($this->postData('recruit'))) {
            return $this->renderSuccess('添加成功', url('recruit/index'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }

    /**
     * 编辑配送模板
     * @param $category_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($id)
    {
        // 模板详情
        $model = RecruitModel::get($id, ['image']);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('recruit'))) {
            return $this->renderSuccess('更新成功', url('recruit/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }
}
