@extends('admin/base')

@section('app')
    <div class="col visi all">
        <div class="row x1">
            <div class="label free with-icon as-hd">
                <i></i>
                <span>账号设置</span>
            </div>
        </div>
    </div>
    <div class="col visi all margin-top content-container">
        <div class="info-frame">
            <div class="hd">
                账号信息
            </div>
            <div class="row x1 wb">
                <div class="slice">
                    邮箱
                </div>
                <div class="slice content" id="account-setting-email">

                </div>
            </div>

            <div class="row ">
                <div class="slice">
                    密码
                </div>
                <div class="slice content">
                    ********
                </div>
                <div class="slice va">
                    <a href="javascript:;" id="ank-passwd">修改</a>
                </div>
            </div>

        </div>
    </div>

    <div class="window-frame password-modify-frame" id="password-modify-frame">
        <div class="close" id="wf-close-pmf">
            <span class="icon-remove"></span>
        </div>
        <div class="title">
            修改密码
        </div>
        <div class="content">
            <div class="row x1">
                <div class="col pmf-left">
                    <div class="label free right-align right">
                        原密码
                    </div>
                </div>
                <div class="col pmf-right">
                    <input type="password" class="input x3" id="ipt-pmf-oldpass">
                </div>
            </div>
            <div class="row x1">
                <div class="col pmf-left">
                    <div class="label free right-align right">
                        新密码
                    </div>
                </div>
                <div class="col pmf-right">
                    <input type="password" class="input x3" id="ipt-pmf-newpass">
                </div>
            </div>
            <div class="row margin-bottom">
                <div class="col pmf-right">
                    <div class="half-line-tips">
                        请输入6~18位新密码
                    </div>
                </div>
            </div>
            <div class="row x1">
                <div class="col pmf-left">
                    <div class="label free right-align right">
                        确认密码
                    </div>
                </div>
                <div class="col pmf-right">
                    <input type="password" class="input x3" id="ipt-pmf-cfmpass">
                </div>
            </div>
            <div class="row x1">
                <div class="center-tips" id="tips-pmf-result">

                </div>
            </div>
        </div>
        <div class="ctrl">
            <div class="button-frame">
                <div class="button blue margin-right with-icon" id="btn-pmf-done">
                    <i class="icon-ok"></i>
                    <span>确定</span>
                </div>
                <div class="button margin-left with-icon" id="btn-pmf-cancel">
                    <span>取消</span>
                    <i class="icon-remove"></i>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('moduleStyles')
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/admin/less/accountSetting.css?v={{$version}}">
@endpush

@push('moduleScripts')
    <script src="{{$app_url}}/static/core/js/md5.js?v={{$version}}"></script>
    <script src="{{$app_url}}/static/admin/js/accountSetting.js?v={{$version}}"></script>

@endpush