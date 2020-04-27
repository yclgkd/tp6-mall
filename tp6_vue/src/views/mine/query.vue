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
                    <div class="title">个人中心</div>
                </div>
            </div>
        </div>
        <div class="content clearfix bgf5">
            <section class="user-center inner clearfix">
                <mine-left></mine-left>
                <div class="pull-right">
                    <div class="user-content__box clearfix bgf">
                        <div class="title">账户信息-物流查询</div>
                        <form action="" class="user-addr__form form-horizontal" role="form">
                            <div class="input-group col-sm-6">
                                <input class="form-control" placeholder="快递单号" type="text">
                                <span class="input-group-btn">
								<button class="btn btn-primary" type="button">查询</button>
							</span>
                            </div>
                            <div class="help-block">例如，您可以输入：<span class="cr">40105060123</span></div>
                            <div class="query-result__box"></div>
                        </form>
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

    export default {
        components: {header_, footer_, mineLeft},
        name: "center",
        mounted() {
            $("#query").addClass("active");
            var recommends = new Swiper('.recommends-swiper', {
                spaceBetween: 40,
                autoplay: 5000,
            });
            $('.to-top').toTop({position: false})
            $('.btn-primary').on('click', function () {
                if ($('.form-control').val() == '40105060123') {
                    $('.query-result__box').html('成功查询到数据，返回个html/json在这里展示！');
                } else {
                    $('.query-result__box').html(`
											<div class="no-date">
												<p class="cr">很抱歉，您的快递单号暂时没有查询结果！</p>
												<p class="fz12 c6">您可以检查下快递单号是否正确</p>
											</div>
										`);
                }
            });
        },
        methods: {}
    }
</script>

<style scoped>

</style>
