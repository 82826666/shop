<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'index' => 'index/index',         // 链接
 *     ],
 */
return [
    'index' => [
        'name' => '首页',
        'index' => 'index/index',
    ],
    'goods' => [
        'name' => '商品管理',
        'index' => 'goods.goods/index',
        'submenu' => [
            [
                'name' => '商品列表',
                'index' => 'goods.goods/index',
                'uris' => [
                    'goods.goods/index',
                    'goods.goods/add',
                    'goods.goods/edit'
                ],
            ],
            [
                'name' => '商品分类',
                'index' => 'goods.category/index',
                'uris' => [
                    'goods.category/index',
                    'goods.category/add',
                    'goods.category/edit',
                ],
            ]
        ],
    ],
    'recruit' => [
        'name' => '招聘管理',
        'index' => 'recruit.recruit/index',
        'submenu' => [
            [
                'name' => '招聘列表',
                'index' => 'recruit.recruit/index',
                'uris' => [
                    'recruit.recruit/index',
                    'recruit.recruit/add',
                    'recruit.recruit/edit'
                ],
            ],
        ],
    ],
    'coupon' => [
        'name' => '优惠券管理',
        'index' => 'coupon.coupon/index',
        'submenu' => [
            [
                'name' => '优惠券列表',
                'index' => 'coupon.coupon/index',
                'uris' => [
                    'coupon.coupon/index',
                    'coupon.coupon/add',
                    'coupon.coupon/edit'
                ],
            ],
        ],
    ],
    'order' => [
        'name' => '订单管理',
        'index' => 'order.order/delivery_list',
        'submenu' => [
            [
                'name' => '待发货',
                'index' => 'order.order/delivery_list',
            ],
            [
                'name' => '待收货',
                'index' => 'order.order/receipt_list',
            ],
            [
                'name' => '待付款',
                'index' => 'order.order/pay_list',
            ],
            [
                'name' => '已完成',
                'index' => 'order.order/complete_list',

            ],
            [
                'name' => '已取消',
                'index' => 'order.order/cancel_list',
            ],
            [
                'name' => '全部订单',
                'index' => 'order.order/all_list',
            ],
        ]
    ],
    'user' => [
        'name' => '用户管理',
        'index' => 'user.user/index',
        'submenu' => [
            [
                'name' => '会员管理',
                'index' => 'user.user/index',
                'uris' => [
                    'user.user/index',
                    'user.user/add',
                    'user.user/edit',
                ],
            ],
        ]
    ],
//    'marketing' => [
//        'name' => '营销管理',
//        'index' => 'marketing/index',
//        'submenu' => [],
//    ],
    'setting' => [
        'name' => '设置',
        'index' => 'setting.setting/store',
        'submenu' => [
            [
                'name' => '商城设置',
                'index' => 'setting.setting/store',
            ],
            [
                'name' => '交易设置',
                'index' => 'setting.setting/trade',
            ],
            [
                'name' => '配送设置',
                'index' => 'setting.delivery/index',
                'uris' => [
                    'setting.delivery/index',
                    'setting.delivery/add',
                    'setting.delivery/edit',
                ],
            ],
            [
                'name' => '短信通知',
                'index' => 'setting.setting/sms'
            ],
            [
                'name' => '上传设置',
                'index' => 'setting.setting/storage',
            ],
            [
                'name' => '小程序设置',
                'index' => 'setting.setting/small',
            ],
            [
                'name' => '小程序支付设置',
                'index' => 'setting.setting/small_pay',
            ],
            [
                'name' => '公众号设置',
                'index' => 'setting.setting/wechat',
            ],
            [
                'name' => '公众号支付设置',
                'index' => 'setting.setting/wechat_pay',
            ],
            [
                'name' => '其他',
                'index' => 'setting.cache/clear',
                'active' => true,
                'submenu' => [
                    [
                        'name' => '清理缓存',
                        'index' => 'setting.cache/clear'
                    ],
                    [
                        'name' => '环境检测',
                        'index' => 'setting.science/index'
                    ],
                ]
            ]
        ],
    ],
    'auth' => [
        'name' => '权限管理',
        'index' => 'auth.admin/index',
        'submenu' => [
            [
                'name' => '管理员列表',
                'index' => 'auth.admin/index',
                'uris' => [
                    'auth.admin/index',
                    'auth.admin/add',
                    'auth.admin/edit'
                ],
            ],
            [
                'name' => '角色列表',
                'index' => 'auth.role/index',
                'uris' => [
                    'auth.role/index',
                    'auth.role/add',
                    'auth.role/edit'
                ],
            ],
        ],
    ],
];
