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
                    <div class="title">购物车</div>
                </div>
            </div>
        </div>
        <div class="content clearfix bgf5">
            <section class="user-center inner clearfix">
                <div class="user-content__box clearfix bgf">
                    <div class="title">购物车</div>
                    <div class="shopcart-form__box">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="150">
                                    <label class="checked-label">
                                        <Checkbox
                                                :value="checkAll"
                                                @click.prevent.native="handleCheckAll">全选
                                        </Checkbox>
                                    </label>
                                </th>
                                <th width="300">商品信息</th>
                                <th width="150">单价</th>
                                <th width="200">数量</th>
                                <th width="200">总价</th>
                                <th width="80">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(v,k) in list">
                                <th scope="row">
                                    <label class="checked-label">
                                        <Checkbox :value="v.isCheck" @click.prevent.native="chooseCheck(k)"></Checkbox>
                                        <i></i>
                                        <div class="img"><img :src="v.image" style="width: 100px;height: 100px;" alt="" class="cover">
                                        </div>
                                    </label>
                                </th>
                                <td>
                                    <div class="name ep3" v-text="v.title"></div>
                                    <div class="type c9" v-text="v.sku"></div>
                                </td>
                                <td>¥<span v-text="v.price"></span></td>
                                <td>
                                    <div class="cart-num__box">
                                        <input type="button" class="sub" value="-" @click="changeNum(k,1)">
                                        <input type="text" class="val" :value="v.num" disabled="true" maxlength="2">
                                        <input type="button" class="add" value="+" @click="changeNum(k,2)">
                                    </div>
                                </td>
                                <td>¥<span v-text="(v.price*v.num).toFixed(2)"></span></td>
                                <td><a @click="del(k)">删除</a></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="user-form-group tags-box shopcart-submit pull-right">
                            <button type="submit" class="btn" @click="order">去结算</button>
                        </div>
                        <div class="checkbox shopcart-total">
                            <div class="pull-right">
                                已选商品 <span v-text="totalCount"></span> 件
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合计（不含运费）
                                <b class="cr">¥<span class="fz24" v-text="totalPrice"></span></b>
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
    import header_ from '../components/header_'
    import footer_ from '../components/footer_'
    import {cartList, deleteCart, updateCart} from "../lib/interface";

    export default {
        components: {header_, footer_},
        name: "cart",
        data() {
            return {
                list: [],
                checkAll: false,
                totalPrice: 0.00,
                totalCount: 0
            }
        },
        mounted() {
            $('.to-top').toTop({position: false});
            // 个数限制输入数字
            $('input.val').onlyReg({reg: /[^0-9.]/g});
            this.getTotalSum();
            this.getResult();
        },
        methods: {
            async getResult() {
                let result = await cartList();
                this.list = result.result;
                for (var i = 0; i < this.list.length; i++) {
                    this.list[i].isCheck = false;
                }
            },
            order() {
                var ids = "";
                for (var i = 0; i < this.list.length; i++) {
                    if (this.list[i].isCheck === true) {
                        ids += this.list[i].id + ",";
                    }
                }
                ids = ids.substr(0, ids.length - 1);
                if (ids.length === 0) {
                    this.$Message.error("请选择至少一件商品");
                    return;
                }
                this.$router.push("/order?ids=" + ids);
            },
            handleCheckAll() {
                if (this.checkAll) {
                    this.checkAll = false;
                    for (var i = 0; i < this.list.length; i++) {
                        this.list[i].isCheck = false
                    }
                } else {
                    this.checkAll = true;
                    for (var i = 0; i < this.list.length; i++) {
                        this.list[i].isCheck = true
                    }
                }
                this.getTotalSum();
                this.getTotalCount();
            },
            chooseCheck(index) {
                if (this.list[index].isCheck === false) {
                    this.list[index].isCheck = true;
                } else {
                    this.list[index].isCheck = false;
                }
                this.getTotalSum();
                this.getTotalCount();
                this.checkIsAll();
            },
            checkIsAll() {
                var checkAll = true;
                for (var i = 0; i < this.list.length; i++) {
                    if (this.list[i].isCheck === false) {
                        checkAll = false;
                        break;
                    }
                }
                this.checkAll = checkAll;
            },
            async del(k) {
                let id = this.list[k].id;
                let result = await deleteCart({"id": id});
                this.$Message.success(result.message);
                if (result.code === 1) {
                    this.list.splice(k, 1);
                    this.getTotalSum();
                    this.getTotalCount();
                }
            },
            async changeNum(index, t) {
                var num = 0;
                if (t === 1) { //+
                    if (this.list[index].num === 1) {
                        return;
                    }
                    num = this.list[index].num - 1;
                } else { // -
                    num = this.list[index].num + 1;
                }
                let result = await updateCart({"id": this.list[index].id, "num": num});
                if (result.status === 1) {
                    this.getTotalSum();
                    this.getTotalCount();
                    if (t === 1) { //+
                        this.list[index].num = this.list[index].num - 1;
                    } else { // -
                        this.list[index].num = this.list[index].num + 1;
                    }
                } else {
                    this.$Message.error(result.message);
                }
            },
            getTotalSum() {
                this.totalPrice = 0.00;
                for (var i = 0; i < this.list.length; i++) {
                    if (this.list[i].isCheck === true) {
                        this.totalPrice += this.list[i].price * this.list[i].num
                    }
                }
                this.totalPrice = this.totalPrice.toFixed(2);
                console.log(this.totalPrice);
            },
            getTotalCount() {
                this.totalCount = 0;
                for (var i = 0; i < this.list.length; i++) {
                    if (this.list[i].isCheck === true) {
                        this.totalCount += parseFloat(this.list[i].num);
                    }
                }
                console.log(this.totalCount);
            }
        }
    }
</script>

<style scoped>

</style>
