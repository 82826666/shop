<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">优惠卷列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs" style="z-index: 999;">
                                    <a class="am-btn am-btn-default am-btn-success am-radius"
                                       href="<?= url('coupon.coupon/add') ?>">
                                        <span class="am-icon-plus"></span> 新增
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>优惠卷ID</th>
                                <th>优惠卷名称</th>
                                <th>优惠码</th>
                                <th>最低消费金额（元）</th>
                                <th>优惠金额	</th>
                                <th>有效天数</th>
                                <th>数量	</th>
                                <th>优惠卷状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['id'] ?></td>
                                    <td class="am-text-middle"><?= $item['coupon_name'] ?></td>
                                    <td class="am-text-middle"><?= $item['coupon_sn'] ?></td>
                                    <td class="am-text-middle"><?= $item['min_price']==0?'无门槛':$item['min_price'] ?></td>
                                    <td class="am-text-middle"><?= $item['sub_price'] ?></td>
                                    <td class="am-text-middle"><?= $item['expire_day'] ?></td>
                                    <td class="am-text-middle"><?= $item['total_number']==-1?'不限':$item['total_number'] ?></td>
                                    <td class="am-text-middle"><?= $item['status']==1?'开启':'关闭' ?></td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a href="<?= url('coupon.coupon/edit',
                                                ['id' => $item['id']]) ?>">
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
                                            <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                               data-id="<?= $item['id'] ?>">
                                                <i class="am-icon-trash"></i> 删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="9" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        // 删除元素
        let url = "<?= url('coupon.coupon/delete') ?>";
        $('.item-delete').delete('id', url);

    });
</script>

