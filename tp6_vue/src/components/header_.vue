<template>
    <div class="tab-header">
        <div class="inner">
            <div class="pull-left">
                <div class="pull-left">嗨，欢迎来到<span class="cr" onclick="location.href='/'">Troku商城</span></div>
            </div>
            <div class="pull-right">
                <router-link to="/login" v-if="!username"><span class="cr" v-text="'请登录'"></span></router-link>
                <router-link to="/mine/set" v-if="username"><span v-text="username" style="color:red;"></span>,个人中心
                </router-link>
                <span @click="logout" v-if="username">&nbsp;&nbsp;退出</span>
            </div>
        </div>
    </div>
</template>

<script>
    import {logout} from "../lib/interface";

    export default {
        name: "header_",
        data() {
            return {
                username: "",
            }
        },
        mounted() {
            this.username = localStorage.getItem("username");
        },
        methods: {
            async logout() {
                let result = await logout();
                if (result.status == 1) {
                    localStorage.removeItem("token");
                    localStorage.removeItem("username");
                    // this.$router.replace("/");
                    location.reload();
                } else {
                    this.$Message.error('退出失败！');
                    return;
                }
            }
        }
    }
</script>

<style scoped>

</style>
