<template>
    <div>
        <div class="public-head-layout container">
            <router-link class="logo" to="/"><img src="@/assets/images/icons/logo.jpg" alt="TP6" class="cover">
            </router-link>
        </div>
        <div class="con">
            <div class="login-layout container">
                <div class="form-box login">
                    <div class="tabs-nav">
                        <h2>欢迎登录Troku商城</h2>
                    </div>
                    <div class="tabs_container">
                        <form class="tabs_form" action="" method="post" id="login_form">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                                    </div>
                                    <input class="form-control phone" name="phone" v-model="phone"
                                           placeholder="手机号" maxlength="11" autocomplete="off" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                    </div>
                                    <input class="form-control password" v-model="code" name="password"
                                           placeholder="请输入验证码" autocomplete="off" type="text">
                                    <div v-if="!sendDisabled" v-text="sendText" class="input-group-addon pwd-toggle"
                                         title="发送验证码"
                                         @click="sendCode">
                                    </div>
                                    <div v-if="sendDisabled" v-text="sendText" class="input-group-addon pwd-toggle"
                                         title="发送验证码">
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input checked="" id="login_checkbox" type="checkbox"><i></i> 30天内免登录
                                </label>
                            </div>
                            <!-- 错误信息 -->
                            <div class="form-group">
                                <div class="error_msg" id="login_error">
                                </div>
                            </div>
                            <button class="btn btn-large btn-primary btn-lg btn-block submit" id="login_submit"
                                    type="button" @click="login">登录
                            </button>
                            <br>
                        </form>
                        <div class="tabs_div">
                            <div class="success-box">
                                <div class="success-msg">
                                    <i class="success-icon"></i>
                                    <p class="success-text">登录成功</p>
                                </div>
                            </div>
                            <div class="option-box">
                                <div class="buts-title">
                                    现在您可以
                                </div>
                                <div class="buts-box">
                                    <a role="button" href="/"
                                       class="btn btn-block btn-lg btn-default">继续访问商城</a>
                                    <a role="button" href="udai_welcome.html" class="btn btn-block btn-lg btn-info">登录会员中心</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer_></footer_>
    </div>
</template>

<script>
    import lvaild from '../lib/lvalid'
    import footer_ from '../components/footer_'
    import {smscode, login} from "../lib/interface";

    export default {
        name: "login",
        components: {footer_},
        data() {
            return {
                sendDisabled: false,
                sendText: "发送验证码",
                phone: "",
                code: "",
                url: "",
            }
        },
        mounted() {
            this.url = decodeURIComponent(this.$route.query.redirect);
            // router.push({path:decodeURIComponent(url)});
        },
        methods: {
            //发送验证码
            async sendCode() {
                var that = this;
                if (this.phone == "" || !lvaild.checkMobile(this.phone)) {
                    this.$Message.error('请输入正确的手机号码！');
                    return;
                }
                let result = await smscode({"phone_number": this.phone});
                if (result.status == 0) {
                    this.$Message.error(result.message);
                    return;
                } else {
                    this.$Message.success(result.message);
                    let timerNum = 60;
                    this.sendDisabled = true;
                    let timer = setInterval(function () {
                        if (timerNum <= 0) {
                            that.sendText = "发送验证码";
                            clearInterval(timer);
                            that.sendDisabled = false;
                        } else {
                            that.sendText = timerNum + "秒后重新获取";
                            timerNum--;
                        }
                    }, 1000);
                }
            },
            async login() {
                if (this.phone == "") {
                    this.$Message.error('请输入正确的手机号码！');
                    return;
                }
                if (this.code == "") {
                    this.$Message.error('请输入短信验证码！');
                    return;
                }
                let result = await login({"phone_number": this.phone, "code": this.code, "type": 2});
                if (result.status == 1) {
                    localStorage.setItem("token", result.result.token);
                    localStorage.setItem("username", result.result.username);
                    if (this.url == "undefined") {
                        this.$router.replace("/");
                    } else {
                        this.$router.replace(this.url);
                    }
                } else {
                    this.$Message.error(result.message);
                    return;
                }
                //console.log(result);
                // this.$Message.success(result.msg);
                // console.log(result);
            }
        }
    }
</script>

<style scoped>
    .con {
        background: url(https://img10.360buyimg.com/cms/jfs/t1/93644/17/2153/575179/5dcb5129E5b2f2bed/ae22122812cedc5c.jpg) no-repeat center center;
        /*background: #b31e22;*/
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
