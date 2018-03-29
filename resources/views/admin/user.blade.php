@extends('admin/base')

@section('app')
<div class="col visi all">
    <div class="row x1">
        <div class="label free with-icon blue">
            <i class="entypo-icon-users"></i>
            <span>用户列表</span>
        </div>
        <div class="col right margin-right">
            <input type="text" class="input x2 slim" id="ipt-search" placeholder="用户邮箱">
            <div class="button with-icon margin-left slim blue circle" id="btn-search">
                <i class="entypo-icon-search"></i>
            </div>
            <div class="button with-icon margin-left slim blue circle" id="btn-refresh">
                <i class="icon-refresh"></i>
            </div>
            <div class="button with-icon margin-left slim green circle ft" id="btn-add" data-flex="添加用户">
                <i class="entypo-icon-plus"></i>
            </div>
        </div>
    </div>
    <div class="row add-frame" id="add-frame">
        <div class="hor-split-margin"></div>
        <div class="col right">

            <div class="row x1">
                <div class="textbox" id="ipt-add-email">
                    <div class="label">
                        邮箱
                    </div>
                    <input type="text">
                </div>
            </div>
            <div class="row x1">
                <div class="textbox" id="ipt-add-password">
                    <div class="label">
                        密码
                    </div>
                    <input type="password">
                </div>
            </div>

            <div class="row x1">
                <div class="label free-right">
                    用户组
                </div>
                <div class="select" id="sel-add-group"></div>
            </div>
        </div>
        <div class="hor-split-margin"></div>
        <div class="row x1">
            <div class="col right margin-right">
                <div class="button slim group-left" id="btn-add-fold">
                    <span>收起</span>
                </div>
                <div class="button slim group-middle" id="btn-add-clear">
                    <span>清空表单</span>
                </div>
                <div class="button slim blue group-right" id="btn-add-save">
                    <span>添加</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col visi all margin-top">
    <div class="col left">
        <div class="group-list">
            <div class="hd">用户组</div>
            <div class="body" id="group-list">
                <div class="item search">
                    <i class="entypo-icon-search"></i>
                    <span>搜索结果</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col right">
        <div class="user-list" id="user-list">

        </div>
        <div class="simple-pages" id="sp-user-list"></div>
    </div>
</div>
<div class="tpl" id="tpl">
    <div class="item" data-node="dwGroupItem">
        <i class="icon-folder-open-alt"></i>
        <span data-node="dwName"></span>
    </div>
    <div class="item" data-node="dwUserItem">
        <div class="gd id" data-node="dwId"></div>
        <div class="gd username" data-node="dwUserName"></div>
        <div class="gd group" data-node="dwGroup"></div>
        <div class="ctrl" data-node="dwCtrl">
            <div class="ctrl-item ft" data-action="edit" data-flex="修改">
                <i class="icon-edit"></i>
            </div>
            <div class="ctrl-item ft" data-action="move" data-flex="移动">
                <i class="icon-exchange"></i>
            </div>
            <div class="ctrl-item ft" data-node="dwBan" data-action="ban" data-flex="封禁">
                <i class="icon-ban-circle"></i>
            </div>
            <div class="ctrl-item ft" data-action="remove" data-flex="删除">
                <i class="icon-trash"></i>
            </div>
        </div>
        <div class="col right edit-frame" data-node="dwEditFrame">

            <div class="row x1" data-node="dwRowPassword">
                <div class="textbox" data-node="dwTB">
                    <div class="label">
                        密码
                    </div>
                    <input type="password">
                </div>
            </div>

            <div class="row x1" data-node="dwRowGroup">
                <div class="label free-right">
                    用户组
                </div>
                <div class="select" data-node="dwSel"></div>
            </div>
            <div class="row x1" data-node="dwRowRegDate">
                <div class="label">
                    注册日期：
                </div>
                <div class="label free" data-node="dwText">

                </div>
            </div>

            <div class="row x1">
                <div class="col right">
                    <div class="button slim circle ft ctrl-item with-icon" data-flex="收起" data-action="fold">
                        <i class="entypo-icon-up-open"></i>
                    </div>
                    <div class="button slim circle ft ctrl-item with-icon margin-left blue" data-flex="保存" data-action="save">
                        <i class="icon-save"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('moduleStyles')
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/admin/less/user.css?v={{$version}}">
@endpush

@push('moduleScripts')
    <script src="{{$app_url}}/static/core/js/md5.js?v={{$version}}"></script>
    <script src="{{$app_url}}/static/admin/js/user.js?v={{$version}}"></script>
@endpush