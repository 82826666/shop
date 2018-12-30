<?php

namespace app\admin\controller\auth;
use app\admin\controller\Controller;
use app\admin\model\Role as RoleModel;
use think\Config;

/**
 *
 * Class Category
 * @package app\store\controller\goods
 */
class Role extends Controller
{
    /**
     * 商品分类列表
     * @return mixed
     */
    public function index()
    {
        $model = new RoleModel;
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
        $model = RoleModel::get($id);
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
        $model = new RoleModel;
        if (!$this->request->isAjax()) {
            $limit = Config::get('limits');
            return $this->fetch('add',compact('limit'));
        }
        // 新增记录
        if ($model->add($this->postData('Role'))) {
            return $this->renderSuccess('添加成功', url('auth.role/index'));
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
        $model = RoleModel::get($id);
        if (!$this->request->isAjax()) {
            $limit = Config::get('limits');
            return $this->fetch('edit', compact('model','limit'));
        }
        // 更新记录
        if ($model->edit($this->postData('Role'))) {
            return $this->renderSuccess('更新成功', url('auth.role/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }
}
