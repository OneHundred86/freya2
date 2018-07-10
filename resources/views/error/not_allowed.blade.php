
@extends('error/base')

@section('app')
    <div class="error-frame">
        <div class="msg-frame">
            权限不足， 不允许访问
        </div>
        <div class="error-bottom">
            <a class="link a" href="/">首页</a>
            <a class="link" href="javascript:history.go(-1)" id="back">返回</a>
        </div>
    </div>
    <script>
        if(history.length <= 1){
            var back = document.getElementById('back');
            back.innerHTML = '关闭';
            back.href = 'javascript:window.close()';
        }
    </script>
@endsection

