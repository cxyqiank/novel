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
                揽阅后台--小说上传
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">小说管理</a></li>
                <li class="am-active">小说添加</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 表单
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
                            <form class="am-form tpl-form-line-form" action="{{url('admin/novel/add')}}" enctype="multipart/form-data" method="post">
                                <div class="am-form-group">
                                    {{csrf_field()}}
                                    <label for="name" class="am-u-sm-3 am-form-label">小说名字 <span class="tpl-form-line-small-title">Title</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="name" name="name" placeholder="请输入小说名字">
                                        <small>小说名字在5-20个字之间</small>
                                    </div>
                                </div>

                                
                                <div class="am-form-group">
                                    <label for="novel_desc" class="am-u-sm-3 am-form-label">小说简介</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="" rows="10" id="desc" name="desc" placeholder="小说简介"></textarea>
                                    </div>
                                </div>
                                
                                <div class="am-form-group">
                                    <label for="cart_id" class="am-u-sm-3 am-form-label">分类 <span class="tpl-form-line-small-title">cart</span></label>
                                    <div class="am-u-sm-9">

                                            @foreach($data as $v)
                                            <label class="am-checkbox-inline" for="cart_{{$v['id']}}" >
                                                <input  class="am-u-sm-6" type="checkbox" name="cart_id" id="cart_{{$v['id']}}" value="{{$v['id']}}">{{$v['name']}}
                                            </label>
                                            @endforeach


                                    </div>
                                </div>


                                <div class="am-form-group">
                                    <label for="author" class="am-u-sm-3 am-form-label">小说作者 <span class="tpl-form-line-small-title">author</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="author" name="author" placeholder="请输入小说作者">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="pic" class="am-u-sm-3 am-form-label">封面图 <span class="tpl-form-line-small-title">Images</span></label>
                                    <div class="am-u-sm-9">
                                        <div class="am-form-group am-form-file">
                                            <div class="tpl-form-file-img">
                                                <img src="../../../public/novel/img/a5.png" alt="">
                                            </div>
                                            <button type="button" class="am-btn am-btn-danger am-btn-sm">
    <i class="am-icon-cloud-upload"></i> 添加封面图片</button>
                                            <input id="doc-form-file" type="file" name="pic" multiple>
                                        </div>

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
