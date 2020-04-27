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
                    <div class="user-content__box clearfix bgf" style="min-height:700px;">
                        <div class="title">账户信息-个人资料</div>
                        <!--                        <div class="port b-r50" id="crop-avatar">-->
                        <!--                            <div class="img"><img src="@/assets/images/icons/default_avt.png" class="cover b-r50">-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <form action="" class="user-setting__form" role="form">
                            <div class="user-form-group">
                                <label for="user-id">用户名：</label>
                                <Input v-model="username" id="user-id" placeholder="请输入用户名"
                                       style="width: 300px"/>
                            </div>
                            <div class="user-form-group">
                                <label>性别：</label>
                                <RadioGroup v-model="sex">
                                    <Radio label="1">
                                        <span>男</span>
                                    </Radio>
                                    <Radio label="2">
                                        <span>女</span>
                                    </Radio>
                                    <Radio label="0">
                                        <span>保密</span>
                                    </Radio>
                                </RadioGroup>
                            </div>
                            <div class="user-form-group">
                                <button type="button" class="btn" @click="ok()">确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <!-- 头像选择模态框 -->
        <footer_></footer_>
    </div>
</template>
<script>
    import header_ from '../../components/header_'
    import footer_ from '../../components/footer_'
    import mineLeft from '../../components/mine_left'
    import "@/assets/js/cropper/cropper.min.js"
    import "@/assets/js/cropper/sitelogo.js"
    import {user, updateUser} from "../../lib/interface";

    export default {
        components: {header_, footer_, mineLeft},
        name: "set",
        data() {
            return {
                username: "",
                sex: "1",
            }
        },
        mounted() {
            $("#set").addClass("active");
            $('.to-top').toTop({position: false});
            this.getUser();
        },
        methods: {
            async getUser() {
                let result = await user();
                this.username = result.result.username;
                this.sex = result.result.sex.toString();
                console.log(result);
            },
            async ok() {
                if (this.username === "") {
                    this.$Message.error('请输入用户名！');
                    return;
                }
                let result = await updateUser({"username": this.username, "sex": this.sex});
                this.$Message.success(result.message);
                if (result.status === 1) {
                    localStorage.setItem("username", this.username);
                    location.reload();
                }
            }
        }
    }
</script>

<style scoped>
    /*!
     * Cropper v0.9.1
     * https://github.com/fengyuanchen/cropper
     *
     * Copyright (c) 2014-2015 Fengyuan Chen and contributors
     * Released under the MIT license
     *
     * Date: 2015-03-21T04:58:27.265Z
     */
    .cropper-container {
        position: relative;
        overflow: hidden;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        -webkit-touch-callout: none
    }

    .cropper-container img {
        display: block;
        width: 100%;
        min-width: 0 !important;
        max-width: none !important;
        height: 100%;
        min-height: 0 !important;
        max-height: none !important;
        image-orientation: 0deg !important
    }

    .cropper-canvas, .cropper-crop-box, .cropper-drag-box, .cropper-modal {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0
    }

    .cropper-drag-box {
        background-color: #fff;
        filter: alpha(opacity=0);
        opacity: 0
    }

    .cropper-modal {
        background-color: #000;
        filter: alpha(opacity=50);
        opacity: .5
    }

    .cropper-view-box {
        display: block;
        width: 100%;
        height: 100%;
        overflow: hidden;
        outline: #69f solid 1px;
        outline-color: rgba(102, 153, 255, .75)
    }

    .cropper-dashed {
        position: absolute;
        display: block;
        filter: alpha(opacity=50);
        border: 0 dashed #fff;
        opacity: .5
    }

    .cropper-dashed.dashed-h {
        top: 33.33333333%;
        left: 0;
        width: 100%;
        height: 33.33333333%;
        border-top-width: 1px;
        border-bottom-width: 1px
    }

    .cropper-dashed.dashed-v {
        top: 0;
        left: 33.33333333%;
        width: 33.33333333%;
        height: 100%;
        border-right-width: 1px;
        border-left-width: 1px
    }

    .cropper-face, .cropper-line, .cropper-point {
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        filter: alpha(opacity=10);
        opacity: .1
    }

    .cropper-face {
        top: 0;
        left: 0;
        cursor: move;
        background-color: #fff
    }

    .cropper-line {
        background-color: #69f
    }

    .cropper-line.line-e {
        top: 0;
        right: -3px;
        width: 5px;
        cursor: e-resize
    }

    .cropper-line.line-n {
        top: -3px;
        left: 0;
        height: 5px;
        cursor: n-resize
    }

    .cropper-line.line-w {
        top: 0;
        left: -3px;
        width: 5px;
        cursor: w-resize
    }

    .cropper-line.line-s {
        bottom: -3px;
        left: 0;
        height: 5px;
        cursor: s-resize
    }

    .cropper-point {
        width: 5px;
        height: 5px;
        background-color: #69f;
        filter: alpha(opacity=75);
        opacity: .75
    }

    .cropper-point.point-e {
        top: 50%;
        right: -3px;
        margin-top: -3px;
        cursor: e-resize
    }

    .cropper-point.point-n {
        top: -3px;
        left: 50%;
        margin-left: -3px;
        cursor: n-resize
    }

    .cropper-point.point-w {
        top: 50%;
        left: -3px;
        margin-top: -3px;
        cursor: w-resize
    }

    .cropper-point.point-s {
        bottom: -3px;
        left: 50%;
        margin-left: -3px;
        cursor: s-resize
    }

    .cropper-point.point-ne {
        top: -3px;
        right: -3px;
        cursor: ne-resize
    }

    .cropper-point.point-nw {
        top: -3px;
        left: -3px;
        cursor: nw-resize
    }

    .cropper-point.point-sw {
        bottom: -3px;
        left: -3px;
        cursor: sw-resize
    }

    .cropper-point.point-se {
        right: -3px;
        bottom: -3px;
        width: 20px;
        height: 20px;
        cursor: se-resize;
        filter: alpha(opacity=100);
        opacity: 1
    }

    .cropper-point.point-se:before {
        position: absolute;
        right: -50%;
        bottom: -50%;
        display: block;
        width: 200%;
        height: 200%;
        content: " ";
        background-color: #69f;
        filter: alpha(opacity=0);
        opacity: 0
    }

    @media (min-width: 768px) {
        .cropper-point.point-se {
            width: 15px;
            height: 15px
        }
    }

    @media (min-width: 992px) {
        .cropper-point.point-se {
            width: 10px;
            height: 10px
        }
    }

    @media (min-width: 1200px) {
        .cropper-point.point-se {
            width: 5px;
            height: 5px;
            filter: alpha(opacity=75);
            opacity: .75
        }
    }

    .cropper-bg {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAA3NCSVQICAjb4U/gAAAABlBMVEXMzMz////TjRV2AAAACXBIWXMAAArrAAAK6wGCiw1aAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABFJREFUCJlj+M/AgBVhF/0PAH6/D/HkDxOGAAAAAElFTkSuQmCC)
    }

    .cropper-invisible {
        filter: alpha(opacity=0);
        opacity: 0
    }

    .cropper-hide {
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1;
        width: auto !important;
        min-width: 0 !important;
        max-width: none !important;
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        filter: alpha(opacity=0);
        opacity: 0
    }

    .cropper-hidden {
        display: none !important
    }

    .cropper-move {
        cursor: move
    }

    .cropper-crop {
        cursor: crosshair
    }

    .cropper-disabled .cropper-canvas, .cropper-disabled .cropper-face, .cropper-disabled .cropper-line, .cropper-disabled .cropper-point {
        cursor: not-allowed
    }

    .avatar-view {
        display: block;
        width: 220px;
        height: 220px;
        border: 3px solid #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, .15);
        cursor: pointer;
        overflow: hidden;
    }

    .avatar-view img {
        width: 100%;
    }

    .avatar-body {
        padding-right: 15px;
        padding-left: 15px;
    }

    .avatar-upload {
        overflow: hidden;
    }

    .avatar-upload label {
        display: block;
        float: left;
        clear: left;
        width: 100px;
    }

    .avatar-upload input {
        display: block;
        margin-left: 110px;
    }

    .avater-alert {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .avatar-wrapper {
        height: 364px;
        width: 100%;
        margin-top: 15px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, .25);
        background-color: #fcfcfc;
        overflow: hidden;
    }

    .avatar-wrapper img {
        display: block;
        height: auto;
        max-width: 100%;
    }

    .avatar-preview {
        float: left;
        margin-top: 15px;
        margin-right: 15px;
        border: 1px solid #eee;
        border-radius: 4px;
        background-color: #fff;
        overflow: hidden;
    }

    .avatar-preview:hover {
        border-color: #ccf;
        box-shadow: 0 0 5px rgba(0, 0, 0, .15);
    }

    .avatar-preview img {
        width: 100%;
    }

    .preview-lg {
        height: 184px;
        width: 184px;
        margin-top: 15px;
    }

    .preview-md {
        height: 100px;
        width: 100px;
    }

    .preview-sm {
        height: 50px;
        width: 50px;
    }

    @media (min-width: 992px) {
        .avatar-preview {
            float: none;
        }
    }

    .avatar-btns {
        margin-top: 30px;
        margin-bottom: 15px;
    }

    .avatar-btns .btn-group {
        margin-right: 5px;
    }

    .loading {
        display: none;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: .75;
        filter: alpha(opacity=75);
        z-index: 20140628;
    }

    .Zebra_DatePicker_Icon_Wrapper {
        margin-left: -5px
    }

    .Zebra_DatePicker *, .Zebra_DatePicker *:after, .Zebra_DatePicker *:before {
        -moz-box-sizing: content-box !important;
        -webkit-box-sizing: content-box !important;
        box-sizing: content-box !important
    }

    .Zebra_DatePicker {
        position: absolute;
        background: #fff;
        border: 1px solid #999;
        z-index: 1200;
        padding: 5px;
        top: 0
    }

    .Zebra_DatePicker * {
        margin: 0;
        padding: 0;
        color: #373737;
        background: transparent;
        border: none
    }

    .Zebra_DatePicker table {
        border-collapse: collapse;
        border-spacing: 0;
        width: auto;
        table-layout: auto
    }

    .Zebra_DatePicker td, .Zebra_DatePicker th {
        text-align: center;
        padding: 5px 0
    }

    .Zebra_DatePicker td {
        cursor: pointer
    }

    .Zebra_DatePicker .dp_daypicker, .Zebra_DatePicker .dp_monthpicker, .Zebra_DatePicker .dp_yearpicker {
        margin-top: 3px
    }

    .Zebra_DatePicker .dp_daypicker td, .Zebra_DatePicker .dp_daypicker th, .Zebra_DatePicker .dp_monthpicker td, .Zebra_DatePicker .dp_yearpicker td {
        width: 30px
    }

    .Zebra_DatePicker, .Zebra_DatePicker .dp_header .dp_hover, .Zebra_DatePicker td.dp_selected, .Zebra_DatePicker .dp_footer .dp_hover, .Zebra_DatePicker td.dp_hover {
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px
    }

    .Zebra_DatePicker.dp_visible {
        visibility: visible;
        filter: alpha(opacity=100);
        -khtml-opacity: 1;
        -moz-opacity: 1;
        opacity: 1;
        transition: opacity .2s ease-in-out
    }

    .Zebra_DatePicker.dp_hidden {
        visibility: hidden;
        filter: alpha(opacity=0);
        -khtml-opacity: 0;
        -moz-opacity: 0;
        opacity: 0
    }

    .Zebra_DatePicker .dp_header .dp_previous, .Zebra_DatePicker .dp_header .dp_next {
        width: 30px
    }

    .Zebra_DatePicker .dp_header .dp_caption {
        font-weight: bold
    }

    .Zebra_DatePicker .dp_header .dp_hover {
        background: #dedede;
        color: #373737
    }

    .Zebra_DatePicker .dp_daypicker th {
        font-weight: bold
    }

    .Zebra_DatePicker td.dp_not_in_month {
        color: #dedede;
        cursor: default
    }

    .Zebra_DatePicker td.dp_weekend_disabled {
        color: #dedede;
        cursor: default
    }

    .Zebra_DatePicker td.dp_selected {
        background: #039;
        color: #fff !important
    }

    .Zebra_DatePicker td.dp_week_number {
        cursor: text;
        font-weight: bold
    }

    .Zebra_DatePicker .dp_monthpicker td {
        width: 33%
    }

    .Zebra_DatePicker .dp_yearpicker td {
        width: 33%
    }

    .Zebra_DatePicker .dp_footer {
        margin-top: 3px
    }

    .Zebra_DatePicker td.dp_current {
        color: #3a87ad
    }

    .Zebra_DatePicker td.dp_disabled_current {
        color: #3a87ad
    }

    .Zebra_DatePicker td.dp_disabled {
        color: #dedede;
        cursor: default
    }

    .Zebra_DatePicker td.dp_hover {
        background: #dedede
    }

    button.Zebra_DatePicker_Icon {
        display: inline-block;
        visibility: hidden;
        position: absolute
    }

    button.Zebra_DatePicker_Icon_Disabled {
        /*background-image:url('../../assets/images/calendar-disabled.png')*/
    }

    button.Zebra_DatePicker_Icon {
        margin: 0 0 0 3px
    }

    button.Zebra_DatePicker_Icon_Inside_Right {
        margin: 0 3px 0 0
    }

    button.Zebra_DatePicker_Icon_Inside_Left {
        margin: 0 0 0 3px
    }


</style>
