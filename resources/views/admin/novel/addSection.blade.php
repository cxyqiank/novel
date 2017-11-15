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
                揽阅后台--小说更新
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">小说管理</a></li>
                <li class="am-active">章节添加</li>
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
                            @if(session('msg'))
                                {{session('msg')}}
                            @endif
                            <form class="am-form tpl-form-line-form" action="{{url('admin/novel/addSection/doAdd')}}" enctype="multipart/form-data" method="post">
                                <div class="am-form-group">
                                    {{--csrf攻击--}}
                                    {{csrf_field()}}
                                    {{--novel_id--}}
                                    <input type="hidden" name="novel_id" value={{$novel_id}}>
                                    {{--章节数--}}
                                    <input type="hidden" name="sections" value={{$sections}}>
                                    <label for="section_name" class="am-u-sm-3 am-form-label">章节名称 <span class="tpl-form-line-small-title">Title</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" id="section_name" name="section_name" placeholder="请输入章节名称">
                                        <small>章节名称在5-20个字之间</small>
                                    </div>
                                </div>

                                
                                <div class="am-form-group">
                                    <label for="" class="am-u-sm-3 am-form-label">章节内容</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="am-u-lg-offset-4" id="content" name="content" placeholder="章节内容"></textarea>
                                    </div>
                                    <script type="text/javascript" charset="utf-8" src="{{asset('novel/ueditor/ueditor.parse.js')}}"></script>
                                    <script type="text/javascript" charset="utf-8" src="{{asset('novel/ueditor/ueditor.config.js')}}"></script>
                                    <script type="text/javascript" charset="utf-8" src="{{asset('novel/ueditor/ueditor.all.js')}}"> </script>
                                    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                                    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                                    <script type="text/javascript" charset="utf-8" src="{{asset('novel/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                                    <script type="text/javascript">

                                        //实例化编辑器
                                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                                        var ue = UE.getEditor('content',{initialFrameWidth:800,initialFrameHeight:320,autoHeightEnabled: false});

                                    </script>
                                </div>
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                            完结章
                                                <input style="opacity: 1;" name="status" id="end" type="radio" value="1" class="am-radio-inline">
                                            </label>
                                        </button>
                                        <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                            <label for="up" class="am-icon-check">非完结章
                                                <input style="opacity: 1;" name="status" id="up" type="radio" value="0" class="am-radio-inline" checked>
                                            </label>
                                        </button>


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
