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
                    <div class="user-content__box clearfix bgf" style="min-height:700px;">
                        <div class="title">账户信息-修改登陆密码</div>
                        <div class="modify_div">
                            <div class="clearfix">
                                <router-link to="/mine/modifystep1" role="button" class="but">修改登陆密码</router-link>
                            </div>
                            <div class="help-block">随时都能更改密码，保障您账户的安全</div>
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

    export default {
        components: {header_, footer_, mineLeft},
        name: "mine-pwdmodify",
        mounted() {
            this.$Notice.error({
                title: 'Notification title',
                desc: 'Here is the notification description. Here is the notification description. '
            });
            $("#pwdmodify").addClass("active");
        },
        methods: {}
    }
</script>

<style scoped>

</style>
