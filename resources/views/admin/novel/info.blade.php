
@extends('admin.main')
@section('head')
    @parent
    <script src="{{asset('novel/js/echarts.min.js')}}"></script>
@endsection
@section('data-type','index')


@section('side-bar')
    @parent
@endsection


@section('content')

        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                揽阅后台管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">小说</a></li>
                <li><a href="#">详情</a></li>
                <li class="am-active">{{$data['name']}}</li>
            </ol>
            <div class="row">
                <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                    <div style="float: left">
                        <img src="{{asset($data['pic'])}}" alt="{{$data['name']}}" width="320" height="400">
                        <h2>{{$data['name']}}</h2>
                        <p><b>作者：</b>{{$data['author']}}</p>
                        <p><b>分类：</b>{{$data['cname']}}</p>
                        <p><b>简介：</b>{{$data['desc']}}</p>
                        <p><b>发布日期：</b>{{date('Y-m-d',strtotime($data['created_at']))}}</p>
                        <p><b>更新日期：</b>{{date('Y-m-d',strtotime($data['updated_at']))}}</p>
                        <p><b>状态：</b>{{($data['status'])?$data['sections'].'章已完结':$data['sections'].'章持续更新中'}}</p>
                        <h4>章节:</h4>
                        <div style="float: left!important;" class="actions">
                            <ul style="float: left!important;" class="actions-btn am-u-lg-12 am-u-md-12 am-u-sm-12">
                                @foreach($data['section'] as $k=>$v)
                                    <li class="blue" style="float: left!important; margin:2px 6px">
                                        <button type="button" style="border:none;background:rgba(0,0,0,0);" data-am-modal="{target: '#my-popup'}">
                                            <a class="sections" section ="{{$k}}" data="{{$v['address']}}"name="{{$v['section_name']}}">{{$v['section_name']}}</a>
                                        </button>

                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        <div class="am-popup" id="my-popup" style="height:80%;width:40%; ">
                            <div class="am-popup-inner">
                                <div class="am-popup-hd">
                                    <h4 class="am-popup-title" id="title">...</h4>
                                    <span data-am-modal-close
                                          class="am-close">&times;</span>
                                </div>
                                <div class="am-popup-bd" id="content">
                                    ...
                                </div>
                                <div class="am-popup-fd center-block">
                                    <div id="novel_prev" class="am-u-lg-offset-0 am-datepicker-prev-icon"></div>
                                    <div id="novel_next" class="am-u-lg-offset-6 am-datepicker-next-icon"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="am-u-lg-4 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="am-icon-comments-o"></i>
                        </div>
                        <div class="details">
                            <div class="number"> {{$data['hots']['visitors']}} </div>
                            <div class="desc"> 阅读量 </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-lg-4 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="am-icon-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number"> {{$data['hots']['collectors']}} </div>
                            <div class="desc"> 收藏量 </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-lg-4 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="am-icon-save"></i>
                        </div>
                        <div class="details">
                            <div class="number"> {{count($data['section'])}} </div>
                            <div class="desc"> 章节数量 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    @parent
    <script>
        $(".blue a").click(function(){
            var url = '/admin/novel/show';
            var status = 'now';
            window.ad = $(this).attr('data');
            window.section = $(this).attr('section');
            var data = "ad=http://www.app.com/"+window.ad+'&section='+window.section+'&page=0';
            that = $(this);
            $.get(url,data,function(res){
                $('#title').html(that.prop('name'));
                $('#content').html(res.content);
                window.page = res.page;
            });
        });
        $("#novel_next").click(function(){

            var url = '/admin/novel/show';
            window.page ++;
            var data = "ad=http://www.app.com/"+window.ad+"&section="+window.section+"&page="+window.page;
            that = $(this);
            $.get(url,data,function(res){
                if(res.content==='')
                {
                    window.section++;
                    window.page = -1;
                    return;
                }
                $('#title').html(that.prop('name'));
                $('#content').html(res.content);
                window.page = res.page;
            });
        });
        $("#novel_prev").click(function(){
            var url = '/admin/novel/show';
            window.page--;
            var data = "ad=http://www.app.com/"+window.ad+"&section="+window.section+"&page="+(window.page);
            that = $(this);
            $.get(url,data,function(res){
                if(res.content==='')
                {
                    window.section--;
                    window.page = -1;
                    return;
                }
                $('#title').html(that.prop('name'));
                $('#content').html(res.content);
                window.page = res.page;
            });
        });
    </script>
@endsection


