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
                                    <button type="button" class="am-btn am-btn-default am-btn-success"><a href="/admin/novel/add/{{session('admin.id')}}" style="color: #fff"><span class="am-icon-plus"></span> 新增</a></button>
                                    <button type="button" onclick="$('#del').submit()" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                                    @if(session('msg'))
                                        {{session('msg')}}
                                    @endif
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
                            <form class="am-form" id="del" action="/admin/novel/multiDel" method="post">
                                {{csrf_field()}}
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th class="table-check"><input type="checkbox" id="all-del" class="tpl-table-fz-check"></th>
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
                                            <td><input type="checkbox" class="deletes" name="ids[]" value="{{$v->id}}"></td>
                                            <td>{{$v->id}}</td>
                                            <td>
                                                <img style="width:160px;" src="{{asset($v->pic)}}" alt="11">
                                                <p>名字：{{$v->name}}</p>
                                                <p>作者：{{$v->author}}</p>
                                                <p>状态：{{($v->status)?$v->sections.'章已完结':$v->sections.'章持续更新中'}}</p>
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
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" type="button">
                                                            <a href="{{url('admin/novel/delete?id='.$v->id)}}" class="singleDel"><span class="am-icon-trash-o"></span> 删除</a></button>
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
    <script>
        $('#all-del').click(function(){
            $('.deletes').prop('checked',$(this).prop('checked'));
        });
        $('.singleDel').click(function(){
            if(!confirm('确认删除?(不可恢复)')){
                return false;
            }
        });
    </script>

@endsection



