<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>后台管理系统登入界面</title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/admin.css'); ?>" />
        <?php foreach ($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
        <?php foreach ($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
    </head>
    <body>
        <div class="header_nav">
            <div class="header_nav_div">
                <!--<img src="/img/logo.jpg" width="181" height="35"/>-->
                <a href="<?php echo base_url('admin/login/login_out') ?>">退出</a>
                <a href="<?php echo base_url() ?>" target="_blank">首页</a>
                <a href="<?php echo base_url('admin/login/change_password') ?>">修改密码</a>
            </div>
        </div>
        <div class="body">
            <div class="body_left">
                <?php $this->load->view('admin/menu') ?>
            </div>
            <div style="float: left;" id="right_width"><?php echo $output; ?></div>
        </div>
        
        <div class="footer">
            <span>
                技术支持：<a href="http://www,shecai.cc" target="_blank">设彩广告</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：0573-82696208
            </span>
        </div>
    </body>
</html>