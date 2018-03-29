<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    @include("admin/common_style")

    @stack('moduleStyles')

    @include("admin/common_script")

    @stack('moduleScripts')

</head>
<body>
<script>
    var _CSRF = '{{ csrf_token() }}';
</script>

@include("admin/header")
<div class="admin-menu" id="admin-menu">
    <div class="group">
        <div class="hd">
            <i class="entypo-icon-layout"></i>
            <span>系统 </span>
            <div class="fold">
                <i class="entypo-icon-up-open"></i>
            </div>
            <div class="unfold">
                <i class="entypo-icon-down-open"></i>
            </div>
        </div>
        <div class="field">
            <a class="item" data-c="admin" data-a="main">
                <span>概述</span>
            </a>
        </div>
    </div>
    <div class="group">
        <div class="hd">
            <i class="entypo-icon-user"></i>
            <span>用户与权限</span>
            <div class="fold">
                <i class="entypo-icon-up-open"></i>
            </div>
            <div class="unfold">
                <i class="entypo-icon-down-open"></i>
            </div>
        </div>
        <div class="field">
            <a class="item" data-c="admin" data-a="user">
                <span>用户管理</span>
            </a>
            <a class="item" data-c="admin" data-a="usergroup">
                <span>用户组管理</span>
            </a>
            {{--<a class="item" data-c="admin" data-a="auth">--}}
                {{--<span>权限列表</span>--}}
            {{--</a>--}}
            <a class="item" data-c="admin" data-a="character">
                <span>角色定义</span>
            </a>
        </div>
    </div>
    <a class="group single " data-c="admin" data-a="accountSetting" >
        <div class="hd">
            <i class="entypo-icon-cog"></i>
            <span>账号设置</span>
        </div>
    </a>
</div>
<div class="admin-page">
    @yield('app')
</div>

@include("core/tpl")
</body>
</html>