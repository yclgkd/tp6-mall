export function showLoad(msg){
    if(!document.getElementById("loadingDiv")){
        var loadDiv = '<div id="loadingDiv" class="loading">';
        loadDiv +='<div class="loading-back"></div>';
        loadDiv +='<div class="loading-div">';
        loadDiv +='<img src="@asset/images/loading.png">';
        loadDiv +='<p id="loadingStr">请稍等...</p>';
        loadDiv +='</div>';
        loadDiv +='</div>';
        $("body").append(loadDiv);
    }
    if(msg != "undefined"){
        $("#loadingStr").html(msg);
    }
    $("#loadingDiv").show();
}
export function hideLoad(){
    $("#loadingDiv").hide();
}

export function showMsg(msg){
    if(!document.getElementById("showMsgPop")){
        var infoPop = '<div class="modal fade" id="showMsgPop" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel" aria-hidden="true">';
        infoPop += '<div class="modal-dialog" role="document">';
        infoPop += '<div class="modal-content">';
        infoPop += '<div class="modal-header">';
        infoPop += '<h5 class="modal-title" id="msgModalLabel">提示信息</h5>';
        infoPop += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        infoPop += '<span aria-hidden="true">&times;</span>';
        infoPop += '</button>';
        infoPop += '</div>';
        infoPop += '<div class="modal-body">';
        infoPop += '<p id="showMsgPopInfo"></p>';
        infoPop += '</div></div></div></div>';
        $("body").append(infoPop);
    }
    $("#showMsgPopInfo").html(msg);
    $("#showMsgPop").modal("show");
    setTimeout('$("#showMsgPop").modal("hide");',3000);
}

export function testTime(mss) {
    let hours = parseInt((mss % (60 * 60 * 24)) / (60 * 60));
    let minutes = parseInt((mss % (60 * 60)) / (60));
    let seconds = (mss % (60));
    if(hours < 10){
        hours = "0"+hours;
    }
    if(minutes < 10){
        minutes = "0"+minutes;
    }
    if(seconds < 10){
        seconds = "0"+seconds;
    }

    return hours +":"+ minutes +":"+ seconds;
}

export function foldInit(){
    $(".fold").on("click",function(){
        if($(this).hasClass("fold-open")){
            $(this).removeClass("fold-open");
            $(this).addClass("fold-close");
            $(this).parent().parent().parent().find(".mod_main_list_02").hide();
        }else{
            $(this).removeClass("fold-close");
            $(this).addClass("fold-open");
            $(this).parent().parent().parent().find(".mod_main_list_02").show();
        }
    });
}


export function foldInit1(){
    $(".fold1").on("click",function(){
        if($(this).hasClass("fold-open")){
            $(this).removeClass("fold-open");
            $(this).addClass("fold-close");
            $(this).parent().parent().parent().find(".mod_main_list_02").hide();
        }else{
            $(this).removeClass("fold-close");
            $(this).addClass("fold-open");
            $(this).parent().parent().parent().find(".mod_main_list_02").show();
        }
    });
}
