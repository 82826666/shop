<?php

namespace app\admin\controller;

use app\admin\model\AdminUser;
use think\Session;

/**
 * 商户认证
 * Class Passport
 * @package app\store\controller
 */
class Passport extends Controller
{
    /**
     * 商户后台登录
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        if ($this->request->isAjax()) {
            $model = new AdminUser();
            if ($model->login($this->postData('Admin'))) {
                return $this->renderSuccess('登录成功', url('index/index'));
            }
            return $this->renderError($model->getError() ?: '登录失败');
        }
        $this->view->engine->layout(false);
        return $this->fetch('login');
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear('admin');
        $this->redirect('passport/login');
    }

}
