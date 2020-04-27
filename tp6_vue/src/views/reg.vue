<template>
    <div>
        <div class="public-head-layout container">
            <router-link class="logo" to="/"><img src="@/assets/images/icons/logo.jpg" alt="TP6" class="cover"></router-link>
        </div>
        <div class="con">
            <div class="login-layout container">
                <div class="form-box register">
                    <div class="tabs-nav">
                        <h2>欢迎注册
                            <router-link to="/login" class="pull-right fz16">返回登录</router-link>
                        </h2>
                    </div>
                    <div class="tabs_container">
                        <form class="tabs_form" action="/" method="post" id="register_form">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                                    </div>
                                    <input class="form-control phone" name="phone" id="register_phone" required placeholder="手机号" maxlength="11" autocomplete="off" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" name="smscode" id="register_sms" placeholder="输入验证码" type="text">
                                    <span class="input-group-btn">
									<button class="btn btn-primary getsms" type="button">发送短信验证码</button>
								</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                    </div>
                                    <input class="form-control password" name="password" id="register_pwd" placeholder="请输入密码" autocomplete="off" type="password">
                                    <div class="input-group-addon pwd-toggle" title="显示密码"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input checked="" id="register_checkbox" type="checkbox"><i></i> 同意<a href="temp_article/udai_article3.html">X袋网用户协议</a>
                                </label>
                            </div>
                            <!-- 错误信息 -->
                            <div class="form-group">
                                <div class="error_msg" id="register_error"></div>
                            </div>
                            <button class="btn btn-large btn-primary btn-lg btn-block submit" id="register_submit" type="button">注册</button>
                        </form>
                        <div class="tabs_div">
                            <div class="success-box">
                                <div class="success-msg">
                                    <i class="success-icon"></i>
                                    <p class="success-text">注册成功</p>
                                </div>
                            </div>
                            <div class="option-box">
                                <div class="buts-title">
                                    现在您可以
                                </div>
                                <div class="buts-box">
                                    <a role="button" href="/" class="btn btn-block btn-lg btn-default">继续访问商城</a>
                                    <a role="button" href="/" class="btn btn-block btn-lg btn-info">登录会员中心</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "res",
        mounted() {
            $(document).ready(function () {
                // 判断直接进入哪个页面 例如 login.php?p=register
                switch ($.getUrlParam('p')) {
                    case 'register':
                        $('.register').show();
                        break;
                    case 'resetpwd':
                        $('.resetpwd').show();
                        break;
                    default:
                        $('.login').show();
                }
                ;
                // 发送验证码事件
                $('.getsms').click(function () {
                    var phone = $(this).parents('form').find('input.phone');
                    var error = $(this).parents('form').find('.error_msg');
                    switch (phone.validatemobile()) {
                        case 0:
                            // 短信验证码的php请求
                            error.html(msgtemp('验证码 <strong>已发送</strong>', 'alert-success'));
                            $(this).rewire(60);
                            break;
                        case 1:
                            error.html(msgtemp('<strong>手机号码为空</strong> 请输入手机号码', 'alert-warning'));
                            break;
                        case 2:
                            error.html(msgtemp('<strong>手机号码错误</strong> 请输入11位数的号码', 'alert-warning'));
                            break;
                        case 3:
                            error.html(msgtemp('<strong>手机号码错误</strong> 请输入正确的号码', 'alert-warning'));
                            break;
                    }
                });
                // 以下确定按钮仅供参考
                $('.submit').click(function () {
                    var form = $(this).parents('form')
                    var phone = form.find('input.phone');
                    var pwd = form.find('input.password');
                    var error = form.find('.error_msg');
                    var success = form.siblings('.tabs_div');
                    var options = {
                        beforeSubmit: function () {
                            console.log('喵喵喵')
                        },
                        success: function (data) {
                            console.log(data)
                        }
                    }
                    // 验证手机号参考这个
                    switch (phone.validatemobile()) {
                        case 1:
                            error.html(msgtemp('<strong>手机号码为空</strong> 请输入手机号码', 'alert-warning'));
                            return;
                            break;
                        case 2:
                            error.html(msgtemp('<strong>手机号码错误</strong> 请输入11位数的号码', 'alert-warning'));
                            return;
                            break;
                        case 3:
                            error.html(msgtemp('<strong>手机号码错误</strong> 请输入正确的号码', 'alert-warning'));
                            return;
                            break;
                    }
                    // 验证密码复杂度参考这个
                    switch (pwd.validatepwd()) {
                        case 1:
                            error.html(msgtemp('<strong>密码不能为空</strong> 请输入密码', 'alert-warning'));
                            return;
                            break;
                        case 2:
                            error.html(msgtemp('<strong>密码过短</strong> 请输入6位以上的密码', 'alert-warning'));
                            return;
                            break;
                        case 3:
                            error.html(msgtemp('<strong>密码过于简单</strong><br>密码需为字母、数字或特殊字符组合', 'alert-warning'));
                            return;
                            break;
                    }
                    form.ajaxForm(options);
                    // 请求成功执行类似这样的事件
                    // form.fadeOut(150,function() {
                    // 	success.fadeIn(150);
                    // });
                })
            });
        },
        methods: {}
    }
</script>

<style scoped>
    .con {
        background: url(../assets/images/login_bg.jpg) no-repeat center center;
    }

    * {
        /*font-family: 'Microsoft Yahei';*/
    }

    .public-head-layout {
        height: 120px;
        position: relative;
    }

    .logo {
        width: 200px;
        height: 100px;
        display: block;
        position: absolute;
        bottom: 0;
        left: 50px;
    }

    .login-layout {
        height: 450px;
        position: relative;
    }

    .form-box {
        width: 340px;
        min-height: 340px;
        padding: 25px 20px;
        position: absolute;
        right: 100px;
        top: 20px;
        background-color: #fff;
        border-radius: 5px;
        -webkit-box-shadow: 0 15px 35px -25px #b31e22;
        -moz-box-shadow: 0 15px 35px -25px #b31e22;
        box-shadow: 0 15px 35px -25px #b31e22;
    }

    .tabs_div {
        display: none;
    }

    .tabs-nav h2 {
        font-size: 18px;
        margin-top: 0;
        padding: 10px 0;
        margin-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .success-box {
        width: 100%;
        height: 160px;
        position: relative;
    }

    .success-msg {
        height: 96px;
        text-align: center;
        position: absolute;
        margin: auto;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    .success-icon {
        width: 64px;
        height: 64px;
        display: inline-block;
        background-image: url(../assets/images/icons/success.png);
    }

    .success-text {
        text-align: center;
        font-size: 16px;
        line-height: 32px;
        height: 32px;
        margin-bottom: 0;
    }

    .buts-title {
        color: #999;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .footer-login {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        margin-top: 200px;
        border-top: 1px solid #e0e0e0;
    }

    .links {
        margin-top: 10px;
        display: -webkit-flex;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
    }

    .links li {
        color: #333;
        min-width: 80px;
        text-align: center;
        margin: 10px 20px 0;
    }

    .copyright {
        color: #666;
        text-align: center;
        line-height: 2em;
    }
</style>
