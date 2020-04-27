<template>
    <div>
        <!-- 顶部tab -->
        <header_></header_>
        <!-- 搜索栏 -->
        <search :text="text"></search>
        <!-- 内页导航栏 -->
        <div class="top-nav bg3">
            <div class="nav-box inner">
                <div class="all-cat">
                    <div class="title"><i class="iconfont icon-menu"></i> 全部分类</div>
                </div>
                <ul class="nva-list">
                    <a href="/">
                        <li>首页</li>
                    </a>
                </ul>
            </div>
        </div>
        <div class="content inner">
            <section class="filter-section clearfix">
                <ol class="breadcrumb">
                    <li>首页</li>
                    <li class="active" v-text="'商品搜索'"></li>
                    <li class="active" v-text="'全部'" v-if="text === ''"></li>
                    <li class="active" v-text="text" v-else></li>
                </ol>
                <div class="sort-box bgf5">
                    <div class="sort-text">排序：</div>
                    <div class="sort-text" id="orderNum" @click="changeOrderNum">销量 <i id="orderNumIcon"
                                                                                       class="iconfont"></i>
                    </div>
                    <div class="sort-text" id="orderPrice" @click="changeOrderPrice">价格 <i id="orderPriceIcon"
                                                                                           class="iconfont"></i></div>
                    <div class="sort-total pull-right">共<span v-text="total"></span>个商品</div>
                </div>
            </section>
            <section class="item-show__div clearfix">
                <div class="pull-left" style="width: 1200px;">
                    <div class="item-list__area clearfix">
                        <div class="item-card" v-for="(v,k) in result">
                            <router-link :to="'/detail?id='+v.id" class="photo">
                                <img :src="v.image"
                                     :alt="v.title"
                                     class="cover">
                                <div class="name" v-text="v.title"></div>
                            </router-link>
                            <div class="middle">
                                <div class="price">
                                    <small>￥</small>
                                    {{v.price}}
                                </div>
                                <div class="sale"><a href="">加入购物车</a></div>
                            </div>
                            <div class="buttom">
                                <div>销量 <b v-text="v.sales_count"></b></div>
                            </div>
                        </div>
                    </div>
                    <!-- 分页 -->
                    <Page :total="total" :current="pageNum" show-sizer show-total @on-page-size-change="pageSizeChange"
                          :page-size="pageSize"
                          @on-change="changePage" style="text-align: center;"></Page>
                </div>
            </section>
        </div>
        <footer_></footer_>
    </div>
</template>

<style>
    .sort-box .active {
        color: #b31e22;
    }

    .item-card {
        width: 220px;
    }
</style>
<script>
    import header_ from '../components/header_'
    import search from '../components/search'
    import footer_ from '../components/footer_'
    import {sku, categorySearch, lists} from "../lib/interface";

    export default {
        name: "category",
        components: {header_, search, footer_},
        data() {
            return {
                "text": "",
                "orderType": -1,
                "orderNum": -1,
                "orderPrice": -1,


                "pageSize": 10,
                "pageNum": 1,
                "total": 0,
                "result": []
            }
        },
        mounted() {
            $('.to-top').toTop({position: false});
            this.text = this.$route.query.text;
            console.log(this.text);
            this.getResult();
        },
        watch: {
            $route() {
                this.text = this.$route.query.text;
                this.getResult();
            },
        },
        methods: {
            changeOrderNum() {
                this.orderType = 0;
                if (this.orderNum === -1) {
                    this.orderNum = 0;
                    $("#orderNum").addClass("active");
                    $("#orderNumIcon").addClass("icon-sortUp");
                    $("#orderNumIcon").removeClass("icon-sortDown");
                } else if (this.orderNum === 0) {
                    this.orderNum = 1;
                    $("#orderNum").addClass("active");
                    $("#orderNumIcon").removeClass("icon-sortUp");
                    $("#orderNumIcon").addClass("icon-sortDown");
                } else {
                    this.orderType = -1;
                    this.orderNum = -1;
                    $("#orderNum").removeClass("active");
                    $("#orderNumIcon").removeClass("icon-sortUp");
                    $("#orderNumIcon").removeClass("icon-sortDown");
                }
                this.orderPrice = -1;
                $("#orderPrice").removeClass("active");
                $("#orderPriceIcon").removeClass("icon-sortUp");
                $("#orderPriceIcon").removeClass("icon-sortDown");
                this.getResult();
            },
            changeOrderPrice() {
                this.orderType = 1;
                if (this.orderPrice === -1) {
                    this.orderPrice = 0;
                    $("#orderPrice").addClass("active");
                    $("#orderPriceIcon").addClass("icon-sortUp");
                    $("#orderPriceIcon").removeClass("icon-sortDown");
                } else if (this.orderPrice === 0) {
                    this.orderPrice = 1;
                    $("#orderPrice").addClass("active");
                    $("#orderPriceIcon").removeClass("icon-sortUp");
                    $("#orderPriceIcon").addClass("icon-sortDown");
                } else {
                    this.orderType = -1;
                    this.orderPrice = -1;
                    $("#orderPrice").removeClass("active");
                    $("#orderPriceIcon").removeClass("icon-sortUp");
                    $("#orderPriceIcon").removeClass("icon-sortDown");
                }
                this.orderNum = -1;
                $("#orderNum").removeClass("active");
                $("#orderNumIcon").removeClass("icon-sortUp");
                $("#orderNumIcon").removeClass("icon-sortDown");
                this.getResult();
            },
            async pageSizeChange(pageSize) {
                this.pageSize = pageSize;
                this.getResult()
            },
            changePage(page) {
                this.pageNum = page;
                this.getResult()
            },
            async getResult() {
                var skuStr = "";
                if (this.color !== -1) {
                    skuStr += this.color + ","
                }
                if (this.size !== -1) {
                    skuStr += this.size + ","
                }
                if (this.price !== -1) {
                    skuStr += this.price + ","
                }
                skuStr = skuStr.substr(0, skuStr.length - 1);
                var orderTypeValue = undefined;
                var orderValue = undefined;
                if (this.orderType === -1) {
                    orderTypeValue = undefined;
                    orderValue = undefined;
                } else if (this.orderType === 1) {
                    orderTypeValue = "price";
                    if (this.orderPrice === -1) {
                        orderValue = undefined;
                    } else if (this.orderPrice === 0) {
                        orderValue = 1
                    } else {
                        orderValue = 2
                    }
                } else {
                    orderTypeValue = "sales_count";
                    if (this.orderNum === -1) {
                        orderValue = undefined;
                    } else if (this.orderNum === 0) {
                        orderValue = 1
                    } else {
                        orderValue = 2
                    }
                }
                var data = {
                    "page": this.pageNum,
                    "page_size": this.pageSize,
                    "keyword": this.text,
                };
                if (this.text === undefined || this.text == null) {
                    delete data["keyword"];
                }
                if (this.orderType !== -1) {
                    data.field = orderTypeValue;
                } else {
                    delete (data["field"])
                }
                if (this.orderType !== -1) {
                    data.order = orderValue
                } else {
                    delete ["order"]
                }
                let result = await lists(data);
                this.result = result.result.list;
                this.total = result.result.count;
            },
        }

    }
</script>

<style scoped>

</style>
