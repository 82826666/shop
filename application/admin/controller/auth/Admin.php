<?php

namespace app\admin\controller\auth;
use app\admin\controller\Controller;
use app\admin\model\AdminUser as AdminModel;
use app\admin\model\Role as roleModel;
/**
 * 商品分类
 * Class Category
 * @package app\store\controller\goods
 */
class Admin extends Controller
{
    /**
     * 商品分类列表
     * @return mixed
     */
    public function index()
    {
        $model = new AdminModel;
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
        $model = AdminModel::get($id);
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
        $model = new AdminModel;
        if (!$this->request->isAjax()) {
            $model = new roleModel();
            $role = $model->getList();
            return $this->fetch('add',compact('role'));
        }
        // 新增记录
        if ($model->add($this->postData('admin'))) {
            return $this->renderSuccess('添加成功', url('auth.admin/index'));
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
        $model = AdminModel::get($id);
        if (!$this->request->isAjax()) {
            $roleModel = new roleModel();
            $role = $roleModel->getList();
            return $this->fetch('edit', compact('model','role'));
        }
        // 更新记录
        $res = $model->edit($this->postData('admin'));
        if ($res !== false) {
            return $this->renderSuccess('更新成功', url('auth.admin/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

}
