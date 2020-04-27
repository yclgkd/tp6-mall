import iView from "iview"
/*
ajax请求函数模块
返回值: promise对象(返回: response.data)
 */
import axios from 'axios'

export function get(url, data = {}) {
    return ajax(url, data, 'GET');
}

export function post(url, data = {}) {
    return ajax(url, data, 'POST');
}

export function put(url, data = {}) {
    return ajax(url, data, 'PUT');
}

export function ajax(url, data = {}, type = 'GET') {
    return new Promise((resolve, reject) => {
        iView.Spin.show({
            render: (h) => {
                return h('div', [
                    h('i', {
                        'class': 'demo-spin-icon-load ivu-icon ivu-icon-ios-loading',
                        style: {
                            fontSize: '64px'
                        }
                    }),
                    h('div', "加载中...")
                ])
            }
        })
        // 执行异步ajax请求
        let promise;
        if (type === 'GET') {
            // 准备url query参数数据
            let dataStr = ''; //数据拼接字符串
            Object.keys(data).forEach(key => {
                dataStr += key + '=' + data[key] + '&'
            });
            if (dataStr !== '') {
                dataStr = dataStr.substring(0, dataStr.lastIndexOf('&'));
                url = url + '?' + dataStr
            }
            // 发送get请求
            promise = axios.get(url)
        } else if (type === 'POST') {
            // 发送post请求
            promise = axios.post(url, data)
        } else {
            promise = axios.put(url, data)
        }
        promise.then(function (response) {
            iView.Spin.hide()
            // 成功了调用resolve()
            if (response) {
                resolve(response.data)
            } else {
                // alert("当前请求的返回值出现错误,请检查！", "error")
            }
        }).catch(function (error) {
            iView.Spin.hide()
            //失败了调用reject()
            reject(error)
        })
    })
}
