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
                揽阅后台--权限分配
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">权限分配</a></li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span>权限分配
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
                            <p>角色名：{{$role->name}}</p>
                            <form class="am-form tpl-form-line-form" action="/admin/role/store/{{$role->id}}" enctype="multipart/form-data" method="post">

                                    {{--csrf攻击--}}
                                    {{csrf_field()}}
                                    @foreach($permissions as $v)
                                    <div class="am-form-group">
                                        <label for="permission_{{$v->id}}" class="am-u-sm-2 am-form-label text-center">
                                            <input type="checkbox" name="permissions[]" id="permission_{{$v->id}}" value="{{$v->id}}"
                                            @if($myPermissions->contains($v))checked
                                                    @endif>
                                            {{$v->name}}
                                        </label>
                                    </div>
                                    @endforeach

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
