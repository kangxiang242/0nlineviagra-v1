jQuery(document).ready(function(){



    function GetQueryString(name)
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    }

    $('.back').click(function(){
        var go_back_url = document.referrer;
        var domain = go_back_url.split('/');
        if( domain[2] ) {
            domain = domain[2];
            domain = domain.split(':')
            if(domain[0]){
                domain = domain[0];
                if(domain == document.domain){
                    window.history.back(-1);
                }else{
                    location.href='/';
                }
            }
        }
    })

/*    var pathname = window.location.pathname;
    pathname = pathname.replace('index.php','');
    var eq = null;
    if(pathname == '/'){
        eq = 0;
    }else if(pathname == '/product'){
        eq = 1;
        $('.nav-item').eq(0).addClass('xz')
    }else if(pathname == '/cart'){
        eq = 3;
    }else if(pathname == '/check'){
        $('.nav-item').eq(1).addClass('xz')

    }else if(pathname == '/guide'){
        eq = 2;
    }else if(pathname == '/news'){
        $('.nav-item').eq(3).addClass('xz')
    }else if(pathname == '/message'){
        $('.nav-item').eq(2).addClass('xz')
    }

    if(eq != null && eq != undefined){
        $('.menu-item').eq(eq).addClass('activate');
        var data_img = $('.menu-item').eq(eq).find('img').attr('data-on');
        $('.menu-item').eq(eq).find('img').attr('src',data_img);
    }*/

})
