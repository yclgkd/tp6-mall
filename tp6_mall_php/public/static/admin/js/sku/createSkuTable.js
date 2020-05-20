var alreadySetSkuVals = {};//已经设置的SKU值数据




$(function(){





	//sku属性发生改变时,进行表格创建
	$(document).on("change",'.sku_value',function(){ //所有 input
		getAlreadySetSkuVals()
		createTab()
	});
});

function createTab(type='') {

	var b = true;
	var skuTypeArr =  [];//存放SKU类型的数组
	var totalRow = 1;//总行数
	//获取元素类型
	$(".SKU_TYPE").each(function(){ // 标题  土豪金 黑色
		//SKU类型节点
		var skuTypeNode = $(this).children("li"); // 标题下 的li  遍历
		var skuTypeObj = {};//sku类型对象
		//SKU属性类型标题
		skuTypeObj.skuTypeTitle = $(skuTypeNode).attr("sku-type-name"); // li 的类 以后赋给 生成的li 对象属性

		//SKU属性类型主键

		skuTypeObj.skuTypeKey =  $(skuTypeNode).attr("propid"); // 自定义 id 值  1， 2  ， 3
		//是否是必选SKU 0：不是；1：是；
		var is_required = $(skuTypeNode).attr("is_required");
		skuValueArr = [];//存放SKU值得数组
		//SKU相对应的节点
		var skuValNode = $(this).next(); // 兄弟  节点    所有 input 节点
		//获取SKU值
		var skuValCheckBoxs = $(skuValNode).find("input[type='checkbox'][class*='sku_value']"); // input  value
		var checkedNodeLen = 0 ;//选中的SKU节点的个数
		$(skuValCheckBoxs).each(function(){
			if($(this).is(":checked")){ // 选中所有的 input 值
				var skuValObj = {};//SKU值对象
				skuValObj.skuValueTitle = $(this).val();//SKU值名称
				skuValObj.skuValueId = $(this).attr("propvalid");//SKU值主键
				skuValObj.skuPropId = $(this).attr("propid");//SKU类型主键
				skuValueArr.push(skuValObj);
				checkedNodeLen ++ ;
			}
		});

		if(is_required && 1 == is_required){//必选sku
			if(checkedNodeLen <= 0){//有必选的SKU仍然没有选中
				b = false;
				return false;//直接返回
			}
		}
		if(skuValueArr && skuValueArr.length > 0){
			totalRow = totalRow * skuValueArr.length;
			skuTypeObj.skuValues = skuValueArr;//sku值数组
			skuTypeObj.skuValueLen = skuValueArr.length;//sku值长度
			skuTypeArr.push(skuTypeObj);//保存进数组中
		}
	});


	// skuTypeArr = skuTypeArrCopy
	var SKUTableDom = "";//sku表格数据
	//开始创建行
	if(b){//必选的SKU属性已经都选中了
//			//调整顺序(少的在前面,多的在后面)
// 			skuTypeArr.sort(function(skuType1,skuType2){
// 				return (skuType1.skuValueLen - skuType2.skuValueLen)
// 			});
//
		SKUTableDom += "<table class='skuTable'><tr>";
		//创建表头
		for(let t = 0 ; t < skuTypeArr.length ; t ++){
			SKUTableDom += '<th>'+skuTypeArr[t].skuTypeTitle+'</th>';
		}
		SKUTableDom += '<th>价格</th><th>库存</th>';
		SKUTableDom += "</tr>";
		//循环处理表体
		for(var i = 0 ; i < totalRow ; i ++){//总共需要创建多少行
			var currRowDoms = "";
			var rowCount = 1;//记录行数
			var propvalidArr = [];//记录SKU值主键
			var propIdArr = [];//属性类型主键
			var propvalnameArr = [];//记录SKU值标题
			var propNameArr = [];//属性类型标题
			for(var j = 0 ; j < skuTypeArr.length ; j ++){//sku列
				var skuValues = skuTypeArr[j].skuValues;//SKU值数组
				var skuValueLen = skuValues.length;//sku值长度
				rowCount = (rowCount * skuValueLen);//目前的生成的总行数
				var anInterBankNum = (totalRow / rowCount);//跨行数
				var point = ((i / anInterBankNum) % skuValueLen);
				propNameArr.push(skuTypeArr[j].skuTypeTitle);
				if(0  == (i % anInterBankNum)){//需要创建td
					currRowDoms += '<td rowspan='+anInterBankNum+'>'+skuValues[point].skuValueTitle+'</td>';
					propvalidArr.push(skuValues[point].skuValueId);
					propIdArr.push(skuValues[point].skuPropId);
					propvalnameArr.push(skuValues[point].skuValueTitle);
				}else{
					//当前单元格为跨行
					propvalidArr.push(skuValues[parseInt(point)].skuValueId);
					propIdArr.push(skuValues[parseInt(point)].skuPropId);
					propvalnameArr.push(skuValues[parseInt(point)].skuValueTitle);
				}
			}
//
//				//进行排序(主键小的在前,大的在后),注意:适用于数值类型的主键
//				propvalidArr.sort(function(provids1,propvids2){
//					return (provids1 - propvids2)
//				});

			var propvalids = propvalidArr.toString()
			var alreadySetSkuPrice = "";//已经设置的SKU价格
			var alreadySetSkuStock = "";//已经设置的SKU库存
			console.log(propvalids, '已经设置的SKU库存')
			//赋值
			if(alreadySetSkuVals){
				var currGroupSkuVal = alreadySetSkuVals[propvalids];//当前这组SKU值
				if(currGroupSkuVal){
					alreadySetSkuPrice = currGroupSkuVal.skuPrice;
					alreadySetSkuStock = currGroupSkuVal.skuStock
				}
			}
			//console.log(propvalids);
			SKUTableDom += `<tr propvalids='${propvalids}' propids='${propIdArr.toString()}'
 								 propvalnames='${propvalnameArr.join(";")}'  propnames='${propNameArr.join(";")}' class="sku_table_tr">
						${currRowDoms}
					<td><input type="text" class="setting_sku_price" value="${alreadySetSkuPrice}"/></td>
					<td><input type="text" class="setting_sku_stock" value="${alreadySetSkuStock}"/></td>
					</tr>`;
		}
		SKUTableDom += "</table>";
	}
	$("#skuTable").html(SKUTableDom);
}



function getAlreadySetSkuVals(){
	alreadySetSkuVals = {};
	//获取设置的SKU属性值

	// console.log(alreadySetSkuVals, 'alreadySetSkuVals')
	$(".sku_table_tr").each(function(){
		var skuPrice = $(this).find("input[type='text'][class*='setting_sku_price']" ).val() || 0;//SKU价格
		var skuStock = $(this).find("input[type='text'][class*='setting_sku_stock']").val() || 0;//SKU库存
		if(skuPrice || skuStock){//已经设置了全部或部分值
			var propvalids = $(this).attr("propvalids");//SKU值主键集合

			alreadySetSkuVals[propvalids] = {
				"skuPrice" : skuPrice,
				"skuStock" : skuStock
			}
		}
	});
}
