var cart_num_min = 1;
var cart_num_max = 99;
var cart_cookie_key = 'c_carts';
var cart_tips_bottom = 1.64;
$('body').on('click','.cart-action-reduce',function(){

    var num = parseInt($(this).siblings('.cart-action-num').val());
    if(num<=cart_num_min){
        return false;
    }
    $(this).siblings('.cart-action-num').val(num-1);
    checkCartDisableStatus($(this).siblings('.cart-action-num'));

    //这里调用减少购物车接口

    var id = $(this).attr('data-id');
    if($(this).attr('data-action-nocart') != 1){
        actionCart(id,1,'de');
    }

    if(typeof(cartActionReduceCallback) && typeof(cartActionReduceCallback)=='function'){
        cartActionReduceCallback($(this));
    }


});
$('body').on('click','.cart-action-add',function(){

    var num = parseInt($(this).siblings('.cart-action-num').val());
    if(num>=cart_num_max){
        return false;
    }
    $(this).siblings('.cart-action-num').val(num+1);
    checkCartDisableStatus($(this).siblings('.cart-action-num'));

    //这里调用增加购物车接口
    var id = $(this).attr('data-id');
    if($(this).attr('data-action-nocart') != 1) {


        actionCart(id, 1, 'add');
    }
    if(typeof(cartActionAddCallback) && typeof(cartActionAddCallback)=='function'){
        cartActionAddCallback($(this));
    }
});


function checkCartDisableStatus(cart_num_obj){
    //var cart_num_obj = obj.siblings('.cart-action-num');

    var num = parseInt(cart_num_obj.val());

    if(num<=cart_num_min){
        cart_num_obj.siblings('.cart-action-reduce').addClass('forbid');
    }else{
        cart_num_obj.siblings('.cart-action-reduce').removeClass('forbid');
    }

    if(num>=cart_num_max){
        cart_num_obj.siblings('.cart-action-add').addClass('forbid');
    }else{
        cart_num_obj.siblings('.cart-action-add').removeClass('forbid');
    }
}

$('.cart-action-num').each(function(){
    checkCartDisableStatus($(this))
})


$('body').on('click','.cart-action-remove-shopping',function(){

    var callback = $(this).attr('data-action-callback');
    var cart_obj = $(this).parents('#cart-box');
    var length = $('.cart-action-remove-shopping').length;
    if(length<=1){
        $('.goods').css('padding-bottom','50px');
        $('.goods').append('<p class="last-tips"><i class="iconfont">&#xe631;</i><span>已經是最後一個商品了</span></p>');

        setTimeout(function(){
            $('.last-tips').fadeOut(500,function(){
                $(this).remove();
                $(".goods").animate({'padding-bottom':"32px"});
            });
        }, 1000);
        return false;
    }
    $(this).remove();
    cart_obj.fadeTo(200, 0.01, function(){
        $(this).slideUp(500, function() {
            $(this).remove();
            if(callback){
                eval(callback)
            }


        });
    });

    if($(this).attr('data-action-nocart') != 1){
        deleteCart($(this).attr('data-id'));
    }

});

$('body').on('click','.cart-action-remove',function(){

    var callback = $(this).attr('data-action-callback');
    var cart_obj = $(this).parents('#cart-box');
    cart_obj.fadeTo(300, 0.01, function(){
        $(this).slideUp("slow", function() {
            $(this).remove();
            if(callback){
                eval(callback)
            }
            var length = $('.cart-action-remove').length;

            if(length<=0){
                var tmp = '<div class="cart-empty-tips"><p>購物車空空如也~</p><p>快去加入商品吧</p></div>';
                $('.apex-cart-product').html(tmp)
            }


        });
    });

    if($(this).attr('data-action-nocart') != 1){
        deleteCart($(this).attr('data-id'));
    }

});


function actionCart(id,num,action){
    if(!id){
        return false;
    }

    var key = cart_cookie_key;
    var cart = $.cookie(key);
    num = parseInt(num);
    if(num<1){
        num = 1;
    }
    var is_joined = false;
    if(cart){
        var cart_data = JSON.parse($.cookie(key));
        if(cart_data[id]){
            return false;
            if(action == 'add'){
                var num = parseInt(cart_data[id])+num;
            }else{
                var num = parseInt(cart_data[id])-num;
            }
        }
    }else{
        var cart_data = {};
    }

    if(num > cart_num_max){
        num = cart_num_max;
    }else if(num < cart_num_min){
        num = cart_num_min;
    }

    if(is_joined == true){
        deleteCart(id); //删除原有的 重新插入 使得排在最前面
        var cart_data = JSON.parse($.cookie(key));
    }
    cart_data[id]=num


    $.cookie(key,JSON.stringify(cart_data),{
        expires: 30,
        path:"/" //cookie作用域，多个页面都有效

    });
    is_ajax_get_cart = 1;
    updateCartTotalSpan();

}


function getCartCount(){
    var cart = $.cookie(cart_cookie_key);
    var total_num = 0;
    if(cart){
        var cart_data = JSON.parse($.cookie(cart_cookie_key));
        /*return Object.keys(cart_data).length;*/

        var total_num = 0;
        for (x in cart_data)
        {
            total_num += cart_data[x];
        }
    }
    return total_num;
}



function deleteCart(id){
    var cart = $.cookie(cart_cookie_key);
    if(cart){
        var cart_data = JSON.parse($.cookie(cart_cookie_key));
        if(cart_data[id]){
            delete cart_data[id];
            $.cookie(cart_cookie_key,JSON.stringify(cart_data),{
                path:"/" //cookie作用域，多个页面都有效
            });
            is_ajax_get_cart = 1;
            updateCartTotalSpan();
        }
    }
}



function updateCartTotalSpan(){

    var cart_count = getCartCount();

    $('#menu-count').text(cart_count);
    $('#header-cart-count').text(cart_count);
    if(cart_count <= 0){
        //$('#menu-count').hide();
        $('#header-cart-count').hide();
    }else{
        //$('#menu-count').show();
        $('#header-cart-count').show();
    }



    var total_price = 0;
    $("input[data-cart-action='calc']").each(function(){
        var price = parseInt($(this).attr('data-price'));
        var num = parseInt($(this).val());
        total_price += num*price;
    });
    $('#total_price').text(total_price);
    $('#goods-price').text(total_price);
    var freight = 0
    if(total_price<free_shipping_where){
        freight = free_shipping_freight
    }
    $('#freight-price').text(freight);
    $('#order-price,#order_total_price').text(total_price+freight);

}




function cartLoading(elm){
    var tmp = '<div class="dcat-loading d-flex items-center align-items-center justify-content-center pin" style="margin-top: 50px;background:transparent;z-index:999991014;text-align: center;"><svg xmlns="http://www.w3.org/2000/svg" class="mx-auto block" style="width:58px;{svg_style}" viewBox="0 0 120 30" fill="#bacad6"><circle cx="15" cy="15" r="15"><animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="60" cy="15" r="9" fill-opacity="0.3"><animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="105" cy="15" r="15"><animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate></circle></svg></div>';

    $(elm).html(tmp);
}

function getAjaxApexCart(){
    cartLoading('.apex-cart-product');

    $.ajax({
        type: "GET",
        url: "/get/carts",
        dataType: "html",
        success: function(data){
            //$('.apex-cart-box').empty();
            /*var tmp = '<i class="iconfont triangle">&#xe6cb;</i>';
            tmp += data*/
            $('.apex-cart-product').html(data);

            $('.cart-action-num').each(function(){
                checkCartDisableStatus($(this))
            })
            updateCartTotalSpan();
            //computeCartBoxHeight();
        }
    });
}


function setCartTipsBottom(num){
    cart_tips_bottom = num;
}
function effect(obj){
    obj.attr('data-disable','1');
    obj.html('<i class="iconfont">&#xe644;</i>加入購物車成功');
    setTimeout(function (){
        obj.attr('data-disable','0');
        obj.html('<i class="iconfont">&#xe602;</i>加入購物車');
    }, 3000);
    $('.cart-tips').remove();
    var tips = '<div class="cart-tips"><p>商品添至購物車成功 ! 您可以前往購物車查看<span id="cart-down">3</span></p></div>';
    $('body').append(tips);
    $('.cart-tips').animate({bottom:cart_tips_bottom+'rem',opacity:1},200,function(){
        var _this = $(this);
        var cur = 3;
        var timer = setInterval(function (){
            cur--;
            if (cur <= 0) {
                clearInterval(timer);
                _this.animate({bottom:'-0.72rem',opacity:0},200,function(){
                    $(this).remove();
                });
            }
            _this.find('#cart-down').text(cur);
        }, 1000);

    });

}


$('body').on('click','.event-add-cart',function(){
    if($(this).attr('data-disable') == 1){
        return false;
    }
    effect($(this));
    var id = $(this).attr('data-id');
    var num = 1;
    $('.cart-input-'+id).each(function(){
        var nnum = parseInt($(this).val());
        if(nnum>num){
            num = nnum;
        }
    });

   actionCart(id,num,'add');
});


$('body').on('click','.cart-reduce',function(){
    var input = $(this).siblings('input');
    var num = parseInt(input.val());
    if(num<=cart_num_min){
        checkReduceAddStatus(input);
        return false;
    }else{
        is_ajax_get_cart = 0
        var new_num = num-1;
        input.val(new_num);
        var price = parseInt(input.attr('data-price'));
        var id = parseInt(input.attr('data-id'));
        $('#price-'+id).text(new_num*price);
        checkReduceAddStatus(input);
    }
});

$('.cart-add').click(function(){
    var input = $(this).siblings('input');
    var num = parseInt(input.val());
    if(num>=cart_num_max){
        checkReduceAddStatus(input);
        return false;
    }else{
        is_ajax_get_cart = 0
        var new_num = num+1;
        input.val(new_num);
        var price = parseInt(input.attr('data-price'));
        var id = parseInt(input.attr('data-id'));
        $('#price-'+id).text(new_num*price);
        checkReduceAddStatus(input);
    }
});

function checkReduceAddStatus(obj){
    var num = parseInt(obj.val());

    if(num<=cart_num_min){
        obj.siblings('.cart-reduce').addClass('forbid')
    }else{
        obj.siblings('.cart-reduce').removeClass('forbid')
    }

    if(num>=cart_num_max){
        obj.siblings('.cart-add').addClass('forbid')
    }else{
        obj.siblings('.cart-add').removeClass('forbid')
    }

}


var rightPopupLayer = function (content='') {
    layer.open({
        type: 1,
        title: '',
        offset: ['0', '100%'],
        skin: 'layui-anim layui-anim-rl layui-layer-adminRight',
        closeBtn: 0,
        content: content,
        shadeClose: true,
        area: ['400px', '100%'],
        success:function(){
            if(is_ajax_get_cart == 0){
                //return false;
            }
            getAjaxApexCart()

            is_ajax_get_cart = 0

        }
    })

    $('.layui-layer-shade').off('click').on('click', function () {
        closeRightPopupLayer();

    })
}
$('body').on('click','.apex-cart-header .close',function(){
    closeRightPopupLayer();
});

$('body').on('click','.apex-cart-continue-btn',function(){
    closeRightPopupLayer();
});

function closeRightPopupLayer(){
    let op_width = $('.layui-anim-rl').outerWidth();
    $('.layui-anim-rl').animate({left:'+='+op_width+'px'}, 200, 'linear', function () {
        $('.layui-anim-rl').remove()
        $('.layui-layer-shade').remove()
    });

    if(typeof(closeRightCartCallback) && typeof(closeRightCartCallback)=='function'){
        closeRightCartCallback();
    }
}

$('#end').click(function(){
    rightPopupLayer($('#cart-template').html());
})


