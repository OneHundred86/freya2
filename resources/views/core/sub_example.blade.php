
@extends('admin/base')

@section('app')
    <div class="col visi all">
        <div class="row x1">
            <div class="label free with-icon as-hd">
                <i></i>
                <span>子模块页面</span>
            </div>
        </div>
    </div>
    <div class="col visi all margin-top">
       <div class="main-list"></div>
    </div>
@endsection


@push('moduleStyles')
    {{--添加单独页面的css样式文件--}}
    {{-- <link rel="stylesheet" type="text/css" href="{{$app_url}}/address?v={{$version}}">--}}
@endpush

@push('moduleScripts')
    {{--添加单独页面的script样式文件--}}
    {{-- <link rel="stylesheet" type="text/css" href="{{$app_url}}/address?v={{$version}}">--}}
@endpush