<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>后台管理系统登入界面</title>
        <link href="<?php echo base_url('css/login.css') ?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/grocery_crud/js/jquery-1.10.2.min.js') ?>"></script>
    </head>
    <body >

        <div id="main">
            <div id="login">
                <div id="login_form">
                    <p id="login_title">后台登录</p>
                    <form method="post" action="<?php echo base_url('admin/login/login_in') ?>" charset="utf-8">
                        <dl>
                            <dt>用户名：</dt>
                            <dd><input name="name" class="input_user" id="name" maxlength="15"/></dd>
                            <dt>密　码：</dt>
                            <dd><input name="password" type="password" class="input_pwd" maxlength="15" /></dd>
                            <dt>验证码：</dt>
                            <dd><input name="chknum" type="text" class="input_chk" id="chknum" size="10" maxlength="6" autocomplete="off" />
                                <em id="new_code"></em>
                            </dd>
                            <br clear="all" />
                        </dl>
                        <p>
                            <input type="submit" class="loginbtn" name="Submit" value="登  录"/>
                        </p>
                    </form>
                </div>
            </div>
<!--            <div id="foot">
                <div id="copyright"></div>
                <div class="browser">
                    <P>我们不想您错过最流行的交互体验在老版本的浏览器上，最佳的操作效果，请使用下面这些浏览器。</P>
                    <ul>
                        <li><a title="Download Chrome" target="_blank" href="http://www.google.cn/intl/zh-CN/chrome/browser/"><img style="padding-top: 7px" width="52" height="52" src="/admin_images/icon_download_chrome.png" class="bump"><span>Download<br>Chrome</span></a></li>
                        <li><a title="Download Firefox" target="_blank" href="http://www.firefox.com.cn/download/"><img style="padding-top: 7px" width="55" height="52" src="/admin_images/icon_download_firefox.png" class="bump"><span>Download<br>Firefox</span></a></li>
                        <li><a title="Download Safari" target="_blank" href="http://www.apple.com/safari/"><img width="52" height="59" src="/admin_images/icon_download_safari.png"><span>Download<br>Safari</span></a></li>
                    </ul>
                </div>
            </div>-->
        </div>

    </body>
</html>
<script>
    $(function() {

        $('#name').focus();
        var new_code = '';
        for (var i = 0; i < 4; i++) {
            new_code += '&nbsp;' + Math.floor(Math.random() * 10);
        }
        $("#new_code").html(new_code);
        var h = $(window).height();
        $('#login').css('top', h / 4);
        $('#foot').css('top', h / 4 + 50);

    });

</script>
