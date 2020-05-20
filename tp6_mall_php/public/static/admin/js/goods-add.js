
/**
 * 页面注意事项：
 *      1、 .Father_Title      这个类作用是取到所有标题的值，赋给表格，如有改变JS也应相应改动
 *      2、 .Father_Item       这个类作用是取类型组数，有多少类型就添加相应的类名：如: Father_Item1、Father_Item2、Father_Item3 ...
 */

$(function() {
    $(document).on('change', '.choose_config li', function() { //  controls  warp 包 下的 所有label

        let len5 =  $('tbody td img').length
        console.log(len5, 'len')

        var parent=$(this).parents('.Father_Item'); // 父级
        var _this=$('.checkbox',this); //  指向 label 作用域
        // 是否全选
        $('.checkbox',parent).each(function() { // 在 Father_Item 作用域下
            var bCheck2=true;
          let isok =  _this.hasClass('check_all')
            if (_this.hasClass('check_all')) { // 全选
                if (_this.get(0).checked) {
                    bCheck2=true;
                    $('.check_item',parent).prop('checked', bCheck2); // prop 获取在匹配的元素集中的第一个元素的属性值。
                }else{
                    bCheck2=false;
                    $('.check_item',parent).prop('checked', bCheck2);
                }
                return false;
            } else {
                if ((!this.checked)&&(!$(this).hasClass('check_all'))) { // 全选 设为false
                    bCheck2 = false;
                    $('.check_all',parent).prop('checked', bCheck2);
                    return false;
                }
            }
            $('.check_all',parent).prop('checked', bCheck2);// 全选 bCheck2 设为false  or  true
        });

        step.Creat_Table();
    });
    var step = {
        // 信息组合
        Creat_Table: function() {
            step.hebingFunction();
            var SKUObj = $('.Father_Title'); // 表格标题  颜色 内存 尺寸大小
            var arrayTile = []; // 表格标题数组
            var arrayInfor = []; // 盛放每组选中的CheckBox值的对象
            var arrayColumn = []; // 指定列，用来合并哪些列
            var bCheck = true; // 是否全选，只有全选，表格才会生成
            var columnIndex = 0;

            $.each(SKUObj, function(i, item) {
                arrayColumn.push(columnIndex++);
                let title = SKUObj.eq(i).text().replace('：', '');
                if(title == '颜色'){
                    arrayTile.push(title);
                    arrayTile.push('图片');
                }else{
                    arrayTile.push(title);
                }


                var itemName = '.Father_Item' + i;  //类型下的 ul Father_Item0 Father_Item1  累加
                var bCheck2 = true; // 是否全选

                // 获取选中的checkbox的值
                var order = [];
                $(itemName + ' .check_item:checked').each(function() {
                    order.push($(this).val());
                });
                console.log(order, 'order');
                arrayInfor.push(order);
                if (order.join() === '') { // 如果不全选 就不生成
                    bCheck = false;
                }

            })

            // 开始生成表格
            if (bCheck) {
                $('#createTable').html('');





                var table = $('<table id="process" class="columnList"></table>');
                table.appendTo($('#createTable'));
                var thead = $('<thead></thead>');
                thead.appendTo(table);
                var trHead = $('<tr></tr>');
                trHead.appendTo(thead);
                // 创建表头
                var str = '';
                $.each(arrayTile, function(index, item) { // arrayTile 规格 内存 颜色 等
                    str += '<th width="100">' + item + '</th>';
                })
                str += '<th  width="200">价格</th>'; // 追加了 两栏
                trHead.append(str); // 生成头部
                // trHead.prepend('<th width="100">图片</th>'); // 生成头部
                var tbody = $('<tbody></tbody>'); // 建立 tbody
                tbody.appendTo(table); //  建立 table 插入 tbody

                var zuheDate = step.doExchange(arrayInfor);

                if (zuheDate.length > 0) {
                    //创建行
                    $.each(zuheDate, function(index, item) {
                        var td_array = item.split(',');
                        var tr = $('<tr></tr>');
                        tr.appendTo(tbody);  //建立 tbody 插入 tr
                        var str = '';
                        $.each(td_array, function(i, values) {
                            str += '<td>' + values + '</td>';
                        });
                        str += '<td ><input name="Txt_PriceSon" class="inpbox inpbox-mini" type="text"></td>';
                        tr.append(str);
                    });
                }
                //结束创建Table表
                arrayColumn.pop(); //删除数组中最后一项
                //合并单元格
                $(table).mergeCell({
                    // 目前只有cols这么一个配置项, 用数组表示列的索引,从0开始
                    cols: arrayColumn
                });
            } else {
                //未全选中,清除表格
                document.getElementById('createTable').innerHTML = "";
            }
        },
        hebingFunction: function() {
            $.fn.mergeCell = function(options) {
                return this.each(function() {
                    var cols = options.cols;
                    for (var i = cols.length - 1; cols[i] !== undefined; i--) {
                        mergeCell($(this), cols[i]);
                    }
                    dispose($(this));
                })
            };

            function mergeCell($table, colIndex) {
                $table.data('col-content', ''); // 存放单元格内容
                $table.data('col-rowspan', 1); // 存放计算的rowspan值 默认为1
                $table.data('col-td', $()); // 存放发现的第一个与前一行比较结果不同td(jQuery封装过的), 默认一个"空"的jquery对象
                $table.data('trNum', $('tbody tr', $table).length); // 要处理表格的总行数, 用于最后一行做特殊处理时进行判断之用
                // 进行"扫面"处理 关键是定位col-td, 和其对应的rowspan
                $('tbody tr', $table).each(function(index) {
                    // td:eq中的colIndex即列索引
                    var $td = $('td:eq(' + colIndex + ')', this);
                    // 获取单元格的当前内容
                    let currentContent =  $td.html();
                    // 第一次时走次分支
                    if  ($table.data('col-content') === '') {
                        $table.data('col-content', currentContent);
                        $table.data('col-td', $td);
                    } else {
                        // 上一行与当前行内容相同
                        if ($table.data('col-content') === currentContent) {
                            // 上一行与当前行内容相同则col-rowspan累加, 保存新值
                            var rowspan = $table.data('col-rowspan') + 1;
                            $table.data('col-rowspan', rowspan);
                            // 值得注意的是 如果用了$td.remove()就会对其他列的处理造成影响
                            $td.hide();
                            // 最后一行的情况比较特殊一点
                            // 比如最后2行 td中的内容是一样的, 那么到最后一行就应该把此时的col-td里保存的td设置rowspan
                            // 最后一行不会向下判断是否有不同的内容
                            if (++index === $table.data('trNum')) {
                                console.log($table.data('trNum'), '$table.data(trNum)', index)
                                $table.data('col-td').attr('rowspan', $table.data('col-rowspan'));
                            }
                        }
                        // 上一行与当前行内容不同
                        else {
                            // col-rowspan默认为1, 如果统计出的col-rowspan没有变化, 不处理
                            if ($table.data('col-rowspan') !== 1) {
                                $table.data('col-td').attr('rowspan', $table.data('col-rowspan'));
                            }
                            // 保存第一次出现不同内容的td, 和其内容, 重置col-rowspan
                            $table.data('col-td', $td);
                            $table.data('col-content', currentContent);
                            $table.data('col-rowspan', 1);
                        }
                    }
                })
            }
            // 同样是个private函数 清理内存之用
            function dispose($table) {
                $table.removeData();
            }
        },
        doExchange(doubleArrays, status=false) {
            // 二维数组，最先两个数组组合成一个数组，与后边的数组组成新的数组，依次类推，知道二维数组变成以为数组，所有数据两两组合
            var len = doubleArrays.length;
            if (len >= 2) {
                var arr1 = doubleArrays[0];// 颜色值
                var arr2 = doubleArrays[1];// 内存值




                var len1 = arr1.length; // 3
                var len2 = arr2.length; // 3
                var newLen = len1 * len2; // 9
                var temp = new Array(newLen); // 9 arr
                var index = 0;
                for (var i = 0; i < len1; i++) {// 颜色值 三次
                    for (var j = 0; j < len2; j++) { // 内存值三次
                        if(!status){
                            temp[index++] =  arr1[i]+(',<i class="layui-icon layui-icon-upload-drag up-img-btn" id="tbId'+i+'" data-index="'+i+'"></i>,') + arr2[j]; // 颜色值 拼接内存值
                        }else{
                            temp[index++] =  arr1[i]+',' + arr2[j]; // 颜色值 拼接内存值
                        }
                    }
                }
                // 总共 temp 9次
                var newArray = new Array(len-1); // 三个数组
                newArray[0] = temp; // 9个 组 ，颜色，内存
                if (len > 2) {
                    let _count = 1;
                    for (let i = 2; i < len; i++) {
                        newArray[_count++] = doubleArrays[i];
                    }
                }
                return step.doExchange(newArray, true);
            } else {
                return doubleArrays[0];
            }
        }
    }
})
