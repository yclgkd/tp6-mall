<template>
    <div class="top-search">
        <div class="inner">
            <router-link class="logo" to="/">
                <img src="@/assets/images/icons/logo.jpg" alt="TP6" class="cover">
            </router-link>
            <div class="search-box">
                <form class="input-group">
                    <input placeholder="他们都在搜Troku商城" v-model="CurText" type="text">
                    <span class="input-group-btn">
						<button type="button" @click="search">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
					</span>
                </form>
                <p class="help-block text-nowrap">
                    <router-link style="margin-left: 5px;" v-for="(v,k) in searchTopData" v-text="v"
                                 :to="'/search?text='+v"></router-link>
                </p>
            </div>
            <div class="cart-box">
                <router-link to="/cart" class="cart-but"><i class="iconfont icon-shopcart cr fz16"></i> 购物车 <span
                        v-text="cartCount"></span> 件
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import {searchTop, cartCount} from '../lib/interface'

    export default {
        name: "search",
        data() {
            return {
                CurText: '',
                searchTopData: [],
                cartCount: 0,
            }
        },
        props: {
            text: {
                type: String,
                default: ''
            }
        },
        watch: {
            text(newValue) {
                this.CurText = newValue
            }
        },
        created() {
            this.CurText = this.text;
            this.getSearchTop();
            let token = localStorage.getItem("token");
            if (token) {
                this.getCartCount();
            }
        },
        methods: {
            async getSearchTop() {
                let result = await searchTop();
                this.searchTopData = result.result;
            },
            search() {
                this.$router.push({
                    path: '/search',
                    query: {
                        text: this.CurText
                    }
                })
            },
            async getCartCount() {
                let result = await cartCount();
                this.cartCount = result.result.cart_num;
            }
        }
    }
</script>

<style scoped>

</style>
