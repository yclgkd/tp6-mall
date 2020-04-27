<template>
    <div>
        <!-- 顶部tab -->
        <header_></header_>
        <!-- 搜索栏 -->
        <search></search>
        <!-- 首页导航栏 -->
        <div class="top-nav bg3">
            <div class="nav-box inner">
                <div class="all-cat">
                    <div class="title"><i class="iconfont icon-menu"></i> 全部分类</div>

                    <div class="cat-list__box">
                        <div class="cat-box" v-for="(v,k) in categoryInfo">
                            <div class="title">
                                <i class="iconfont icon-skirt ce"></i>
                                <span v-text="v.name" @click="category(v.category_id)"></span>
                            </div>
                            <ul class="cat-list clearfix">
                                <li @click="category(v1.category_id)" v-for="(v1,k1) in v.list" v-text="v1.name"></li>
                            </ul>
                            <div class="cat-list__deploy">
                                <div class="deploy-box">
                                    <div class="genre-box clearfix" v-for="(v1,k1) in v.list">
                                        <span class="title"><span v-text="v1.name"></span>：</span>
                                        <div class="genre-list">
                                            <a @click="category(v2.category_id)" v-for="(v2,k2) in v1.list"
                                               v-text="v2.name"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nva-list">
                    <a href="/">
                        <li class="active">首页</li>
                    </a>
                </ul>
            </div>
        </div>
        <!-- 顶部轮播 -->
        <div class="swiper-container banner-box">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="(v,k) in  bannerInfo">
                    <router-link :to="'/detail?id='+v.id">
                        <img :src="v.image"
                             class="cover">
                    </router-link>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="content inner" style="margin-bottom: 40px;">
            <section v-for="(v,k) in goodsInfo" :class="[k % 2 == 0?'floor-2':'floor-3','scroll-floor']">
                <div class="floor-title">
                    <i class="iconfont icon-skirt fz16"></i><span v-text="v.categories.name"></span>
                    <div class="case-list fz0 pull-right">
                        <a v-for="(v1,k1) in v.categories.list" v-text="v1.name"></a>
                    </div>
                </div>
                <div class="con-box">
                    <div class="right-box">
                        <router-link :to="'/detail?id='+v1.id" class="floor-item" v-for="(v1,k1) in v.goods">
                            <div class="item-img hot-img">
                                <img :src="v1.image" class="cover">
                            </div>
                            <div class="price clearfix">
                                <span class="pull-left cr fz16" v-text="'￥'+v1.price"></span>
                                <span class="pull-right c6">价格</span>
                            </div>
                            <div class="name ep" v-text="v1.title"></div>
                        </router-link>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    import header_ from '../components/header_'
    import search from '../components/search'
    import {category, banner, goodsRecommend} from "../lib/interface";

    export default {
        components: {header_, search},
        name: "index",
        data() {
            return {
                categoryInfo: [],
                bannerInfo: [],
                isShow: 0,
                goodsInfo: [],
            }
        },
        mounted() {
            this.$nextTick(function () {
                this.isShow = 1;
                setTimeout(function () {
                    var banner_swiper = new Swiper('.banner-box', {
                        autoplayDisableOnInteraction: false,
                        pagination: '.banner-box .swiper-pagination',
                        paginationClickable: true,
                        autoplay: 5000,
                    });
                    // 新闻列表滚动
                    var notice_swiper = new Swiper('.notice-box .swiper-container', {
                        paginationClickable: true,
                        mousewheelControl: true,
                        direction: 'vertical',
                        slidesPerView: 10,
                        autoplay: 2e3,
                    });
                }, 2000);
            });
            this.getCategoryInfo();
            this.getBannerInfo();
            this.getGoodsInfo();
        },
        methods: {
            category(id) {
                this.$router.replace("/category?cid=" + id);
            },
            async getCategoryInfo() {
                let result = await category();
                this.categoryInfo = result.result;
                console.log(this.categoryInfo);
            },
            async getBannerInfo() {
                let result = await banner();
                this.bannerInfo = result.result;
            },
            async getGoodsInfo() {
                let result = await goodsRecommend();
                this.goodsInfo = result.result;
                console.log(result);
            }

        }
    }
</script>

<style scoped>

</style>
