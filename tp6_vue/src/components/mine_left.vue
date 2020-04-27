<template>
    <div class="pull-left bgf">
        <router-link class="title">singwa商城，欢迎您</router-link>
        <dl class="user-center__nav">
            <dt>帐户信息</dt>
            <router-link to="/mine/set">
                <dd id="set">个人资料</dd>
            </router-link>
            <router-link to="/mine/address">
                <dd id="address">收货地址</dd>
            </router-link>
        </dl>
        <dl class="user-center__nav">
            <dt>订单中心</dt>
            <router-link to="/mine/order">
                <dd id="order">我的订单</dd>
            </router-link>
            <router-link to="/mine/collection">
                <dd id="collection">我的收藏</dd>
            </router-link>
            <router-link to="/mine/refund">
                <dd id="refund">退款/退货</dd>
            </router-link>
        </dl>
    </div>
</template>

<script>
    export default {
        name: "mine_left"
    }
</script>

<style scoped>

</style>
