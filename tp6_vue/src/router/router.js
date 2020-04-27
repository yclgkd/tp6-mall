import Vue from 'vue'
import Router from 'vue-router'
import web from './web'


Vue.use(Router);

const router = new Router({
    mode: 'hash',
    routes: web
});

//beforeEach是router的钩子函数，在进入路由前执行
router.beforeEach((to, from, next) => {
    // eslint-disable-next-line no-console
    console.log("路由执行前");
    if (to.meta.title) {//判断是否有标题
        document.title = to.meta.title
    }
    console.log(to.meta);
    if (to.meta.auth === 'login') {
        let token = localStorage.getItem("token");
        console.log("这里是token:" + token);
        if (token === undefined || token === '' || token == null) {
            // localStorage.setItem("loginUrl", to.fullPath);
            router.replace({
                name: "login",
                query: {redirect: to.fullPath}
            })
            // next({
            //     path: '/login'
            // })
        }
    }
    next();
});
//路由后执行
router.afterEach((to, from) => {
    console.log("路由执行后")
});

export default router
