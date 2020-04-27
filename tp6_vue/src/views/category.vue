<template>
    <div>
        <!-- 顶部tab -->
        <header_></header_>
        <!-- 搜索栏 -->
        <search></search>
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
                    <li>商品筛选</li>
                    <li class="active" v-text="topCateName"></li>
                </ol>
                <div class="filter-box">
                    <div class="filter-prop-item">
                        <span class="filter-prop-title">二级分类：</span>
                        <ul class="clearfix">
                            <a>
                                <li class="cate2" :id="'cate2_'+k" @click="changeCate2(k)"
                                    v-for="(v,k) in categoryInfo2" :key="k" v-text="v.name"></li>
                            </a>
                        </ul>
                    </div>
                    <div class="filter-prop-item">
                        <span class="filter-prop-title">三级分类：</span>
                        <ul class="clearfix">
                            <a>
                                <li class="cate3" :id="'cate3_'+k" @click="changeCate3(k)"
                                    v-for="(v,k) in categoryInfo3" :key="k" v-text="v.name"></li>
                            </a>
                        </ul>
                    </div>
                    <div class="filter-prop-item hide" v-for="(v,k) in skuInfo">
                        <span class="filter-prop-title" v-text="v.name+'：'"></span>
                        <ul class="clearfix">
                            <a>
                                <li :class="'active '+'sku_'+k" :id="'sku_'+k+'_-1'" @click="changeSku(k,-1)">全部</li>
                            </a>
                            <a v-for="(v1,k1) in v.list">
                                <li :class="'sku_'+k" :id="'sku_'+k+'_'+k1" v-text="v1.name"
                                    @click="changeSku(k,k1)"></li>
                            </a>
                        </ul>
                    </div>
                </div>
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
                                <div class="sale"><a @click="addCart(v.id)">加入购物车</a></div>
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
    import {sku, categorySearch, lists, subcategory, addCart} from "../lib/interface";

    export default {
        name: "category",
        components: {header_, search, footer_},
        data() {
            return {
                "cid": 0,
                "skuInfo": [],
                "color": -1,
                "size": -1,
                "price": -1,
                "cate2": -1,
                "cate3": -1,
                "orderType": -1,
                "orderNum": -1,
                "orderPrice": -1,

                "topCateName": "",
                "categoryInfo": [],
                "categoryInfo2": [],
                "categoryInfo3": [],
                "cate": [],

                "pageSize": 10,
                "pageNum": 1,
                "total": 0,
                "result": []
            }
        },
        mounted() {
            $('.to-top').toTop({position: false});
            this.cid = this.$route.query.cid;
            if (!this.cid || this.cid === 0) {
                this.$router.push("/");
            }
            // this.getSku();
            this.getCategorySearch();
        },
        methods: {
            async getSku() {
                let result = await sku({"category_id": this.cid});
                this.skuInfo = result.result;
            },
            async getCategorySearch() {
                let result = await categorySearch({"id": this.cid});
                this.topCateName = result.result.name;
                this.cate = result.result.focus_ids;
                this.categoryInfo = result.result.list;
                this.categoryInfo2 = this.categoryInfo[0];
                this.categoryInfo3 = this.categoryInfo[1];

                this.$nextTick(function () {
                    if (this.cate.length >= 1) {
                        for (var i = 0; i < this.categoryInfo[0].length; i++) {
                            if (this.categoryInfo[0][i].id === this.cate[0]) {
                                this.cate2 = this.categoryInfo[0][i].id;
                                $(".cate2").removeClass("active");
                                $("#cate2_" + i).addClass("active");
                            }
                        }
                    }
                    if (this.cate.length > 1) {
                        for (var i = 0; i < this.categoryInfo[1].length; i++) {
                            if (this.categoryInfo[1][i].id === this.cate[1]) {
                                this.cate3 = this.categoryInfo[1][i].id;
                                $(".cate3").removeClass("active");
                                $("#cate3_" + i).addClass("active");
                            }
                        }
                    }
                    this.getResult();
                });
            },
            changeSku(k, k1) {
                $(".sku_" + k).removeClass("active");
                $("#sku_" + k + "_" + k1).addClass("active");
                if (k == 0) {
                    if (k1 == -1) {
                        this.color = -1
                    } else {
                        this.color = this.skuInfo[k].list[k1].id
                    }
                } else if (k == 1) {
                    if (k1 == -1) {
                        this.size = -1
                    } else {
                        this.size = this.skuInfo[k].list[k1].id
                    }
                } else {
                    if (k1 == -1) {
                        this.price = -1
                    } else {
                        this.price = this.skuInfo[k].list[k1].id
                    }
                }
                this.pageNum = 1;
                this.getResult();
            },
            changeCate2(k) {
                if (k === -1) {
                    this.cate2 = -1;
                } else {
                    this.cate2 = this.categoryInfo[0][k].id;
                    this.cid = this.cate2;
                }
                $(".cate2").removeClass("active");
                $("#cate2_" + k).addClass("active");
                this.pageNum = 1;
                this.getResult();
                if (this.cate2 !== -1) {
                    this.getSubcategory();
                }
            },
            async getSubcategory() {
                let result = await subcategory({"id": this.cate2});
                this.categoryInfo3 = result.result;
                $(".cate3").removeClass("active");
                $("#cate3_0").addClass("active");
            },
            changeCate3(k) {
                if (k === -1) {
                    this.cate3 = -1;
                } else {
                    this.cate3 = this.categoryInfo3[k].id;
                    this.cid = this.cate3;
                }
                $(".cate3").removeClass("active");
                $("#cate3_" + k).addClass("active");
                this.pageNum = 1;
                this.getResult();
            },
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
                this.pageNum = 1;
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
                this.pageNum = 1;
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
                    "category_id": this.cid,
                    // "sku_ids": skuStr,
                    "page": this.pageNum,
                    "page_size": this.pageSize,
                };
                if (this.cid === -1) {
                    delete (data["category_id"])
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
            async addCart(id) {
                var token = localStorage.getItem("token");
                if (token === undefined || token === null) {
                    this.$router.replace({
                        name: "login",
                        query: {redirect: this.$route.fullPath}
                    })
                }
                let result = await addCart({"id": id});
                this.$Message.success(result.message);
            }
        }

    }
</script>

<style scoped>

</style>
