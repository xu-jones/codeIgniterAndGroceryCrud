<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>后台管理系统--修改密码</title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/admin.css'); ?>" />
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery-1.10.2.min.js') ?>"></script>
    </head>
    <body>
        <div class="header_nav">
            <div class="header_nav_div">
                <a href="<?php echo base_url('admin/login/login_out') ?>">退出</a>
                <a href="<?php echo base_url() ?>" target="_blank">首页</a>
                <a href="<?php echo base_url('admin/login/change_password') ?>">修改密码</a>
            </div>
        </div>
        <div class="body">
            <div class="body_left">
                <?php $this->load->view('admin/menu') ?>
            </div>
            <div style="float: left;" id="right_width">
                <dl>
                    <dt>新的密码：</dt>
                    <dd><input name="password" id="password" type="password" class="input_pwd" maxlength="15" /></dd>
                    <dt>确认密码：</dt>
                    <dd><input name="password2" id="password2" type="password" class="input_pwd" maxlength="15" /><span id="password_error"></span></dd>
                </dl>
                <p>
                    <input type="button" class="loginbtn" id="change_password" value="修  改"/>
                </p>
            </div>
        </div>
    </body>
</html>
<script>
    $(function() {

        $('#change_password').click(function() {
            var p1 = $('#password').val();
            var p2 = $('#password2').val();
            if (p1 != p2) {
                $('#password_error').html('两次密码不一致！');
            } else {
                $.getJSON('/admin/login/change_password_getJSON', {p1: p1, p2: p2}, function(data) {
                    if (data.code == '1') {
                        $('#password_error').html('修改成功！');
                    } else {
                        $('#password_error').html(data.info);
                    }
                });
            }
        });


    });
</script>