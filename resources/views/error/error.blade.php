<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>出错了</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-size: 0;
        }
        html,body{
            height: 100%;
        }
        body{
            position: relative;
            background: #eeeeee;
        }
        .error-box{
            position: relative;
            width: 1054px;
            height: 654px;
            background: url('{{asset('/static/core/img/error.png')}}');
            margin: 100px auto 0 auto;
        }
        .error-text{
            position: absolute;
            bottom: 160px;
            left: 0;
            right: 0;
            color: #666;
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
        }
        .error-box > .row{
            position: absolute;
            width: 100%;
            left: 0;
            bottom: 40px;
            height: 60px;
            text-align: center;
            line-height: 60px;
        }

        .error-box > .row > a{
            display: inline-block;
            color: #333;
            font-size: 18px;
            text-decoration: none;
            padding: 0 30px;
            height: 30px;
            margin: 10px 0;
            line-height: 30px;
        }
        a.first {
            border-right: 1px solid #e6e6e6;
        }
    </style>
</head>
<body>
<div class="error-box">
    <p class="error-text">错误原因：{{ $msg }}</p>
    <div class="row">
        <a class="first" href="javascript:void(0);" onclick="history.go(-1)">返回</a>
        <a href="{{url('/')}}">去首页</a>
    </div>
</div>
</body>
</html>