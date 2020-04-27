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
                        <div class="title">订单中心-订单<span v-text="orderData.id"></span></div>
                        <div class="order-info__box" style="min-height: 500px;">
                            <div class="order-addr">收货地址：<span class="c6" v-text="orderData.consignee_info"></span></div>
                            <div class="order-info">
                                订单信息
                                <table>
                                    <tr>
                                        <td>订单编号：<span v-text="orderData.id"></span></td>
<!--                                        <td>支付宝交易号：20175215464616164616</td>-->
                                        <td>创建时间：<span v-text="orderData.create_time"></span></td>
                                    </tr>
                                    <tr v-if="orderData.pay_time !== ''">
                                        <td>付款时间：<span  v-text="orderData.pay_time"></span></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-thead">
                                <div class="tdf3">商品</div>
                                <div class="tdf1">数量</div>
                                <div class="tdf1">单价</div>
                                <div class="tdf1">总价</div>
                            </div>
                            <div class="order-item__list">
                                <div class="item" v-for="(v,k) in orderData.malls">
                                    <div class="tdf3">
                                        <a>
                                            <div class="img"><img :src="v.image" alt=""
                                                                  class="cover"></div>
                                            <div class="ep2 c6">锦瑟 原创传统日常汉服男绣花交领衣裳cp情侣装春夏款</div>
                                        </a>
                                        <div class="attr ep" v-text="v.sku"></div>
                                    </div>
                                    <div class="tdf1" v-text="v.num"></div>
                                    <div class="tdf1">¥<span v-text="v.price"></span></div>
                                    <div class="tdf1">¥<span v-text="(v.price*v.num).toFixed(2)"></span></div>
                                </div>
                            </div>
                            <div class="price-total">
                                <div class="fz18 c6">实付款：<b class="cr">¥<span v-text="orderData.total_price"></span></b></div>
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
    import {orderInfo} from '../../lib/interface'


    export default {
        components: {header_, footer_, mineLeft},
        name: "orderdetail",
        data() {
            return {
                orderData:{},
                id: 0,
            }
        },
        mounted() {
            $("#order").addClass("active");
            this.id = this.$route.query.id;
            if (!this.id || this.id === 0) {
                this.$router.push("/");
            }
            this.getOrderInfo();
        },
        methods: {
            async getOrderInfo(){
                let result = await orderInfo({"id":this.id});
                this.orderData = result.result;
            }
        }
    }
</script>

<style scoped>

</style>
