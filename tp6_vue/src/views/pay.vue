<template>
    <div>
        <!-- 顶部tab -->
        <header_></header_>
        <div class="content clearfix bgf5">
            <section class="user-center inner clearfix">
                <div class="user-content__box clearfix bgf">
                    <div class="shop-title">收货地址</div>
                    <div class="shopcart-form__box">
                        <div class="addr-radio">
                            <div class="radio-line  active">
                                <label class="radio-label ep" v-text="orderInfo.consignee_info"></label>
                            </div>
                        </div>
                        <div class="shop-order__detail">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="120"></th>
                                    <th width="300">商品信息</th>
                                    <th width="150">单价</th>
                                    <th width="200">数量</th>
                                    <th width="80">总价</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(v,k) in orderInfo.malls">
                                    <th scope="row"><a>
                                        <div class="img"><img :src="v.image" alt="" style="width: 100px;height: 100px;"
                                                              class="cover">
                                        </div>
                                    </a></th>
                                    <td>
                                        <div class="name ep3" v-text="v.title"></div>
                                        <div class="type c9" v-text="v.sku"></div>
                                    </td>
                                    <td>¥<span v-text="v.price"></span></td>
                                    <td v-text="v.num"></td>
                                    <td>¥<span v-text="(v.price*v.num).toFixed(2)"></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="shop-cart__info clearfix">
                            <div class="pull-left text-left">
                                <div class="info-line text-nowrap">下单时间：<span class="c6"
                                                                              v-text="orderInfo.create_time"></span>
                                </div>
                                <div class="info-line text-nowrap">订单号：<span class="c6" v-text="orderInfo.id"></span>
                                </div>
                            </div>
                            <div class="pull-right text-right">
                                <div class="info-line">合计：<b class="fz18 cr">¥<span v-text="orderInfo.total_price"></span></b>
                                </div>
                            </div>
                        </div>
                        <div class="pay-mode__box">
                            <div class="radio-line radio-box">
                                <label class="radio-label ep">
                                    <input name="pay-mode" value="1" autocomplete="off" type="radio"><i
                                        class="iconfont icon-radio"></i>
                                    <img src="@/assets/images/icons/alipay.png" alt="支付宝支付">
                                </label>
                            </div>
                            <div class="radio-line radio-box">
                                <label class="radio-label ep">
                                    <input name="pay-mode" value="2" autocomplete="off" type="radio"><i
                                        class="iconfont icon-radio"></i>
                                    <img src="@/assets/images/icons/paywechat.png" alt="微信支付">
                                </label>
                            </div>
                        </div>
                        <div class="user-form-group shopcart-submit">
                            <button type="submit" class="btn" @click="pay">支付订单</button>
                        </div>
                    </div>
                </div>
                <Modal v-model="modalPay" title="微信扫码支付">
                    <p slot="header" style="color:#f60;text-align:center">
                        <span>请使用微信扫码支付</span>
                    </p>
                    <p style="color: #f60;text-align: center;">支付金额：￥<span v-text="orderInfo.total_price"></span></p>
                    <div id="qrcode" style="margin-top: 10px;margin:0 auto;">
                        <img :src="wxCode" width="100%"/>
                    </div>
                    <!--                    <p style="color: green;text-align: center;margin-top: 10px;padding-left: 5px;" @click="finshPay()">支付已完成？点击查看</p>-->
                    <div slot="footer">
                        <Button size="large" @click="modalPay = false">关闭</Button>
                    </div>
                </Modal>
            </section>
        </div>
    </div>
</template>

<script>
    import header_ from '../components/header_'
    import {orderInfo, pay, payQuery} from "../lib/interface";

    export default {
        components: {header_},
        name: "order",
        data() {
            return {
                "modalPay": false,
                "id": 0,
                "orderInfo": {},
                "payType": 0,
                "wxCode": "",
            }
        },
        mounted() {
            this.id = this.$route.query.id;
            if (!this.id) {
                this.$router.replace("/");
                return;
            }
            this.getOrderInfo();
        },
        methods: {
            async getOrderInfo() {
                let result = await orderInfo({"id": this.id});
                if (result.status !== 1) {
                    this.$router.replace("/");
                    return;
                }
                this.orderInfo = result.result;

            },
            async pay() {
                var t = $("input[name='pay-mode']:checked").val();
                if (t === undefined || t === null) {
                    this.$Message.error("请选择支付方式");
                    return;
                }
                var pay_type = "";
                if (t == 1) {
                    pay_type = "alipay";
                } else {
                    pay_type = "weixin";
                }
                let result = await pay({"id": this.id, "pay_type": pay_type});
                if (result.status == 1) {
                    // if (t == 1) { //ali
                    //
                    // } else {//weixin
                    // }
                    this.wxCode = result.result.imag_url;
                    console.log(this.wxCode);
                    this.modalPay = true;
                    this.query();
                } else {
                    this.$Message.error(result.message);
                }
            },
            async query() {
                var that = this;
                var queryTimer = setInterval(async function () {
                    let result = await payQuery({"order_id": that.id});
                    console.log(result.result);
                    if (result.result.pay_status === 1) {
                        clearInterval(queryTimer);
                        that.$router.replace("/mine/order");
                    }
                    console.log(result);
                }, 3000)
            }
        }
    }
</script>

<style scoped>

</style>
