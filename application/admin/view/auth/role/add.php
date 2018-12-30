<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加角色</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-form-label form-require">角色名称 </label>
                                <div class="am-u-end">
                                    <input type="text" class="tpl-form-input" name="Role[name]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-form-label">权限节点 </label>
                                <div class="am-u-end">
                                    <?php foreach($limit as $k => $v) : ?>
                                        <div class="am-form-group">
                                            <label class="am-form-label am-u-sm-3 am-u-lg-2" style="text-align: left;">
                                                <label class="am-checkbox-inline">
                                                    <input class="auth" type="checkbox" data-flage="false" data-item="limit<?php echo $k;?>" data-am-ucheck >
                                                    <?php echo $v['name'];?>
                                                </label>
                                            </label>

                                            <div class="am-u-sm-9 am-u-end">
                                                <?php if($v['child']):foreach ($v['child'] as $key => $val):?>
                                                    <label class="am-checkbox-inline">
                                                        <input class="limit<?php echo $k;?>" type="checkbox" name="Role[act][]" value="<?php echo $val['act'];?>" data-am-ucheck >
                                                        <?php echo $val['name'];?>
                                                    </label>
                                                <?php endforeach;endif;?>
                                            </div>
                                        </div>
                                    <?php endforeach;?>

                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
{{include file="layouts/_template/tpl_file_item" /}}

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<script>
    $(function () {

        $(".auth").unbind('click').bind('click',function () {
            if($(this).attr('data-flage') == 'true'){
                $(this).attr('data-flage',false);
                $('.'+$(this).attr('data-item')).iCheck('uncheck');
            }else{
                $(this).attr('data-flage',true);
                $('.'+$(this).attr('data-item')).iCheck('check');
            }
        })

        // 选择图片
        $('.upload-file').selectImages({
            name: 'recruit[image_id]'
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
