<?php

namespace app\admin\controller\admin;

use app\admin\controller\Controller;
use app\admin\model\AdminUser;

/**
 * 商户管理员控制器
 * Class StoreUser
 * @package app\store\controller
 */
class User extends Controller
{
    /**
     * 更新当前管理员信息
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function renew()
    {
        $model = AdminUser::detail($this->store['user']['admin_user_id']);
        if ($this->request->isAjax()) {
            if ($model->renew($this->postData('user'))) {
                return $this->renderSuccess('更新成功');
            }
            return $this->renderError($model->getError() ?: '更新失败');
        }
        return $this->fetch('renew', compact('model'));
    }
}
