<template>
    <div>
        <!-- 顶部tab -->
        <header_></header_>
        <!-- 顶部标题 -->
        <div class="content clearfix bgf5">
            <section class="user-center inner clearfix">
                <div class="user-content__box clearfix bgf">
                    <div class="shop-title">选择收货地址</div>
                    <div class="shopcart-form__box">
                        <div class="addr-radio">
                            <div class="radio-line radio-box" :id="'address'+k" :val="v.id"
                                 v-for="(v,k) in addressList">
                                <label class="radio-label ep">
                                    <input name="addr" :value="v.id" autocomplete="off" type="radio" :id="'radio_'+k"><i
                                        class="iconfont icon-radio"></i>
                                    <span v-text="v.consignee_info"></span>
                                </label>
                                <a v-if="v.is_default === 1" class="default">默认地址</a>
                            </div>
                        </div>
                        <div class="add_addr">
                            <router-link to="/mine/address">添加新地址</router-link>
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
                                <tr v-for="(v,k) in cartList">
                                    <th scope="row">
                                        <div class="img"><img :src="v.image" style="width: 100px;height: 100px;" alt="" class="cover">
                                        </div>
                                    </th>
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
                        <div class="user-form-group shopcart-submit">
                            <button type="submit" class="btn" @click="pay">提交订单</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    import header_ from '../components/header_'
    import {cartList, address, order} from '../lib/interface'

    export default {
        components: {header_},
        name: "order",
        data() {
            return {
                ids: "",
                cartList: [],
                addressList: [],
                addressId: 0,
            }
        },
        mounted() {
            this.ids = this.$route.query.ids;
            if (!this.ids) {
                this.$router.replace("/");
                return;
            }
            this.getCartList();
            this.getAddress();
            var that = this;
            $(document).ready(function () {
                $(this).on('change', 'input', function () {
                    that.addressId = $(this).parents('.radio-box').attr("val");
                    $(this).parents('.radio-box').addClass('active').siblings().removeClass('active');
                })
            });
            $('#coupon').bind('change', function () {
                console.log($(this).val());
            })
        },
        methods: {
            async getCartList() {
                let result = await cartList({"id": this.ids});
                this.cartList = result.result;
            },
            async getAddress() {
                let result = await address();
                this.addressList = result.result;
                if (this.addressList.length > 0) {
                    this.$nextTick(function () {
                        $("#address0").addClass("active");
                        $("#radio_0").attr("checked", 'checked');
                        this.addressId = this.addressList[0].id;
                    })
                }
            },
            async pay() {
                if (this.addressId === 0) {
                    this.$Message.error("请选择收获地址！");
                    return;
                }
                let result = await order({"address_id": this.addressId, "ids": this.ids});
                if (result.status === 1) {
                    this.$Message.success(result.message);
                    this.$router.push("/pay?id="+result.result.id);
                } else {
                    this.$Message.error(result.message);
                }
            }
        }
    }
</script>

<style scoped>

</style>
