function orderStore(){
    var name = $("input[name='name']").val();
    var phone = $("input[name='phone']").val();
    var email = $("input[name='email']").val();
    //var city = $("input[name='city_area']").val();
    var address = $("input[name='address']").val();
    var delivery_time = $("input[name='delivery_time']").val();
    var product_ids = $('.cart-action-num').val();
    var city = $("select[name='city']").val();
    var county = $("select[name='county']").val();
    var street = $("select[name='street']").val();
    var order_type = $("input[name='order_type']:checked").val();
    var store_id = $("input[name='store_id']:checked").val();

    if(!name){
        layerMsg('請填寫收貨人姓名');
        return false;
    }
    if(!phone){
        layerMsg('請填寫收貨電話');
        return false;
    }

    phone = phone.replaceAll('-','');
    if(!(/^09\d{8}$/.test(phone))){
        layerMsg('電話格式錯誤');
        return false;
    }

    if(!email){
        layerMsg('請填寫您的郵箱');
        return false;
    }

    if(email.search(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn|tw|info|net)$/) == -1){
        layerMsg('請填寫正確的郵箱');
        return false;
    }

    if(!city){
        layerMsg('請選擇縣市');
        return false;
    }

    if(!county){
        layerMsg('請選擇地區');
        return false;
    }

    if(!street){
        layerMsg(' 請選擇路段');
        return false;
    }

    if(order_type > 0){
        if(!store_id){
            layerMsg('請選擇門市');
            return false;
        }

    }else{
        if(!address){
            layerMsg('請填寫詳細地址');
            return false;
        }
        if(!delivery_time){
            layerMsg('請選擇送達時段');
            return false;
        }
    }

    addLoadingActionBtn('.form-btn');

    $.ajax({
        type: $('#order-form').attr('method'),
        url: $('#order-form').attr('action'),
        data: $('#order-form').serialize(),
        dataType: "json",
        success: function(data){
            window.location.href = "/check/"+data.data.id;
        },
        error:function(jqXHR, textStatus, errorThrown){
            var response = JSON.parse(jqXHR.responseText)
            //xie.error("提交失败",response.msg);
            layerMsg(response.msg)
            closeLoadingActionBtn('.form-btn');
        }
    });
    return false;
}

function orderCheck(){
    var email = $("input[name='email']").val();
    var phone = $("input[name='phone']").val();
    if(!email){
        layerMsg('請填寫郵箱');
        return false;
    }
    if(email.search(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn|tw|info|net)$/) == -1){
        layerMsg('請填寫正確的郵箱');
        return false;
    }

    if(!phone){
        layerMsg('請填寫收貨電話');
        return false;
    }

    if(!(/^09\d{8}$/.test(phone))){
        layerMsg('電話格式錯誤');
        return false;
    }
    addLoadingActionBtn('.form-btn');
}

function messageStore(){
    var name = $("input[name='name").val();
    var email = $("input[name='email']").val();
    var content = $("textarea[name='content']").val();
    if(!name){
        warnInfo($('input[name="name"]').siblings('.warn'),'請填寫您的昵稱');
        $('input[name="name"]').css('border-color','#ef3c3c');
        layer.msg('請填寫您的昵稱');
        return false;
    }
    if(!email){
        warnInfo($('input[name="email"]').siblings('.warn'),'請填寫郵箱');
        $('input[name="email"]').css('border-color','#ef3c3c');
        layer.msg('請填寫郵箱');
        return false;
    }
    if(email.search(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn|tw|info|net)$/) == -1){
        warnInfo($('input[name="email"]').siblings('.warn'),'請填寫正確的郵箱');
        $('input[name="email"]').css('border-color','#ef3c3c');
        layer.msg('請填寫正確的郵箱');
        return false;
    }

    if(!content){
        warnInfo($('textarea[name="content"]').siblings('.warn'),'請填寫您的意見或建議');
        $('textarea[name="content"]').css('border-color','#ef3c3c');
        layer.msg('請填寫您的意見或建議');
        return false;
    }

    addLoadingActionBtn('.form-btn');
}

function warnInfo(elem,text){
    var left = parseInt(elem.parent().css('width'))+10;
    elem.css('color',"rgb(239, 60, 60)");
    elem.text(text);
}


$("input,textarea").blur(function(){
    $(this).css('border-color','#E6E6E6');
    $(this).siblings('.warn').text('')
    $(this).attr('placeholder',$(this).attr('x-placeholder'));
});

$("input,textarea").focus(function(){
    $(this).attr('x-placeholder',$(this).attr('placeholder'));
    $(this).siblings('.warn').text('')
    $(this).attr('placeholder','');
    $(this).css('border-color','#E6E6E6')
})



function layerMsg(content,time){
    if (!time){
        time = 2;
    }
    layer.open({
        content: content
        ,skin: 'msg'
        ,time: time
    });
}
