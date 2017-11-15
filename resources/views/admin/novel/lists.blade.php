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
                揽阅后台--小说列表
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">小说管理</a></li>
                <li class="am-active">小说列表</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-server"></span> 小说信息
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
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-save"></span> 保存</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-warning"><span class="am-icon-archive"></span> 审核</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-form-group">
                                <select data-am-selected="{btnSize: 'sm'}">
              <option value="option1">所有类别</option>
              <option value="option2">IT业界</option>
              <option value="option3">数码产品</option>
              <option value="option3">笔记本电脑</option>
              <option value="option3">平板电脑</option>
              <option value="option3">只能手机</option>
              <option value="option3">超极本</option>
            </select>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-input-group am-input-group-sm">
                                <input type="text" class="am-form-field">
                                <span class="am-input-group-btn">
            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="button"></button>
          </span>
                            </div>
                        </div>
                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <form class="am-form">
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th class="table-check"><input type="checkbox" class="tpl-table-fz-check"></th>
                                            <th class="table-id">ID</th>
                                            <th class="table-title">信息</th>
                                            <th class="table-type">简介</th>
                                            <th class="table-date am-hide-sm-only">修改日期</th>
                                            <th class="table-set">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $v)
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>{{$v->id}}</td>
                                            <td>
                                                <img style="width:160px;" src="{{asset($v->pic)}}" alt="11">
                                                <p>名字：{{$v->name}}</p>
                                                <p>作者：{{$v->author}}</p>
                                                <p>状态：{{($v->status)?$v->sections.'章已完结':$v->sections.'章持续更新中'}}</p>
                                                {{--<p>{{($v->stauts)?$v->sections.'章已完结':$v->sections.'章持续更新中'}}</p>--}}
                                            </td>
                                            <td class="am-hide-sm-only">{{$v->desc}}</td>
                                            <td class="am-hide-sm-only">{{$v->updated_at}}</td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary"><a href="{{url('admin/novel/update?id='.$v->id)}}"><span class="am-icon-pencil-square-o"></span> 编辑</a></button>

                                                        <button class="update am-btn am-btn-default am-btn-xs am-hide-sm-only am-text-success">
                                                            <a href="{{url('admin/novel/addSection?id='.$v->id.'&section='.$v->sections)}}">更新章节<span class="am-icon-upload"></span></a>
                                                        </button>
                                                        <button class="update am-btn am-btn-default am-btn-xs am-hide-sm-only am-text-success">
                                                            <a href="{{url('admin/novel/info?id='.$v->id)}}">详细信息<span class="am-icon-bars"></span></a>
                                                        </button>
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> <a href="{{url('admin/novel/delete?id='.$v->id)}}">删除</a></button>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{--分页--}}
                                <div class="am-cf">

                                    <div class="am-fr">
                                        {{ $data->links() }}
                                        {{--设置样式--}}
                                        <script>
                                            var page = document.getElementsByClassName('pagination')[0];
                                            page.className += ' am-pagination tpl-pagination';
                                            $active = page.getElementsByClassName('active')[0];
                                            $active.style.color = '#fff';
                                            $span = $active.getElementsByTagName('span')[0];
                                            $span.style.background = '#20AAF0';

                                        </script>

                                    </div>
                                </div>
                                <hr>

                            </form>
                        </div>

                    </div>
                </div>
                <div class="tpl-alert"></div>
            </div>
        </div>
@endsection
@section('js')
    @parent
    <script>
        $(function(){
            $(".update").click(function(){
                window.location.href="http://www.16xue.cn";
            });
        });

    </script>
@endsection



