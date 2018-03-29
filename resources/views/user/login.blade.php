@extends('core/base')

@section('app')
    <form> {{ csrf_field() }}</form>
<div class="page-section">
    <div class="login-frame">
        <div class="row x1 margin-top">
            <div class="tab-bar">
                <div class="tab selected">
                    <i class="entypo-icon-user"></i>
                    <span>登录</span>
                </div>
            </div>
        </div>

        <div class="row x1">
            <div class="textbox margin-left margin-right" id="tb-email">
                <div class="label">
                    登录邮箱
                </div>
                <input type="text">
            </div>
        </div>
        <div class="tip single-line margin-left" id="tips-email"></div>
        <div class="row x1">
            <div class="textbox margin-left margin-right" id="tb-password">
                <div class="label">
                    密码
                </div>
                <input type="password">
            </div>
        </div>
        <div class="tip single-line margin-left" id="tips-password"></div>
        <div class="row x1">
            <div class="vericode textbox margin-left margin-right" id="tb-vericode">
                <div class="label">
                    验证码
                </div>
                <img/>
                <input type="text">
            </div>
        </div>
        <div class="tip single-line margin-left" id="tips-login"></div>
        <div class="row x1">
            <div class="toggle" id="toggle-remember"></div>
            <div class="label free">
                记住登录状态
            </div>
            <div class="button right margin-right with-icon blue" id="btn-login">
                <span>登录</span>
                <i class="entypo-icon-right-circled"></i>
            </div>
        </div>
    </div>
</div>
@endsection


@push('moduleStyles')
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/core/less/ui.vericode.css?v={{$version}}">
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/user/less/login.css?v={{$version}}">
@endpush

@push('moduleScripts')
    <script src="{{$app_url}}/static/core/js/md5.js?v={{$version}}"></script>
    <script src="{{$app_url}}/static/core/js/ui.vericode.js?v={{$version}}"></script>
    <script src="{{$app_url}}/static/user/js/login.js?v={{$version}}"></script>
@endpush