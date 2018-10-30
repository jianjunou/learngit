<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/2.0.1/jquery.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <link href="https://cdn.bootcss.com/limonte-sweetalert2/2.0.2/sweetalert2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.2/css/swiper.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.2/js/swiper.js"></script>
    <title>首页</title>
    <style type="text/css">
        .swiper-container {
            height: 400px;
        }  
    </style>
</head>

<body>
    <div class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a href="/" class="navbar-brand">首页</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
                    <span class="sr-only">菜单折叠</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="javascript:;">招聘</a></li>
                    <li><a href="javascript:;">关于</a></li>
                </ul>
                <form class="navbar-form navbar-left" method="GET" action="/index.php/home/index/search">
                    <div class="form-group">
                        <input type="text" class="form-control" name="kw" placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:;">登录</a></li>
                    <li><a href="javascript:;">注册</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="/Public/banner/1.jpg"></div>
                        <div class="swiper-slide"><img src="/Public/banner/2.jpg"></div>
                        <div class="swiper-slide"><img src="/Public/banner/3.jpg"></div>
                        <div class="swiper-slide"><img src="/Public/banner/4.jpg"></div>
                    </div>
                    <!-- 如果需要分页器 -->
                    <div class="swiper-pagination"></div>
                    <!-- 如果需要导航按钮 -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <!-- 如果需要滚动条 -->
                    <div class="swiper-scrollbar"></div>
                </div>
            </div>
            <div class="col-md-6">
                <ul class="list-group" id="top10">
                    <li class="list-group-item">1</li>

                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        
        <div class="row">
            <div class="col-md-12">
                <h4>共计： <small class="badge" id="listMovieCount">0</small></h4>
                <hr/>
                <ul class="list-group" id="listMovie">
                    <li class="list-group-item">序号： 名称： 下载地址： <a href="javascript:;" class="btn btn-success">提取码</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.bootcss.com/limonte-sweetalert2/2.0.2/sweetalert2.min.js"></script>
<script type="text/javascript">
function formatJson(data, isTop) {
    var _html = '';
    $.each(data, function(index, val) {
        if(isTop){
            _html += '<li class="list-group-item">TOP：' + (index+1) + ' <small class="badge">' +  val['start'] + '</small>  名称称：<a href="/index.php/home/index/detail/id/' + val['id'] + '">《' + val['title'] + '》</a><a class="btn btn-success" target="_blank" href="/index.php/home/index/detail/id/' + val['id'] + '">查看详情</a></li>';

        }else{

            _html += '<li class="list-group-item">序号：' + val['id'] + ' 名称：<a href="/index.php/home/index/detail/id/' + val['id'] + '">《' + val['title'] + '》</a><a class="btn btn-success" target="_blank" href="/index.php/home/index/detail/id/' + val['id'] + '">查看详情</a></li>';
        }
    });
    return _html;
}

function getStart(callback){
     $.ajax({
        url: '/index.php/home/index/start',
        type: 'GET',
        dataType: 'json',
        success: function(json) {
            typeof callback == 'function' && callback(json);

        }
    });
}
function getSecret(id, callback) {
    $.ajax({
        url: '/index.php/home/index/movie',
        type: 'GET',
        data: { 'id': id },
        dataType: 'json',
        success: function(json) {
            typeof callback == 'function' && callback(json);

        }
    });
}

function getMovieData(callback) {

    $.ajax({
        url: '/index.php/home/index/movies',
        type: 'GET',
        dataType: 'json',
        success: function(json) {

            typeof callback == 'function' && callback(json);

        }
    });

}


function getSwiper() {
    var mySwiper = new Swiper('.swiper-container', {
        direction: 'horizontal',
        loop: true,

        // 如果需要分页器
        pagination: {
            el: '.swiper-pagination',
        },

        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // 如果需要滚动条
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    })

}

$(function() {
    getSwiper();
    getStart(function (json) {
        console.log( json );
         $('#top10').html( formatJson(json, true) );

    });


    getMovieData(function(json) {
        
        $("#listMovieCount").html(json.length);
        $("#listMovie").html(formatJson(json));
        $(".tqm").click(function() {
            var movieId = $(this).attr('data-id');

            getSecret(movieId, function(json) {
                var _html = '<div class="panel panel-danger">\
                    <div class="panel-heading">\
                        <h3>' + json['title'] + '</h3>\
                    </div>\
                    <div class="panel-body">\
                        <img width="200" src="' + json['imgurl'] + '" alt="" />\
                        <hr />\
                        <p class="alert alert-warning">\
                          ' + json['shorttitle'] + '\
                        </p> <hr />\
                        <input type="text" name="kw" class="form-control"  readonly autocomplete="off" id="kw" value="' + json['loadurl'] + ' 密码：' + json['secret'] + '" /> <hr />\
                        <button type="button" class="btn btn-success btn-lg btn-block">复制</button>\
                    </div>\
                </div>\
                <hr>';
                swal({
                    title: '【' + json['title'] + '】 资源地址',
                    html: _html,
                    animation: false
                });
            });
        });

    });

})
</script>

</html>