<template>
    <div>
        <!-- 顶部标题 -->
        <header_></header_>
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
                        <div class="title">订单中心-我的订单</div>
                        <div class="order-list__box bgf">
                            <div class="order-panel">
                                <ul class="nav user-nav__title" role="tablist">
                                    <li role="presentation" class="nav-item active" id="nav-item_-1"
                                        @click="changeType(-1)"><a>所有订单</a></li>
                                    <li role="presentation" class="nav-item" @click="changeType(1)" id="nav-item_1"><a>待付款</a>
                                    </li>
                                    <li role="presentation" class="nav-item" @click="changeType(2)" id="nav-item_2"><a>待发货</a>
                                    </li>
                                    <li role="presentation" class="nav-item" @click="changeType(3)" id="nav-item_3"><a>待收货</a>
                                    </li>
                                    <li role="presentation" class="nav-item" @click="changeType(4)" id="nav-item_4"><a>已完成</a>
                                    </li>
                                    <li role="presentation" class="nav-item" @click="changeType(5)" id="nav-item_5"><a>已取消</a>
                                    </li>
                                </ul>

                                <div class="tab-content" style="margin-top: 20px;">
                                    <div role="tabpanel" class="tab-pane fade in active" id="all">
                                        <table class="table text-center">
                                            <tr>
                                                <th width="380">商品信息</th>
                                                <th width="85">数量</th>
                                                <th width="120">实付款</th>
                                                <th width="120">交易状态</th>
                                                <th width="120">交易操作</th>
                                            </tr>
                                            <tr class="order-item" v-for="(v,k) in orderInfo">
                                                <td style="height: 100%;" @click="detail(v.id)">
                                                    <label>
                                                        <router-link to="/mine/orderdetail" class="num">
                                                            <span v-text="v.create_time"></span> 订单号: <span
                                                                v-text="v.id"></span>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <span v-if="v.type === 1" style="color: red;">
                                                                <br/>订单过期时间：<span
                                                                    v-text="v.order_expiration_time"></span></span>
                                                        </router-link>
                                                        <div class="card" style="height: 26px;">
                                                            <div class="name ep2" v-text="v.mall_title"></div>
                                                        </div>
                                                    </label>
                                                </td>
                                                <td v-text="v.count" @click="detail(v.id)"></td>
                                                <td @click="detail(v.id)">￥<span v-text="v.total_price"></span></td>
                                                <td @click="detail(v.id)" class="state">
                                                    <a class="but c6" v-text="v.type_name"></a>
                                                </td>
                                                <td class="order">
                                                    <div class="del" v-if="v.type === 5" @click="changeStatus(v.id,99)"><span
                                                            class="glyphicon glyphicon-trash"
                                                            aria-hidden="true"></span></div>
                                                    <a v-if="v.type === 1" @click="pay(v.id)" class="but but-primary">立即付款</a>
                                                    <a v-if="v.type === 3" class="but but-primary"
                                                       @click="changeStatus(v.id,6)">确认收货</a>
                                                    <a class="but c3" v-if="v.type === 1"
                                                       @click="changeStatus(v.id,5)">取消订单</a>
                                                </td>
                                            </tr>
                                        </table>
                                        <Page :total="total" :current="pageNum" show-sizer show-total
                                              @on-page-size-change="pageSizeChange"
                                              :page-size="pageSize"
                                              @on-change="changePage" style="text-align: center;"></Page>
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
    import {orderList, doOrder} from '../../lib/interface'

    export default {
        components: {header_, footer_, mineLeft},
        name: "order",
        data() {
            return {
                "pageSize": 10,
                "pageNum": 1,
                "total": 0,
                "status": -1,
                orderInfo: [],
            }
        },
        mounted() {
            $('.to-top').toTop({position: false});
            $("#order").addClass("active");
            this.getOrderInfo();
        },
        methods: {
            async pageSizeChange(pageSize) {
                this.pageSize = pageSize;
                this.getOrderInfo()
            },
            changePage(page) {
                this.pageNum = page;
                this.getOrderInfo()
            },
            changeType(t) {
                this.pageNum = 1;
                this.status = t;
                $(".nav-item").removeClass("active");
                $("#nav-item_" + t).addClass("active");
                this.getOrderInfo();
            },
            async getOrderInfo() {
                var data = {
                    "page": this.pageNum,
                    "page_size": this.pageSize,
                };
                if (this.status !== -1) {
                    data.type = this.status;
                } else {
                    delete (data["type"])
                }
                let result = await orderList(data);
                this.total = result.result.count;
                this.orderInfo = result.result.list;
            },
            async changeStatus(id, status) {
                let result = await doOrder({"id": id, "type": status});
                if (result.status === 1) {
                    this.$Message.success(result.message);
                    this.getOrderInfo();
                } else {
                    this.$Message.error(result.message);
                }
            },
            detail(id) {
                this.$router.push("/mine/orderDetail?id=" + id)
            },
            pay(id) {
                this.$router.push("/pay?id=" + id);
            }
        }
    }
</script>

<style scoped>

</style>
