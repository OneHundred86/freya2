@extends('admin/base')

@section('app')
    <div class="col visi all">
        <div class="row x1">
            <div class="label free with-icon as-hd">
                <i></i>
                <span>用户组</span>
            </div>
            <div class="col right margin-right">
                <div class="button slim with-icon circle ft blue" data-flex="添加用户组" id="btn-add">
                    <i class="entypo-icon-plus"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col visi all margin-top">
        <div class="group-list" id="group-list">

        </div>
    </div>
    <div class="tpl" id="tpl">
        <div class="item" data-node="dwGroupItem">
            <div class="prefix"></div>
            <div class="name" data-node="dwName"></div>
            <div class="ctrl">
                <div class="ctrl-item ft" data-action="edit" data-flex="修改名称">
                    <i class="entypo-icon-pencil"></i>
                </div>
                <div class="ctrl-item ft" data-action="priv" data-flex="角色/权限">
                    <i class="entypo-icon-key"></i>
                </div>
                <div class="ctrl-item ft" data-action="remove" data-flex="删除用户组">
                    <i class="icon-trash"></i>
                </div>
            </div>
            <div class="priv-frame" data-node="dwPrivFrame">
                <div class="hd">
                    <span>角色列表</span>
                    <div class="ctrl-item add-char ft" data-flex="添加" data-action="addchar">
                        <i class="entypo-icon-plus"></i>
                    </div>
                </div>
                <div class="char-list" data-node="dwCharList">

                </div>
            </div>
        </div>
        <div class="char-item" data-node="dwCharItem">
            <div class="name" data-node="dwName"></div>
            <div class="remove-char">
                <i class="icon-trash"></i>
            </div>
        </div>
    </div>
@endsection


@push('moduleStyles')
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/admin/less/usergroup.css?v={{$version}}">
@endpush

@push('moduleScripts')
    <script src="{{$app_url}}/static/admin/js/usergroup.js?v={{$version}}"></script>
@endpush