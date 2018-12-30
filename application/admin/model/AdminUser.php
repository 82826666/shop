<?php

namespace app\admin\model;

use app\common\model\AdminUser as AdminUserModel;
use think\Session;

/**
 * 管理员用户模型
 * Class AdminUserModel
 * @package app\store\model
 */
class AdminUser extends AdminUserModel
{
    /**
     * 商家用户登录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        // 验证用户名密码是否正确
        if (!$user = self::useGlobalScope(false)->where([
            'user_name' => $data['user_name'],
            'password' => yoshop_hash($data['password'])
        ])->find()) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        // 保存登录状态
        Session::set('admin', [
            'user' => [
                'admin_user_id' => $user['admin_user_id'],
                'user_name' => $user['user_name'],
                'role_id' => $user['role_id']
            ],
            'is_login' => true,
        ]);
        return true;
    }
    /**
     * 商户信息
     * @param $admin_user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($admin_user_id)
    {
        return self::get($admin_user_id);
    }

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => yoshop_hash($data['password']),
            ]) === false) {
            return false;
        }




        // 验证用户名密码是否正确
        if (!$user = self::useGlobalScope(false)->where([
            'user_name' => $data['user_name'],
            'password' => yoshop_hash($data['password'])
        ])->find()) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        // 保存登录状态
        Session::set('admin', [
            'user' => [
                'admin_user_id' => $user['admin_user_id'],
                'user_name' => $user['user_name'],
                'role_id' => $user['role_id']
            ],
            'is_login' => true,
        ]);
        return true;
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList(){
        $model = new static;
        $data = $model->order(['admin_user_id' => 'desc'])->select();
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
        $data['password'] = yoshop_hash($data['password']);
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        if ($data['password']){
            $data['password'] = yoshop_hash($data['password']);
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
