
// 获取图片
function images(ele='banner_img') {
    let imgs = $('#'+ele).find('img');
    let imgSrc = '';
    imgs.each(function (index,item) {
        imgSrc += $(item).attr('src') + ','
    })
    return imgSrc.slice(0,-1)
}
function skus() {
    // let tabTitles = ['color', 'size', 'version', 'price', 'store'];
    // let arrJson = []
    let alreadySetSkuVals = [];
    //获取设置的SKU属性值
    $("tr[class*='sku_table_tr']").each(function (i, item) {
        let newObj = {}
        var skuSellPrice = $(this).find("input[type='text'][class*='setting_sell_sku_price']").val() || 0;//SKU销售价格
        var skuMarketPrice = $(this).find("input[type='text'][class*='setting_market_sku_price']").val() || 0;//SKU销售价格
        var skuStock = $(this).find("input[type='text'][class*='setting_sku_stock']").val() || 0;//SKU库存
        // if(skuPrice || skuStock){//已经设置了全部或部分值
        let propvalids = $(this).attr('propvalids')// 31,13,22
        let propvalnames = $(this).attr('propvalnames') // 土豪金;64G;港版

        let names = propvalnames.split(';')
        for (let j = 0; j < names.length; j++) {
            // newObj[tabTitles[j]] = names[j]
            newObj[j] = names[j]
        }
        newObj[names.length] = skuSellPrice
        newObj[names.length + 1] = skuStock
        newObj[names.length + 2] = skuMarketPrice
        newObj['propvalnames'] = {propvalids, skuSellPrice, skuMarketPrice, skuStock}
        alreadySetSkuVals.push(newObj)
    });
    return alreadySetSkuVals
    // getAlreadySetSkuVals();//获取已经设置的SKU值
}

