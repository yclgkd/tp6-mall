const path = require('path');

const resolve = dir => {
  return path.join(__dirname, dir)
};

module.exports = {
  // 如果你不需要使用eslint，把lintOnSave设为false即可
  lintOnSave: false,
  chainWebpack: config => {
    config.resolve.alias
      .set('@', resolve('src')) // src目录的映射关系
  },
  // 打包时不生成.map文件
  productionSourceMap: false,
  // 这里写你调用接口的基础路径，来解决跨域，如果设置了代理，那你本地开发环境的axios的baseUrl要写为 '' ，即空字符串
  devServer: {
    open: true,
    disableHostCheck: false,
    // 处理跨域请求
    proxy: {
      '/api': {
        target: 'http://192.168.37.6:8082/',
        ws: true,
        changeOrigin: true,
        pathRewrite: {
          '^/api': ''
        }
      }
    }
  },
};
