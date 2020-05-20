var show_num = [];

layui.use(['form'], function () {

    var form = layui.form,
        layer = layui.layer;
    // 登录过期的时候，跳出ifram框架
    if (top.location != self.location) top.location = self.location;
    // 进行登录操作
    form.on('submit(login)', function (data) {
        data = data.field;
        if (data.username == '') {
            layer.msg('用户名不能为空');
            return false;
        }
        if (data.password == '') {
            layer.msg('密码不能为空');
            return false;
        }


        if (data.captcha == '') {
            layer.msg('验证码不能为空');
            return false;
        }
        // 验证码 校验
        // var val = $(".input-val").val().toLowerCase();
        // var num = show_num.join("");
        // if(val != num){
        //     layer.msg('验证码错误！请重新输入！');
        //     draw(show_num);
        //     return false;
        // }

        // window.location = '../index.html';
        // return false;
        $(".input-val").val('');
        url = "/admin/login/check";
        $.ajax({
            url,
            data,
            type:"POST",
            success(res){
                if(res.status == 1){
                    layer.msg('登录成功', function () {
                        window.location = '/admin/index/index';
                    });
                }else{
                    layer.msg(res.message);
                    return false;
                }
            }
        })
        return false;
    });
});
$(function(){
    // location.href  =  "http://www.baidu.com";
    draw(show_num);
    $("#canvas").on('click',function(){
        draw(show_num);
    })
})
