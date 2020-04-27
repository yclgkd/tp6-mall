/*
 Navicat Premium Data Transfer

 Source Server         : centos8
 Source Server Type    : MySQL
 Source Server Version : 80017
 Source Host           : 192.168.37.6:3306
 Source Schema         : mall

 Target Server Type    : MySQL
 Target Server Version : 80017
 File Encoding         : 65001

 Date: 27/04/2020 17:16:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mall_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_admin_user`;
CREATE TABLE `mall_admin_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '后端用户主键ID',
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态码 1:正常，0:待审核，99:删除',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '最后登录IP',
  `operate_user` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_category
-- ----------------------------
DROP TABLE IF EXISTS `mall_category`;
CREATE TABLE `mall_category`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父类ID',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '路径 1,2,5',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `operate_user` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作人',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `listorder` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_demo
-- ----------------------------
DROP TABLE IF EXISTS `mall_demo`;
CREATE TABLE `mall_demo`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '内容',
  `category_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类id',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态0:不正常,1:正常',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `udx_title`(`title`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_goods`;
CREATE TABLE `mall_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品标题',
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品分类',
  `category_path_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '栏目ID path',
  `promotion_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品促销语',
  `goods_unit` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品单位',
  `keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `sub_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '副标题',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '库存',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '现价',
  `cost_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '原价',
  `sku_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品默认的sku_id',
  `is_show_stock` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否显示库存',
  `production_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '生产日期',
  `goods_specs_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品规则 1统一，2多规格',
  `big_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '大图',
  `recommend_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品推荐图',
  `carousel_image` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '详情页轮播图',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品详情',
  `is_index_recommend` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否首页推荐大图商品',
  `goods_specs_data` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '所有规则属性存放json',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `operate_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `listorder` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序字段',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `title`(`title`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 88 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_goods_sku
-- ----------------------------
DROP TABLE IF EXISTS `mall_goods_sku`;
CREATE TABLE `mall_goods_sku`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品Id',
  `specs_value_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '每行规则属性ID 按逗号连接',
  `price` decimal(10, 2) UNSIGNED NOT NULL COMMENT '现价',
  `cost_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '原价',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '库存',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `goods_id`(`goods_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 130 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_order
-- ----------------------------
DROP TABLE IF EXISTS `mall_order`;
CREATE TABLE `mall_order`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  `order_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `total_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '支付金额',
  `pay_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付方式',
  `logistics` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '物流名称，比如中通 申通 等信息',
  `logistics_order` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '物流订单号',
  `message` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '购买者留言信息',
  `address_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '邮寄地址',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单修改时间',
  `pay_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付时间',
  `consignment_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发货时间',
  `end_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '交易完成时间',
  `close_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '交易关闭时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1待支付;2已付款; 3已发货; 4已收货; 5已完成; 6退款退货  7已取消\n',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`, `order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `mall_order_goods`;
CREATE TABLE `mall_order_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL DEFAULT '' COMMENT '订单ID',
  `sku` varchar(100) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL DEFAULT '' COMMENT 'sku文案',
  `sku_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品skuID',
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品ID',
  `num` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数量',
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '商品单价',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品标题',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品图片',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 76 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_specs_value
-- ----------------------------
DROP TABLE IF EXISTS `mall_specs_value`;
CREATE TABLE `mall_specs_value`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `specs_id` int(10) UNSIGNED NOT NULL COMMENT '规格ID',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规格属性名',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `operate_user` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `specs_id`(`specs_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mall_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_user`;
CREATE TABLE `mall_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `phone_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `ltype` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录方式 默认：0手机号码登录 1用户名密码登录',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '会话保存天数',
  `sex` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `operate_user` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `phone_number`(`phone_number`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
