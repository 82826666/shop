<?php

namespace app\api\model;

use app\common\model\User as UserModel;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use think\Cache;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class User extends UserModel
{
    private $token;

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'create_time',
        'update_time'
    ];

    /**
     * 获取用户信息
     * @param $token
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function getUser($token)
    {
        return self::detail(['open_id' => Cache::get($token)['openid']]);
    }

    /**
     * 用户登录
     * @param array $post
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($post)
    {
        // 微信登录 获取session_key
        $session = $this->wxlogin($post['code']);
        // 自动注册用户
        $userInfo = json_decode(htmlspecialchars_decode($post['user_info']), true);
        $user_id = $this->register($session['openid'], $userInfo);
        // 生成token (session3rd)
        $this->token = $this->token($session['openid']);
        // 记录缓存, 7天
        Cache::set($this->token, $session, 86400 * 7);
        return $user_id;
    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 微信登录
     * @param $code
     * @return array|mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function wxlogin($code)
    {
        // 获取当前小程序信息
        // 微信登录 (获取session_key)
        $app_id = 'wxd12d51249b517b9d';
        $app_secret = '830f8204a0b76c7e834f2747115abc68';
        $WxUser = new WxUser($app_id, $app_secret);
        if (!$session = $WxUser->sessionKey($code)) {
            throw new BaseException(['msg' => $WxUser->getError()]);
        }
        return $session;
    }

    /**
     * 生成用户认证的token
     * @param $openid
     * @return string
     */
    private function token($openid)
    {
        return md5($openid . 'token_salt'.rand(0,99).rand(0,99).rand(0,99).rand(0,9).rand(0,9));
    }

    /**
     * 自动注册用户
     * @param $open_id
     * @param $userInfo
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function register($open_id, $userInfo)
    {
        if (!$user = self::get(['open_id' => $open_id])) {
            $user = $this;
            $userInfo['open_id'] = $open_id;
        }
        $userInfo['nickName'] = preg_replace('/[\xf0-\xf7].{3}/', '', $userInfo['nickName']);
        if (!$user->allowField(true)->save($userInfo)) {
            throw new BaseException(['msg' => '用户注册失败']);
        }
        return $user['user_id'];
    }

}