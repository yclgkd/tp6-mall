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
                        <div class="title">账户信息-修改登陆密码</div>
                        <div class="step-flow-box">
                            <div class="step-flow__bd">
                                <div class="step-flow__li step-flow__li_done">
                                    <div class="step-flow__state"><i class="iconfont icon-ok"></i></div>
                                    <p class="step-flow__title-top">输入旧密码</p>
                                </div>
                                <div class="step-flow__line step-flow__li_done">
                                    <div class="step-flow__process"></div>
                                </div>
                                <div class="step-flow__li step-flow__li_done">
                                    <div class="step-flow__state"><i class="iconfont icon-ok"></i></div>
                                    <p class="step-flow__title-top">重置登陆密码</p>
                                </div>
                                <div class="step-flow__line step-flow__li_done">
                                    <div class="step-flow__process"></div>
                                </div>
                                <div class="step-flow__li step-flow__li_done">
                                    <div class="step-flow__state"><i class="iconfont icon-ok"></i></div>
                                    <p class="step-flow__title-top">完成</p>
                                </div>
                            </div>
                        </div>
                        <div class="modify-success__box text-center">
                            <div class="icon b-r50"><i class="iconfont icon-checked cf fz24"></i></div>
                            <div class="text c6">登陆密码设置成功！</div>
<!--                            <router-link to="/login" class="btn"><span id="sec">3</span> 秒后跳转至登陆页面，如果浏览器未跳转请点击这里</router-link>-->
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
            // var time = 3;
            // var that = this;
            // window.setInterval(function () {
            //     $('#sec').html(time--);
            //     if (time < 0) {
            //         that.$router.replace("/login");
            //         return ;
            //     }
            // }, 1000);
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
