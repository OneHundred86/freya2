
@extends('admin/base')

@section('app')
    <div class="col visi all">
        <div class="row x1">
            <div class="label free as-hd with-icon">
                <i></i>
                <span>角色与权限</span>
            </div>
            <div class="col right margin-right">
                <div class="row x1">
                    <div class="button circle margin-left slim blue with-icon ft" id="btn-add" data-flex="添加角色">
                        <i class="entypo-icon-plus"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col visi all margin-top">
        <div class="col left">
            <div class="character-list">
                <div class="hd">
                    角色列表
                </div>
                <div class="body" id="character-list">

                </div>
            </div>
        </div>
        <div class="col right">
            <div class="ca-list">
                <div class="hd">
                    <div class="ctrl">
                        <div class="ctrl-item ft" data-action="edit" data-flex="编辑名称" id="ctrl-edit">
                            <i class="entypo-icon-pencil"></i>
                        </div>
                        <div class="ctrl-item ft" data-action="remove" data-flex="删除角色" id="ctrl-remove">
                            <i class="icon-trash"></i>
                        </div>
                    </div>
                </div>
                <div class="body" id="ca-list">

                </div>
            </div>
        </div>
        <div class="row x1">

        </div>
    </div>
    <div class="tpl" id="tpl">
        <div class="item" data-node="dwCharacterItem">
            <i class="entypo-icon-dot"></i>
            <span data-node="dwName"></span>
        </div>
        <div class="group" data-node="dwCAListGroup">
            <div class="k" data-node="dwC"></div>
            <div class="k" data-node="dwDesc"></div>
            <div class="col right">
                <div class="btn-all">
                    <span>全选</span>
                </div>
                <div class="btn-rev">
                    <span>反选</span>
                </div>
            </div>
        </div>
        <div class="item" data-node="dwCAListItem">
            <div class="k" data-node="dwC"></div>
            <div class="k" data-node="dwA"></div>
            <div class="k" data-node="dwDesc"></div>
            <div class="toggle" data-node="dwToggle"></div>
        </div>
    </div>

@endsection


@push('moduleStyles')
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/admin/less/character.css?v={{$version}}">
@endpush

@push('moduleScripts')
    <script src="{{$app_url}}/static/admin/js/character.js?v={{$version}}"></script>
@endpush