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
                        <div class="title">账户信息-收货地址</div>
                        <form action="" class="user-addr__form form-horizontal" role="form">
                            <p class="fz18 cr">新增收货地址<span class="c6"
                                                           style="margin-left: 20px">电话号码、手机号码选填一项，其余均为必填项</span></p>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">收货人姓名：</label>
                                <div class="col-sm-6">
                                    <!--                                    <input class="form-control" id="name" placeholder="请输入姓名" type="text">-->
                                    <Input v-model="value" id="name" placeholder="请输入姓名..."
                                           style="width: 300px"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="details" class="col-sm-2 control-label">收货地址：</label>
                                <div class="col-sm-10">
                                    <div class="addr-linkage">
<!--                                        <Cascader :data="data" v-model="value2"></Cascader>-->
                                        <Cascader :data="data" v-model="value1"></Cascader>
                                    </div>
                                    <input class="form-control" id="details" placeholder="建议您如实填写详细收货地址，例如街道名称，门牌号码等信息"
                                           maxlength="30" type="text">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">地区编码：</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="code" placeholder="请输入邮政编码" type="text">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="mobile" class="col-sm-2 control-label">手机号码：</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="mobile" placeholder="请输入手机号码" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">电话号码：</label>
                                <div class="col-sm-6">
                                    <input class="form-control" id="phone" placeholder="请输入电话号码" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="checkbox">
                                        <label><input type="checkbox"><i></i> 设为默认收货地址</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <button type="submit" class="but">保存</button>
                                </div>
                            </div>
                        </form>
                        <p class="fz18 cr">已保存的有效地址</p>
                        <div class="table-thead addr-thead">
                            <div class="tdf1">收货人</div>
                            <div class="tdf2">所在地</div>
                            <div class="tdf3">
                                <div class="tdt-a_l">详细地址</div>
                            </div>
                            <!-- <div class="tdf1">邮编</div> -->
                            <div class="tdf1">电话/手机</div>
                            <div class="tdf1">操作</div>
                            <div class="tdf1"></div>
                        </div>
                        <div class="addr-list">
                            <div class="addr-item">
                                <div class="tdf1">喵喵喵</div>
                                <div class="tdf2 tdt-a_l">福建省 福州市 晋安区</div>
                                <div class="tdf3 tdt-a_l">浦下村74号</div>
                                <!-- <div class="tdf1">350111</div> -->
                                <div class="tdf1">153****7649</div>
                                <div class="tdf1 order">
                                    <a href="udai_address_edit.html">修改</a><a href="">删除</a>
                                </div>
                                <div class="tdf1">
                                    <a href="" class="default active">默认地址</a>
                                </div>
                            </div>
                            <div class="addr-item">
                                <div class="tdf1">喵污喵⑤</div>
                                <div class="tdf2 tdt-a_l">福建省 福州市 仓山区 建新镇</div>
                                <div class="tdf3 tdt-a_l">建新中心小学</div>
                                <!-- <div class="tdf1">350104</div> -->
                                <div class="tdf1">153****7649</div>
                                <div class="tdf1 order">
                                    <a href="udai_address_edit.html">修改</a><a href="">删除</a>
                                </div>
                                <div class="tdf1">
                                    <a href="" class="default">设为默认</a>
                                </div>
                            </div>
                            <div class="addr-item">
                                <div class="tdf1">taroxd</div>
                                <div class="tdf2 tdt-a_l">福建省 福州市 鼓楼区 鼓东街道</div>
                                <div class="tdf3 tdt-a_l">世界金龙大厦20层B北 福州腾讯企点运营中心</div>
                                <!-- <div class="tdf1">350104</div> -->
                                <div class="tdf1">153****7649</div>
                                <div class="tdf1 order">
                                    <a href="udai_address_edit.html">修改</a><a href="">删除</a>
                                </div>
                                <div class="tdf1">
                                    <a href="" class="default">设为默认</a>
                                </div>
                            </div>
                            <div class="addr-item">
                                <div class="tdf1">VIPArcher</div>
                                <div class="tdf2 tdt-a_l">福建省 福州市 仓山区 建新镇</div>
                                <div class="tdf3 tdt-a_l">详细地址</div>
                                <!-- <div class="tdf1">350104</div> -->
                                <div class="tdf1">153****7649</div>
                                <div class="tdf1 order">
                                    <a href="udai_address_edit.html">修改</a><a href="">删除</a>
                                </div>
                                <div class="tdf1">
                                    <a href="" class="default">设为默认</a>
                                </div>
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
        name: "mine-address",
        data() {
            return {
                value: "",
                value1: [],
                value2: [],
                data: [{
                    value: 'beijing',
                    label: '北京',
                    children: [
                        {
                            value: 'gugong',
                            label: '故宫'
                        },
                        {
                            value: 'tiantan',
                            label: '天坛'
                        },
                        {
                            value: 'wangfujing',
                            label: '王府井'
                        }
                    ]
                }, {
                    value: 'jiangsu',
                    label: '江苏',
                    children: [
                        {
                            value: 'nanjing',
                            label: '南京',
                            children: [
                                {
                                    value: 'fuzimiao',
                                    label: '夫子庙',
                                }
                            ]
                        },
                        {
                            value: 'suzhou',
                            label: '苏州',
                            children: [
                                {
                                    value: 'zhuozhengyuan',
                                    label: '拙政园',
                                },
                                {
                                    value: 'shizilin',
                                    label: '狮子林',
                                }
                            ]
                        }
                    ],
                }]
            }
        },
        mounted() {
            $("#address").addClass("active");
        },
        methods: {}
    }
</script>

<style scoped>

</style>
