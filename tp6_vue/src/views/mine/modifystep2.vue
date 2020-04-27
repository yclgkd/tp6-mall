<template>
    <div>
        <header_></header_>
        <div class="bgf5 clearfix">
            <div class="top-user">
                <div class="inner">
                    <a class="logo" href="/"><img src="@/assets/images//icons/logo.jpg" alt="X袋网"
                                                           class="cover"></a>
                    <div class="title">个人中心</div>
                </div>
            </div>
        </div>
        <div class="content clearfix bgf5">
            <section class="user-center inner clearfix">
                <mine-left></mine-left>
                <div class="pull-right">
                    <div class="user-content__box clearfix bgf">
                        <div class="title">账户信息-修改登录密码</div>
                        <div class="step-flow-box">
                            <div class="step-flow__bd">
                                <div class="step-flow__li step-flow__li_done">
                                    <div class="step-flow__state"><i class="iconfont icon-ok"></i></div>
                                    <p class="step-flow__title-top">验证身份</p>
                                </div>
                                <div class="step-flow__line step-flow__li_done">
                                    <div class="step-flow__process"></div>
                                </div>
                                <div class="step-flow__li step-flow__li_done">
                                    <div class="step-flow__state"><i class="iconfont icon-ok"></i></div>
                                    <p class="step-flow__title-top">重置支付密码</p>
                                </div>
                                <div class="step-flow__line step-flow__line_ing">
                                    <div class="step-flow__process"></div>
                                </div>
                                <div class="step-flow__li">
                                    <div class="step-flow__state"><i class="iconfont icon-ok"></i></div>
                                    <p class="step-flow__title-top">完成</p>
                                </div>
                            </div>
                        </div>
                        <div class="user-setting__form" role="form">
                            <div class="form-group">
                                <input class="form-control" name="phone" required="" maxlength="11" autocomplete="off"
                                       type="password">
                                <span class="tip-text">新的密码</span>
                                <span class="see-pwd pwd-toggle" title="显示密码"><i
                                        class="glyphicon glyphicon-eye-open"></i></span>
                                <span class="error_tip"></span>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <input class="form-control" name="phone" required="" maxlength="11"
                                           autocomplete="off" type="password">
                                    <span class="tip-text">再次确认新的密码</span>
                                    <span class="see-pwd pwd-toggle" title="显示密码"><i
                                            class="glyphicon glyphicon-eye-open"></i></span>
                                    <span class="error_tip"></span>
                                </div>
                            </div>
                            <div class="user-form-group tags-box">
                                <button type="submit" class="btn " @click="step3()">提交</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer_></footer_>
    </div>
</template>

<script>
    import header_ from '../../components/header_'
    import footer_ from '../../components/footer_'
    import mineLeft from '../../components/mine_left'
    import '../../assets/js/login'

    export default {
        components: {header_, footer_, mineLeft},
        name: "mine-pwdmodify",
        mounted() {
            this.$Notice.error({
                title: 'Notification title',
                desc: 'Here is the notification description. Here is the notification description. '
            });
            $("#pwdmodify").addClass("active");
            $('.form-control').on('blur focus', function () {
                $(this).addClass('focus');
                $('.error_tip').empty();
                if ($(this).val() == '') {
                    $(this).removeClass('focus')
                }
            });
        },
        methods: {
            step3() {
                this.$router.replace("/mine/modifystep3")
            }
        }
    }
</script>

<style scoped>

</style>
