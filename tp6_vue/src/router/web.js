export default [
    {
        //登录
        path: '/login',
        name: 'login',
        meta: {
            title: '登录',
        },
        component: () => import('../views/login.vue'),
    },
    {
        //首页
        path: '/',
        name: 'index',
        meta: {
            title: '首页',
            // auth: 'login'
        },
        component: () => import('../views/index.vue'),
    },
    {
        //分类商品
        path: '/category',
        name: 'category',
        meta: {
            title: '分类商品',
            // auth: 'login'
        },
        component: () => import('../views/category.vue'),
    },
    {
        //分类商品
        path: '/search',
        name: 'search',
        meta: {
            title: '商品搜索',
            // auth: 'login'
        },
        component: () => import('../views/search.vue'),
    }
    ,
    {
        //商品详情
        path: '/detail',
        name: 'detail',
        meta: {
            title: '商品详情',
            // auth: 'login'
        },
        component: () => import('../views/detail.vue'),
    }
    ,
    {
        //购物车
        path: '/cart',
        name: 'cart',
        meta: {
            title: '购物车',
            auth: 'login'
        },
        component: () => import('../views/cart.vue'),
    }
    ,
    {
        //订单确认
        path: '/order',
        name: 'order',
        meta: {
            title: '订单确认',
            auth: 'login'
        },
        component: () => import('../views/order.vue'),
    }
    ,
    {
        //订单支付
        path: '/pay',
        name: 'pay',
        meta: {
            title: '订单支付',
            auth: 'login'
        },
        component: () => import('../views/pay.vue'),
    }
    ,
    {
        //个人资料
        path: '/mine/set',
        name: 'mine-set',
        meta: {
            title: '个人资料',
            auth: 'login'
        },
        component: () => import('../views/mine/set.vue'),
    }
    ,
    {
        //我的订单
        path: '/mine/order',
        name: 'mine-order',
        meta: {
            title: '我的订单',
            auth: 'login'
        },
        component: () => import('../views/mine/order.vue'),
    }
    ,
    {
        //订单详情
        path: '/mine/orderdetail',
        name: 'mine-orderdetail',
        meta: {
            title: '订单详情',
            auth: 'login'
        },
        component: () => import('../views/mine/orderdetail.vue'),
    }
    ,
    {
        //收货地址
        path: '/mine/address',
        name: 'mine-address',
        meta: {
            title: '收货地址',
            auth: 'login'
        },
        component: () => import('../views/mine/address.vue'),
    }
    ,
    {
        //我的收藏
        path: '/mine/collection',
        name: 'mine-collection',
        meta: {
            title: '我的收藏',
            auth: 'login'
        },
        component: () => import('../views/mine/collection.vue'),
    },
    {
        //退货.退款
        path: '/mine/refund',
        name: 'mine-refund',
        meta: {
            title: '退货/退款',
            auth: 'login'
        },
        component: () => import('../views/mine/refund.vue'),
    },
]
