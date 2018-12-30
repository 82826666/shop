<?php
/**
 * @author wujianyang <891873508@qq.com>
 * Created by PhpStorm.
 * User: wujianyang
 * Date: 2018/12/9
 * Time: 2:29 PM
 */
$_limit =  array(
    array('name'=>'首页', 'child'=>array(
        array('name'=>'首页', 'op'=>null, 'act'=>'index'),
    )),
    array('name'=>'商品管理', 'child'=>array(
        array('name'=>'商品列表', 'op'=>null, 'act'=>'goods.goods'),
        array('name'=>'商品详情图片上传', 'op'=>null, 'act'=>'upload'),
        array('name'=>'商品规格', 'op'=>null, 'act'=>'goods.spec'),
        array('name'=>'商品分类', 'op'=>null, 'act'=>'goods.category'),
        array('name'=>'商品分类图片上传', 'op'=>null, 'act'=>'upload.library'),
    )),
    array('name'=>'招聘管理', 'child'=>array(
        array('name'=>'招聘列表', 'op'=>null, 'act'=>'recruit.recruit'),
    )),
    array('name'=>'订单管理', 'child'=>array(
        array('name'=>'订单管理', 'op'=>null, 'act'=>'order.order')
    )),
    array('name'=>'用户管理', 'child'=>array(
        array('name'=>'用户管理', 'op'=>null, 'act'=>'user.user'),
    )),
    array('name'=>'设置', 'child'=>array(
        array('name'=>'设置', 'op'=>null, 'act'=>'setting.setting'),
        array('name'=>'配送设置', 'op'=>null, 'act'=>'setting.delivery'),
        array('name'=>'清理缓存', 'op'=>null, 'act'=>'setting.cache'),
        array('name'=>'环境检测', 'op'=>null, 'act'=>'setting.science'),
    )),
    array('name'=>'权限管理', 'child'=>array(
        array('name'=>'管理员列表', 'op'=>null, 'act'=>'auth.admin'),
        array('name'=>'角色列表', 'op'=>null, 'act'=>'auth.role'),
        array('name'=>'修改密码', 'op'=>null, 'act'=>'admin.user'),
    )),
);

return $_limit;
