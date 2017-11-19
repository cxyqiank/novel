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
                揽阅后台--banner列表
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">banner管理</a></li>
                <li class="am-active">banner列表</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-server"></span> banner
                        <small>前台默认显示前四张</small>
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
                                    <button type="button" class="am-btn am-btn-default am-btn-success"><a href="/admin/banner/add" style="color: #fff"><span class="am-icon-plus"></span> 新增</a></button>
                                    <button type="button" onclick="$('#del').submit()" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
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
                            <form class="am-form" id="del" action="/admin/banner/multiDel" method="post">
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                    {{csrf_field()}}
                                        <tr>
                                            <th class="table-check"><input type="checkbox" id="all-del" class="tpl-table-fz-check"></th>
                                            <th class="table-id">ID</th>
                                            <th class="table-title">主题</th>
                                            <th class="table-type">图片</th>
                                            <th class="table-set">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $v)
                                        <tr>
                                            <td><input class="deletes" name="ids" value="{{$v->id}}" type="checkbox"></td>
                                            <td>{{$v->id}}</td>
                                            <td>{{$v->item}}</td>
                                            <td>
                                                <img style="width:160px;" src="{{asset($v->pic)}}" alt="11">
                                            </td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary"> <a href="{{url('admin/banner/up?id='.$v->id)}}"><span class="am-icon-pencil-square-o"></span> 编辑</a></button>
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">
                                                            <a href="{{url('admin/banner/delete?id='.$v->id)}}" class="singleDel"><span class="am-icon-trash-o"></span> 删除</a></button>
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
            $('#all-del').click(function(){
                $('.deletes').prop('checked',$(this).prop('checked'));
            })
        })
        $('.singleDel').click(function(){
            if(!confirm('确认删除?(不可恢复)')){
                return false;
            }
        });
    </script>
@endsection



