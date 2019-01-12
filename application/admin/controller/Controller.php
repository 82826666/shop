<?php

namespace app\admin\controller;

use think\Config;
use think\Session;
use app\admin\model\Setting;
use app\admin\model\Role as roleModel;

/**
 * 后台控制器基类
 * Class BaseController
 * @package app\store\controller
 */
class Controller extends \think\Controller
{
    /* @var array $store 商家登录信息 */
    protected $admin;

    /* @var string $route 当前控制器名称 */
    protected $controller = '';

    /* @var string $route 当前方法名称 */
    protected $action = '';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';

    /* @var string $route 当前路由：分组名称 */
    protected $group = '';

    /* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'passport/login',
    ];

    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'passport/login',
    ];
    protected $auth = [];

    /**
     * 后台初始化
     */
    public function _initialize()
    {
        // 商家登录信息
        $this->admin = Session::get('admin');
        // 当前路由信息
        $this->getRouteinfo();
        // 验证登录
        $this->checkLogin();
        // 验证权限
        $this->checkAuth();
        // 全局layout
        $this->layout();
    }

    public function checkAuth(){
        $admin = $this->admin;
        $role_id = isset($admin['user']['role_id']) ? $admin['user']['role_id'] : 0;
        $role =  $model = roleModel::get($role_id);
        if($admin['user']['admin_user_id'] == 1){
            return true;
        }
        if($role['act']){
            $this->auth = unserialize($role['act']);
        }
        if(!in_array($this->routeUri, $this->allowAllAction) && !in_array($this->controller,$this->auth)){
            $this->redirect('passport/login');
            return false;
        }
    }

    /**
     * 全局layout模板输出
     */
    private function layout()
    {
        // 验证当前请求是否在白名单
        if (!in_array($this->routeUri, $this->notLayoutAction)) {
            // 输出到view
            $this->assign([
                'base_url' => base_url(),                      // 当前域名
                'store_url' => url('/admin'),              // 后台模块url
                'group' => $this->group,
                'menus' => $this->menus(),                     // 后台菜单
                'store' => $this->admin,                       // 商家登录信息
                'setting' => Setting::getAll() ?: null,        // 当前商城设置
            ]);
        }
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }

    /**
     * 后台菜单配置
     * @return array
     */
    private function menus()
    {
        $auth = $this->auth;
        $admin = $this->admin['user'];
//        $auth = array('index','setting','auth.role','goods','recruit','order','setting.delivery','setting.cache','setting.science','user','auth.admin','goods.category');
        foreach ($data = Config::get('menus') as $group => $first) {
            $data[$group]['active'] = $group === $this->group;

            // 遍历：二级菜单
            if (isset($first['submenu'])) {
                foreach ($first['submenu'] as $secondKey => $second) {
                    // 二级菜单所有uri
                    $secondUris = [];
                    if (isset($second['submenu'])) {
                        // 遍历：三级菜单
                        foreach ($second['submenu'] as $thirdKey => $third) {
                            if($admin['admin_user_id'] !=1 && !in_array(explode('/',$third['index'])[0],$auth)){
                                unset($data[$group]['submenu'][$secondKey]['submenu'][$thirdKey]);
                                continue;
                            }
                            $thirdUris = [];
                            if (isset($third['uris'])) {
                                $secondUris = array_merge($secondUris, $third['uris']);
                                $thirdUris = array_merge($thirdUris, $third['uris']);
                            } else {
                                $secondUris[] = $third['index'];
                                $thirdUris[] = $third['index'];
                            }
                            $data[$group]['submenu'][$secondKey]['submenu'][$thirdKey]['active'] = in_array($this->routeUri, $thirdUris);
                        }
                        if($admin['admin_user_id'] !=1 && !$data[$group]['submenu'][$secondKey]['submenu']){
                            unset($data[$group][$secondKey]);
                        }
                        foreach ($data[$group]['submenu'] as $k => $v){
                            if($admin['admin_user_id'] !=1 && !in_array(explode('/',$v['index'])[0],$auth)){
                                unset($data[$group]['submenu'][$k]);
                                continue;
                            }
                        }
                    } else {
                        if($admin['admin_user_id'] !=1 && !in_array(explode('/',$second['index'])[0],$auth)){
                            unset($data[$group]['submenu'][$secondKey]);
                            continue;
                        }
                        if (isset($second['uris']))
                            $secondUris = array_merge($secondUris, $second['uris']);
                        else
                            $secondUris[] = $second['index'];
                    }
                    // 二级菜单：active
                    if(isset($data[$group]['submenu'][$secondKey])){
                        !isset($data[$group]['submenu'][$secondKey]['active'])
                        && $data[$group]['submenu'][$secondKey]['active'] = in_array($this->routeUri, $secondUris);
                    }
                }
            }else{
                if($admin['admin_user_id'] !=1 && !in_array(explode('/',$first['index'])[0],$auth)){
                    unset($data[$group]);
                }
            }
        }
        foreach ($data as $k => $v){
            if(isset($v['submenu'])){
                if(!$v['submenu']){
                    unset($data[$k]);
                    continue;
                }else{
                    $submenu = $v['submenu'];
                    $data[$k]['index'] = $submenu[0]['index'];
                }
            }
        }
        return $data;
    }

    /**
     * 验证登录状态
     */
    private function checkLogin()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }
        // 验证登录状态
        if (empty($this->admin) || (int)$this->admin['is_login'] !== 1) {
			$this->redirect('passport/login');
            return false;
        }
        return true;
    }


    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }

}
