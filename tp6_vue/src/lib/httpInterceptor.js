/**
 * axios拦截器
 */
import axios from 'axios'
import router from '../router/router'
// 超时时间
axios.defaults.timeout = 10000;
// http request 请求拦截器，有token值则配置上token值

axios.interceptors.request.use(
    config => {
        let token = localStorage.getItem("token");
        if (token) {  // 每次发送请求之前判断是否存在token，如果存在，则统一在http请求的header都加上token，不用每次请求都手动添加了
            config.headers['Access-Token'] = token;
        }
        return config;
    },
    err => {
        //alert("当前发出的网络请求出现了致命的错误");
        return Promise.reject(err);
    });

// http response 服务器响应拦截器，这里拦截401错误，并重新跳入登页重新获取token
axios.interceptors.response.use(
    response => {
        console.log(response);
        console.log(response.data.status);
        switch (response.data.status) {
            case -1:
                localStorage.removeItem("token");
                localStorage.removeItem("username");
                router.replace({
                    path: '/',
                });
                break;
            default:
                return response;
        }
    },
    error => {
        console.log(error);
        //alert( "服务器的返回值出现错误！请检查","error");
        // return Promise.reject(error.response.data)
    });
