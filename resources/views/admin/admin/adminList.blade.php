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
                揽阅后台--用户列表
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
                <li><a href="#">用户管理</a></li>
                <li class="am-active">用户列表</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-server"></span> 用户

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
                                    <button type="button" class="am-btn am-btn-default am-btn-success"><a href="/admin/add" style="color: #fff"><span class="am-icon-plus"></span> 新增</a></button>
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
                            <form class="am-form" >
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th class="table-check"><input type="checkbox" id="input-check-all" class="tpl-table-fz-check"></th>
                                            <th class="table-id">ID</th>
                                            <th class="table-title">用户名</th>
                                            <th class="table-set">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $v)
                                        <tr>
                                            <td><input class="deletes" name="ids" value="{{$v->id}}" type="checkbox"></td>
                                            <td>{{$v->id}}</td>
                                            <td>{{$v->name}}</td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                            <a href="{{url('admin/edit?id='.$v->id)}}">
                                                                <span class="am-icon-pencil-square-o"></span> 编辑</a>
                                                        </button>
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><a href="{{url('admin/delete?id='.$v->id)}}" onclick="javascript:confirm('确认删除?（不可恢复）');"><span class="am-icon-trash-o"></span> 删除</a></button>
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary">
                                                            <a href="{{url('admin/grant/'.$v->id)}}">
                                                                <span class="am-icon-pencil-square-o"></span> 分配角色</a>
                                                        </button>
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
    <!--全选-->
    <script>
        $(function(){
            $('#input-check-all').click(function () {
                $('.deletes').prop('checked', $(this).prop('checked'));
            })
        })
    </script>
@endsection



