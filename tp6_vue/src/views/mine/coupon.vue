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
                        <div class="title">账户信息-积分平台</div>
                        <ul class="nav user-nav__title" role="tablist">
                            <li role="presentation" class="nav-item active"><a href="#useful" aria-controls="useful" role="tab" data-toggle="tab">未使用</a></li>
                            <li role="presentation" class="nav-item "><a href="#used" aria-controls="used" role="tab" data-toggle="tab">已使用</a></li>
                            <li role="presentation" class="nav-item "><a href="#overdue" aria-controls="overdue" role="tab" data-toggle="tab">已过期</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="useful">
                                <div class="coupon-list">

                                    <div class="coupon">
                                        <div class="coupon-hd">
                                            <b><small class="fz16">¥</small>2.00</b>
                                            <div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div>
                                        </div>
                                        <div class="coupon-bd">
                                            <div class="fz12 c9">券号：70000503249136</div>
                                            <div class="fz12 c9">规则： 消费需满50元</div>
                                        </div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>

                                    <div class="coupon">
                                        <div class="coupon-hd">
                                            <b><small class="fz16">¥</small>5.00</b>
                                            <div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div>
                                        </div>
                                        <div class="coupon-bd">
                                            <div class="fz12 c9">券号：70000503249137</div>
                                            <div class="fz12 c9">规则： 消费需满60元</div>
                                        </div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>

                                    <div class="coupon">
                                        <div class="coupon-hd"><b><small class="fz16">¥</small>1.50</b><div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div></div>
                                        <div class="coupon-bd"><div class="fz12 c9">券号：70000503249137</div><div class="fz12 c9">规则： 消费需满30元</div></div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>
                                    <div class="coupon">
                                        <div class="coupon-hd"><b><small class="fz16">¥</small>1.00</b><div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div></div>
                                        <div class="coupon-bd"><div class="fz12 c9">券号：70000503249136</div><div class="fz12 c9">规则： 消费需满20元</div></div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>
                                    <div class="coupon">
                                        <div class="coupon-hd"><b><small class="fz16">¥</small>1.50</b><div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div></div>
                                        <div class="coupon-bd"><div class="fz12 c9">券号：70000503249136</div><div class="fz12 c9">规则： 消费需满25元</div></div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>
                                    <div class="coupon">
                                        <div class="coupon-hd"><b><small class="fz16">¥</small>100.00</b><div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div></div>
                                        <div class="coupon-bd"><div class="fz12 c9">券号：70000503249136</div><div class="fz12 c9">规则： 消费需满2000元</div></div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>
                                    <div class="coupon">
                                        <div class="coupon-hd"><b><small class="fz16">¥</small>150.00</b><div class="fz12">【使用期限】<br>2017.09.20至2017.12.5</div></div>
                                        <div class="coupon-bd"><div class="fz12 c9">券号：70000503249136</div><div class="fz12 c9">规则： 消费需满2500元</div></div>
                                        <a href="item_sale_page.html" class="coupon-ft">立即使用</a>
                                    </div>
                                </div>
                                <Page :total="100" show-total show-elevator show-sizer style="margin-left: 15%;" />
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

    export default {
        components: {header_, footer_, mineLeft},
        name: "mine-coupon",
        mounted() {
            $("#coupon").addClass("active");
        },
        methods: {}
    }
</script>

<style scoped>

</style>
