layui.use(['upload'], function () {
    var $ = layui.jquery
        ,upload = layui.upload;

    var uploadInst = upload.render({
        elem: '#btn_main'
        ,url: '/admin/image/upload'
        ,done: function(res){
            //如果上传失败
            if(res.status == 0){
                return layer.msg('上传失败');
            }
            $('.big_image').html('<img  src="'+res.result.image+'"  class="layui-upload-img upload-img" id="main_img">');
        }
    });


        upload.render({
            elem: '#btn_banner'
            ,url: '/admin/image/upload'
            ,multiple: true
            // ,before: function(obj){
            //     //预读本地文件示例，不支持ie8 注释掉
            //     obj.preview(function(index, file, result){
            //         $('#banner_img').append('<div class="img-wrap"><img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img upload-img"><i class="layui-icon layui-icon-close btn-del"></i></div>')
            //     });
            // }
            ,done: function(res){

                //如果上传失败
                if(res.status == 0){
                    return layer.msg('上传失败');
                }
                $('#banner_img').append('<div class="img-wrap"><img src="'+ res.result.image +'"  class="layui-upload-img upload-img"><i class="layui-icon layui-icon-close btn-del"></i></div>')


                // obj.preview(function(index, file, result){
                //     $('#banner_img').append('<div class="img-wrap"><img src="'+ result +'"  class="layui-upload-img upload-img"><i class="layui-icon layui-icon-close btn-del"></i></div>')
                // });
                //上传完毕
            }
        });

        upload.render({
            elem: '#btn_show'
            ,url: '/admin/image/upload'
            ,multiple: true
            // ,before: function(obj){
            //     //预读本地文件示例，注释掉
            //     obj.preview(function(index, file, result){
            //         $('#show_img').append('<div class="img-wrap"><img src="'+ result +'"  class="layui-upload-img upload-img"><i class="layui-icon layui-icon-close btn-del"></i></div>')
            //     });
            // }
            ,done: function(res){
                //如果上传失败
                if(res.status == 0){
                    return layer.msg('上传失败');
                }
                // obj.preview(function(index, file, result){
                //     $('#show_img').append('<div class="img-wrap"><img src="'+ result +'"  class="layui-upload-img upload-img"><i class="layui-icon layui-icon-close btn-del"></i></div>')
                // });
                //上传完毕
                $('#show_img').html('<div class="img-wrap"><img src="'+ res.result.image +'"  class="layui-upload-img upload-img"><i class="layui-icon layui-icon-close btn-del"></i></div>')

            }
        });


        $('body').on('click','.btn-del',function (index) {
            // 删除图片 可以走接口 后端进行删除 ，现行不走接口删
            // var img_url =[];
            // $("input[name='banner_img']").each(function(){
            //     img_url.push($(this).val());
            // })

            $(this).parent().remove()
        })


});
