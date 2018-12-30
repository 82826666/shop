<?php

namespace app\api\controller;

use app\api\model\Recruit as RecruitModel;

/**
 * 用户管理
 * Class User
 * @package app\api
 */
class Recruit extends Controller
{
    /**
     * 获取招聘列表
     * @return array
     */
    public function getList(){
        $model = new RecruitModel;
        $list = $model->getList();
        return $this->renderSuccess(compact('list'));
    }

}
