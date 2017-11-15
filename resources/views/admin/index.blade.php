
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
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">app</a></li>
                <li class="am-active">数据统计</li>
            </ol>
            <div class="row">
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <i class="am-icon-cloud-download"></i>
                                <span> 书榜</span>
                            </div>
                            {{--<div class="actions">--}}
                                {{--<ul class="actions-btn">--}}
                                    {{--<li class="purple-on">昨天</li>--}}
                                    {{--<li class="green">前天</li>--}}
                                    {{--<li class="dark">本周</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        </div>
                        <div class="tpl-scrollable">

                            <table class="am-table tpl-table">
                                <thead>
                                <tr class="tpl-table-uppercase">
                                    <th>书名</th>
                                    <th>作者</th>
                                    <th>阅读量</th>
                                    <th>收藏量</th>
                                    <th>章节数目</th>
                                    <th>最后更新日期</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['novels'] as $novels)
                                <tr>
                                    <td>{{$novels->name}}</td>
                                    <td>{{$novels->author}}</td>
                                    <td>{{$novels->visitors}}</td>
                                    <td>{{$novels->collectors}}</td>
                                    <td>{{$novels->sections}}</td>
                                    <td>{{date('Y-m-d',strtotime($novels->updated_at))}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-red ">
                                <i class="am-icon-bar-chart"></i>
                                <span> 大大榜</span>
                            </div>
                            {{--<div class="actions">--}}
                                {{--<ul class="actions-btn">--}}
                                    {{--<li class="purple-on">昨天</li>--}}
                                    {{--<li class="green">前天</li>--}}
                                    {{--<li class="dark">本周</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        </div>
                        <div class="tpl-scrollable">
                            <table class="am-table tpl-table">
                                <thead>
                                    <tr class="tpl-table-uppercase">
                                        <th>笔名</th>
                                        <th>阅读量</th>
                                        <th>收藏量</th>
                                        <th>出书数目</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['authors'] as $author)
                                    <tr>
                                        <td>{{$author->author}}</td>
                                        <td>{{$author->vs}}</td>
                                        <td>{{$author->cs}}</td>
                                        <td class="font-green bold">{{$author->nums}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    @parent
@endsection


