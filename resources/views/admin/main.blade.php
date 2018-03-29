
@extends('admin/base')

@section('app')
    <div class="col visi all">
        <div class="row x1">
            <div class="label free with-icon as-hd">
                <i></i>
                <span>概述页面</span>
            </div>
        </div>
    </div>
    <div class="col visi all margin-top">
       <div class="main-list">
           <div class="title">
               Main Page.
           </div>
       </div>
    </div>
@endsection


@push('moduleStyles')
    <link rel="stylesheet" type="text/css" href="{{$app_url}}/static/admin/less/main.css?v={{$version}}">
@endpush

@push('moduleScripts')
@endpush