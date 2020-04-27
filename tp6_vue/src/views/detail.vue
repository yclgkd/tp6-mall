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
            <section class="item-show__div item-show__head clearfix">
                <div class="pull-left">
                    <ol class="breadcrumb">
                        <li><a href="/">首页</a></li>
                        <li>
                            商品详情
                        </li>
                        <li class="active" v-text="result.title"></li>
                    </ol>
                    <div class="item-pic__box" id="magnifier">
                        <div class="small-box">
                            <img class="cover" :src="firstImg">
                            <span class="hover"></span>
                        </div>
                        <div class="thumbnail-box">
                            <div class="thumb-list">
                                <ul class="wrapper clearfix">
                                    <li v-for="(v,index) in result.image" @click="changeImg(v)" :key="index"
                                        class="item" :data-src="v"><img class="cover" :src="v"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item-info__box">
                        <div class="item-title">
                            <div class="name ep2" v-text="result.title"></div>
                        </div>
                        <div class="item-price bgf5">
                            <div class="price-box clearfix">
                                <div class="price-panel pull-left">
                                    售价：<span class="price">￥<span v-text="result.price"></span> <s
                                        class="fz16 c9">￥<span v-text="result.cost_price"></span></s></span>
                                </div>
                            </div>
                        </div>
                        <ul class="item-ind-panel clearfix">
                            <li class="item-ind-item">
                                <span class="ind-label c9">累计销量</span>
                                <span class="ind-count cr" v-text="result.sales_count"></span>
                            </li>
                        </ul>
                        <div class="item-key">
                            <div class="item-sku">
                                <dl class="item-prop clearfix" v-for="(v,k) in result.sku">
                                    <dt class="item-metatit"><span v-text="v.name"></span>：</dt>
                                    <dd>
                                        <ul :data-property="v.name" class="clearfix">
                                            <li v-for="(v1,k1) in v.list">
                                                <a @click="chooseSku(k,k1)" v-if="v1.flag == 1" :class="'sku on sku_'+k"
                                                   :id="'sku_'+k+'_'+k1"
                                                   role="button"
                                                   :data-value="v1.id"
                                                   aria-disabled="true">
                                                    <span v-text="v1.name"></span>
                                                </a>
                                                <a @click="chooseSku(k,k1)" v-if="v1.flag == 0" :class="'sku sku_'+k"
                                                   :id="'sku_'+k+'_'+k1"
                                                   role="button" :data-value="v1.id"
                                                   aria-disabled="true">
                                                    <span v-text="v1.name"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                            <div class="item-amount clearfix bgf5">
                                <div class="item-metatit">数量：</div>
                                <div class="amount-box">
                                    <div class="amount-widget">
                                        <input class="amount-input" value="1" maxlength="8" title="请输入购买量" type="text">
                                        <div class="amount-btn">
                                            <a class="amount-but add"></a>
                                            <a class="amount-but sub"></a>
                                        </div>
                                    </div>
                                    <div class="item-stock"><span style="margin-left: 10px;">库存
                                        <b id="Stock" v-text="result.stock"></b> 件</span>
                                    </div>
                                </div>
                            </div>
                            <div class="item-action clearfix bgf5">
                                <a v-if="result.stock <= 0" disabled="disabled"
                                   style="float: left;background: gray;border: gray" rel="nofollow"
                                   data-addfastbuy="true" role="button"
                                   class="item-action__basket">
                                    <i class="iconfont icon-shopcart"></i> 加入购物车
                                </a>
                                <a v-else @click="addCart"
                                   style="float: left;" rel="nofollow"
                                   data-addfastbuy="true" role="button"
                                   class="item-action__basket">
                                    <i class="iconfont icon-shopcart"></i> 加入购物车
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pull-right picked-div">
                    <div class="lace-title">
                        <span class="c6">爆款推荐</span>
                    </div>
                    <div class="swiper-container picked-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <router-link class="picked-item" :to="'/detail?id='+v.id" v-for="(v,k) in recommend">
                                    <img :src="v.image" alt="" class="cover">
                                    <div class="look_price">¥<span v-text="v.price"></span></div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="item-show__div item-show__body posr clearfix">
                <div class="item-nav-tabs">
                    <ul class="nav-tabs nav-pills clearfix" role="tablist" id="item-tabs">
                        <li role="presentation" class="active"><a href="#detail" role="tab" data-toggle="tab"
                                                                  aria-controls="detail" aria-expanded="true">商品详情</a>
                        </li>
                    </ul>
                </div>
                <div class="pull-left">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="detail" aria-labelledby="detail-tab">
                            <div class="item-detail__info clearfix">
                                <div class="record">商品编号：<span v-if="result && result.detail"
                                                               v-text="result.detail.d1.商品编号"></span>
                                </div>
                                <div class="record">上架时间：<span v-if="result && result.detail"
                                                               v-text="result.detail.d1.上架时间"></span>
                                </div>
                                <div class="record">商品毛重：<span v-if="result && result.detail"
                                                               v-text="result.detail.d1.商品毛重"></span>
                                </div>
                                <div class="record">商品库存：<span v-if="result && result.detail"
                                                               v-text="result.detail.d1.商品库存"></span>
                                </div>
                            </div>
                            <div class="rich-text">
                                <p style="text-align: center;" v-if="result && result.detail"
                                   v-html="result.detail.d2"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="tab-content" id="descCate">
                        <div role="tabpanel" class="tab-pane fade in active" id="detail-tab"
                             aria-labelledby="detail-tab">
                            <div class="descCate-content bgf5">
                                <dd class="dc-idsItem selected">
                                    <a href="#desc-module-1"><i class="iconfont icon-dot"></i> 产品图</a>
                                </dd>
                                <dd class="dc-idsItem">
                                    <a href="#desc-module-2"><i class="iconfont icon-selected"></i> 细节图</a>
                                </dd>
                                <dd class="dc-idsItem">
                                    <a href="#desc-module-3"><i class="iconfont"></i> 尺寸及试穿</a>
                                </dd>
                                <dd class="dc-idsItem">
                                    <a href="#desc-module-4"><i class="iconfont"></i> 模特效果图</a>
                                </dd>
                                <dd class="dc-idsItem">
                                    <a href="#desc-module-5"><i class="iconfont"></i> 常见问题</a>
                                </dd>
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
    import "@/assets/js/jquery.zoom.js"
    import "@/assets/js/jquery.magnifier.js"
    import "@/assets/js/jquery.magnifier.js"
    import "@/assets/js/jquery.zoom.js"
    import header_ from '../components/header_'
    import search from '../components/search'
    import footer_ from '../components/footer_'
    import {detail, recommend, addCart} from "../lib/interface";

    export default {
        components: {header_, search, footer_},
        name: "detail",
        data() {
            return {
                id: 0,
                result: {},
                recommend: [],
                firstImg: "",
            }
        },
        watch: {
            $route() {
                this.id = this.$route.query.id;
                this.getResult();
            },
        },
        mounted() {
            this.id = this.$route.query.id;
            this.getResult();
            this.getRecommendInfo();

            $('#descCate').smartFloat(0);
            $('.dc-idsItem').click(function () {
                $(this).addClass('selected').siblings().removeClass('selected');
            });
            $('#item-tabs a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                $('#descCate #' + $(e.target).attr('aria-controls') + '-tab')
                    .addClass('in').addClass('active').siblings()
                    .removeClass('in').removeClass('active');
            });
            $('#magnifier').magnifier();
            $('.vip-price-panel').click(function () {
                if ($(this).hasClass('active')) {
                    $('.all-price__box').stop().slideUp('normal', function () {
                        $('.vip-price-panel').removeClass('active').find('.iconfont').removeClass('icon-up').addClass('icon-down');
                    });
                } else {
                    $(this).addClass('active').find('.iconfont').removeClass('icon-down').addClass('icon-up');
                    $('.all-price__box').stop().slideDown('normal');
                }
            });
            $('.amount-input').onlyReg({reg: /[^0-9]/g});
            var that = this;
            $('.amount-widget').on('click', '.amount-but', function () {
                var num = parseInt($('.amount-input').val());
                if (!num) num = 0;
                if ($(this).hasClass('add')) {
                    if (num > that.result.stock - 1) {
                        return DJMask.open({
                            width: "300px",
                            height: "100px",
                            content: "您输入的数量超过库存上限"
                        });
                    }
                    $('.amount-input').val(num + 1);
                } else if ($(this).hasClass('sub')) {
                    if (num == 1) {
                        return DJMask.open({
                            width: "300px",
                            height: "100px",
                            content: "您输入的数量有误"
                        });
                    }
                    $('.amount-input').val(num - 1);
                }
            });
        },
        methods: {
            async getResult() {
                let result = await detail({"id": this.id});
                this.result = result.result;
                if (result.status === 0) {
                    this.$router.replace("/");
                    return;
                }
                this.firstImg = this.result.image[0];
            },
            async chooseSku(k, k1) {
                $(".sku_" + k).removeClass("on");
                $("#sku_" + k + "_" + k1).addClass("on");
                var ids = "";
                $(".sku").each(function (item) {
                    if ($(this).hasClass("on")) {
                        ids += $(this).attr("data-value") + ",";
                    }
                })
                ids = ids.substr(0, ids.length - 1);
                var id = 0;
                for (k in this.result.gids) {
                    if (k === ids) {
                        id = this.result.gids[k];
                    }
                }
                this.id = id;
                this.getResult();
            },
            async addCart() {
                var token = localStorage.getItem("token");
                if (token === undefined || token === null) {
                    this.$router.replace({
                        name: "login",
                        query: {redirect: this.$route.fullPath}
                    });
                    return;
                }
                var num = parseInt($('.amount-input').val());
                if (num > this.result.stock) {
                    this.$Message.error("超出最大库存！");
                    $('.amount-input').val(0);
                    return;
                }
                let result = await addCart({"id": this.id, "num": num});
                this.$Message.success(result.message);
            },
            async getRecommendInfo() {
                let result = await recommend();
                this.recommend = result.result;
            },
            changeImg(img) {
                this.firstImg = img;
            }
        }
    }
</script>

<style scoped>

</style>
