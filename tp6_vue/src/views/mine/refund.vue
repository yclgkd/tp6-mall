<template>
    <div>
        <!-- 顶部tab -->
        <header_></header_>
        <!-- 顶部标题 -->
        <div class="bgf5 clearfix">
            <div class="top-user">
                <div class="inner">
                    <router-link class="logo" to="/"><img src="@/assets/images/icons/logo.jpg" alt="TP6" class="cover">
                    </router-link>
                    <div class="title">个人中心</div>
                </div>
            </div>
        </div>
        <div class="content clearfix bgf5">
            <section class="user-center inner clearfix">
                <mine-left></mine-left>
                <div class="pull-right">
                    <div class="user-content__box clearfix bgf">
                        <div class="title">订单中心-退款/退货</div>
                        <div class="order-list__box bgf">
                            <div class="order-panel">
                                <ul class="nav user-nav__title" role="tablist">
                                    <li role="presentation" class="nav-item active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">所有订单</a></li>
                                    <li role="presentation" class="nav-item "><a href="#money" aria-controls="money" role="tab" data-toggle="tab">退款 <span class="cr">0</span></a></li>
                                    <li role="presentation" class="nav-item "><a href="#item" aria-controls="item" role="tab" data-toggle="tab">退货 <span class="cr">0</span></a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="all">
                                        <table class="table table-hover table-striped text-center">
                                            <tr>
                                                <th width="170">申请单号</th>
                                                <th width="170">原订单号</th>
                                                <th width="170">商品名称</th>
                                                <th width="105">申请时间</th>
                                                <th width="105">应退金额</th>
                                                <th width="90">订单状态</th>
                                                <th width="90">操作</th>
                                            </tr>
                                            <tr>
                                                <td>2669901385864042</td>
                                                <td>2669901385864042</td>
                                                <td class="text-left">
                                                    <div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div>
                                                    <div class="c9 ep">颜色分类：深棕色  尺码：均码</div>
                                                </td>
                                                <td>2017-03-30</td>
                                                <td>¥18.0</td>
                                                <td class="refund-state">退款中<br><a href="">联系客服</a></td>
                                                <td class="refund-state"><a href="">取消退款</a></td>
                                            </tr>

                                            <tr>
                                                <td>2669901385864042</td>
                                                <td>2669901385864042</td>
                                                <td class="text-left">
                                                    <div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div>
                                                    <div class="c9 ep">颜色分类：深棕色  尺码：均码</div>
                                                </td>
                                                <td>2017-03-30</td>
                                                <td>¥18.0</td>
                                                <td class="refund-state">已退货<br><a href="">联系客服</a></td>
                                                <td class="refund-state"><a href="">完成</a></td>
                                            </tr>

                                            <tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">已退款<br><a href="">联系客服</a></td><td class="refund-state"><a href="">完成</a></td></tr>
                                            <tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr><tr><td>2669901385864042</td><td>2669901385864042</td><td class="text-left"><div class="name ep" style="width: 180px">纯色圆领短袖T恤活动衫弹</div><div class="c9 ep">颜色分类：深棕色  尺码：均码</div></td><td>2017-03-30</td><td>¥18.0</td><td class="refund-state">退款中<br><a href="">联系客服</a></td><td class="refund-state"><a href="">取消退款</a></td></tr>
                                        </table>
                                        <Page :total="100" show-total show-elevator show-sizer style="margin-left: 15%;" />
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="money">
                                        <table class="table text-center">
                                            <tr>
                                                <th width="380">商品信息</th>
                                                <th width="85">单价</th>
                                                <th width="85">数量</th>
                                                <th width="120">实付款</th>
                                                <th width="120">交易状态</th>
                                                <th width="120">交易操作</th>
                                            </tr>
                                            <tr class="order-empty"><td colspan='6'>
                                                <div class="empty-msg">最近没有退款订单！</div>
                                            </td></tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="item">
                                        <table class="table text-center">
                                            <tr>
                                                <th width="380">商品信息</th>
                                                <th width="85">单价</th>
                                                <th width="85">数量</th>
                                                <th width="120">实付款</th>
                                                <th width="120">交易状态</th>
                                                <th width="120">交易操作</th>
                                            </tr>
                                            <tr class="order-empty"><td colspan='6'>
                                                <div class="empty-msg">最近没有退货订单！</div>
                                            </td></tr>
                                        </table>
                                    </div>
                                </div>
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

    export default {
        components: {header_, footer_, mineLeft},
        name: "center",
        mounted() {
            $("#refund").addClass("active");
            var recommends = new Swiper('.recommends-swiper', {
                spaceBetween: 40,
                autoplay: 5000,
            });
            $('.to-top').toTop({position: false})
        },
        methods: {}
    }
</script>

<style scoped>

</style>
