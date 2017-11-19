@extends('admin.main')
@section('head')
    @parent
@endsection
@section('data-type','generalComponents')
@section('side-bar')
    @parent
@endsection
@section('content')
        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                揽阅后台--角色更新
            </div>
            <ol class="am-breadcrumb">
                <li><a href="/admin" class="am-icon-home">首页</a></li>
                <li><a href="/admin/role-info">角色管理</a></li>
                <li class="am-active">角色添加</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span>角色添加
                    </div>
                    <div class="tpl-portlet-input tpl-fz-ml">
                        <div class="portlet-input input-small input-inline">
                            <div class="input-icon right">
                                <i class="am-icon-search"></i>
                                <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
                        </div>
                    </div>


                </div>

                <div class="tpl-block">

                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            @if(session('msg'))
                                {{session('msg')}}
                            @endif
                            <form class="am-form tpl-form-line-form" action="" enctype="multipart/form-data" method="post">
                                <div class="am-form-group">
                                    {{--csrf攻击--}}
                                    {{csrf_field()}}
                                    <label for="name" class="am-u-sm-3 am-form-label">角色名</label>
                                    <div class="am-u-sm-9">
                                        <input  id="name" type="text" value="" name="name">
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="description" class="am-u-sm-3 am-form-label">角色描述</label>
                                    <div class="am-u-sm-9">
                                        <input  id="description" type="text" value="" name="description">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




@endsection
@section('js')
    @parent
@endsection
