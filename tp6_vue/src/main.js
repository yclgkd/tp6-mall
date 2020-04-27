import Vue from 'vue'
import App from './App.vue'
import router from './router/router'
import iView from 'iview'
import store from './store'
import './lib/httpInterceptor'
import './lib/jquery-vender.js'
import './lib/http'

// js文件
import 'bootstrap/dist/js/bootstrap.min'
import './assets/js/swiper.min'
import './assets/js/global'
import './assets/js/jquery.DJMask.2.1.1'
import './assets/js/swiper.min'


//-------------css文件
import 'iview/dist/styles/iview.css';
import './assets/css/iconfont.css'
import './assets/css/global.css'
import './assets/css/bootstrap.min.css'
// import 'bootstrap/dist/css/bootstrap.min.css'
import 'swiper/dist/css/swiper.min.css'

import './assets/css/bootstrap-theme.min.css'
// import './assets/css/swiper.min.css'
import './assets/css/styles.css'
import 'swiper/dist/js/swiper.jquery.min';

Vue.use(iView, {
    transfer: true,
    size: 'large'
});
iView.Notice.config({
    top: 50,
    duration: 3
});
Vue.config.productionTip = false;

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
