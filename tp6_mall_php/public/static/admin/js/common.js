const layObj = {
    uploadImg(ele, temp = 'uploads.html') {
        layer.open({
            type: 2
            , area: ['600px', '700px']
            , title: '上传图片'
            , shade: 0.6 //遮罩透明度
            , maxmin: false //允许全屏最小化
            , anim: 1 //0-6的动画形式，-1不开启
            , content: temp
            , success: function (layero, index) {
                let body = layer.getChildFrame('body', index);//建立父子联系
                let html = `<input type="hidden" id="child-val" value="${ele}">`;
                body.append(html)
            }
        });
    },
    dialog(temp,title='添加分类') {
        layer.open({
            type: 2
            , area: ['650px', '560px']
            , title: title
            , shade: 0.6 //遮罩透明度
            , maxmin: false //允许全屏最小化
            , anim: 1 //0-6的动画形式，-1不开启
            , content: temp
            , success(layero, index) {
                console.log(layero, index)
                // let body = layer.getChildFrame('body', index);//建立父子联系
                // let html =   `<input type="hidden" id="child-val" value="${ele}">`;
                // body.append(html)
            }
        });
    },
    msg(text,fn=()=>{}) {
        layer.msg(text,function () {
            fn()
            // window.location.reload();
        });
    },
    //询问框
    box(msg, func) {
        layer.confirm(msg, {
            title: '提示',
            btn: ['确定', '取消'] //按钮
        }, function () {
            func()
        })
    },
    get(url, func, err=()=>{}) {
        $.ajax({
            url,
            type: 'GET',
            success(res) {
              return   func(res)
            },
            error(res) {
                return   err(res)
            }
        })
    },
    post(url, data, func, err=()=>{}) {
        $.ajax({
            url,
            data,
            type: 'POST',
            dataType: "json",
            success(res) {
                return   func(res)
            },
            error(res) {
                return   err(res)
            }
        })
    }
};

function draw(show_num, ele = 'canvas') {
    var canvas_width = $('#' + ele).width();
    var canvas_height = $('#' + ele).height();
    var canvas = document.getElementById(ele);//获取到canvas的对象，演员
    var context = canvas.getContext("2d");//获取到canvas画图的环境，演员表演的舞台
    canvas.width = canvas_width;
    canvas.height = canvas_height;
    var sCode = "A,B,C,E,F,G,H,J,K,L,M,N,P,Q,R,S,T,W,X,Y,Z,1,2,3,4,5,6,7,8,9,0";
    var aCode = sCode.split(",");
    var aLength = aCode.length;//获取到数组的长度

    for (var i = 0; i <= 3; i++) {
        var j = Math.floor(Math.random() * aLength);//获取到随机的索引值
        var deg = Math.random() * 30 * Math.PI / 180;//产生0~30之间的随机弧度
        var txt = aCode[j];//得到随机的一个内容
        show_num[i] = txt.toLowerCase();
        var x = 10 + i * 20;//文字在canvas上的x坐标
        var y = 20 + Math.random() * 8;//文字在canvas上的y坐标
        context.font = "bold 23px 微软雅黑";

        context.translate(x, y);
        context.rotate(deg);

        context.fillStyle = randomColor();
        context.fillText(txt, 0, 0);

        context.rotate(-deg);
        context.translate(-x, -y);
    }
    for (var i = 0; i <= 5; i++) { //验证码上显示线条
        context.strokeStyle = randomColor();
        context.beginPath();
        context.moveTo(Math.random() * canvas_width, Math.random() * canvas_height);
        context.lineTo(Math.random() * canvas_width, Math.random() * canvas_height);
        context.stroke();
    }
    for (var i = 0; i <= 30; i++) { //验证码上显示小点
        context.strokeStyle = randomColor();
        context.beginPath();
        var x = Math.random() * canvas_width;
        var y = Math.random() * canvas_height;
        context.moveTo(x, y);
        context.lineTo(x + 1, y + 1);
        context.stroke();
    }
}

function randomColor() {//得到随机的颜色值
    var r = Math.floor(Math.random() * 256);
    var g = Math.floor(Math.random() * 256);
    var b = Math.floor(Math.random() * 256);
    return "rgb(" + r + "," + g + "," + b + ")";
}


function toTree(data) { // 生成递归树
    // 删除 所有 children,以防止多次调用
    data.forEach(function (item) {
        delete item.children;
    });
    // 将数据存储为 以 id 为 KEY 的 map 索引数据列
    var map = {};
    data.forEach(function (item) {
        map[item.id] = item;
    });

    var val = [];
    data.forEach(function (item) {
        // 以当前遍历项，的pid,去map对象中找到索引的id
        var parent = map[item.pid];
        // 好绕啊，如果找到索引，那么说明此项不在顶级当中,那么需要把此项添加到，他对应的父级中
        if (parent) {
            (parent.children || (parent.children = [])).push(item);
        } else {
            //如果没有在map中找到对应的索引ID,那么直接把 当前的item添加到 val结果集中，作为顶级
            val.push(item);
        }
    });
    return val;
}



