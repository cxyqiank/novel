@section('head')
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>揽阅后台管理系统</title>
    <meta name="description" content="">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="{{asset('novel/img/logo.png')}}">
    <link rel="stylesheet" href="{{asset('novel/css/amazeui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('novel/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('novel/css/app.css')}}">
</head>
@show
<body data-type="@yield('data-type')">
@section('side-bar')
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <img src="{{asset('novel/img/logo.png')}}" alt="" style="height:90px;width:120px;border:1px solid #ccc;box-shadow:2px 2px #ccc;">
            </a>
        </div>
        <!-- 显示隐藏侧边栏 -->
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">

        </div>

        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

            <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
                <li class="am-hide-sm-only">
                    <a href="javascript:;" id="admin-fullscreen" class="tpl-header-list-link">
                        <span class="am-icon-arrows-alt"></span>
                        <span class="admin-fullText">开启全屏</span>
                    </a>
                </li>

                <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                    <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                        <span class="tpl-header-list-user-nick">{{Session::get('admin.admin')}}</span>
                        <span class="tpl-header-list-user-ico"> <img src="../../../public/novel/img/user01.png"></span>
                    </a>
                    <ul class="am-dropdown-content">
                        <li><a href="#"><span class="am-icon-bell-o"></span> 资料</a></li>
                        <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
                        <li><a href="#"><span class="am-icon-power-off"></span> 退出</a></li>
                    </ul>
                </li>
                <li><a href="{{url('admin\logout')}}" class="tpl-header-list-link"><span class="am-icon-sign-out tpl-header-list-ico-out-size"></span></a></li>
            </ul>
        </div>
    </header>
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                揽阅列表
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">

                    <li class="tpl-left-nav-item">
                        <a href="{{url('admin')}}" class="nav-link active">
                            <i class="am-icon-home"></i>
                            <span>首页</span>
                        </a>
                    </li>

                    @can('pernovel',$user)
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-bookmark"></i>
                            <span>小说管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin\novel\lists')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>小说列表</span>
                                </a>

                                <a href="/admin/novel/add/{{session('admin.id')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>小说上传</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('info',$user)
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-picture-o"></i>
                            <span>轮播图管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin\banner\info')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>轮播图列表</span>
                                </a>

                                <a href="{{url('admin\banner\add')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>轮播图添加</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-camera"></i>
                            <span>分类管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin\cart\info')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>分类列表</span>
                                </a>

                                <a href="{{url('admin\cart\add')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>分类发布</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-wpforms"></i>
                            <span>公告管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin\notice\info')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>公告列表</span>
                                </a>

                                <a href="{{url('admin\notice\add')}}">
                                    <i class="am-icon-angle-right"></i>
                                    <span>公告发布</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('users',$user)
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-user-md"></i>
                            <span>用户管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin\info')}}">
                                    <i class="am-icon-user"></i>
                                    <span>用户列表</span>
                                </a>

                                <a href="{{url('admin\add')}}">
                                    <i class="am-icon-user-plus"></i>
                                    <span>用户添加</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-users"></i>
                            <span>角色管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin/role-info')}}">
                                    <i class="am-icon-user"></i>
                                    <span>角色列表</span>
                                </a>

                                <a href="{{url('admin/role-add')}}">
                                    <i class="am-icon-user-plus"></i>
                                    <span>角色添加</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-cogs"></i>
                            <span>权限管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="{{url('admin/permission')}}">
                                    <i class="am-icon-cogs"></i>
                                    <span>权限列表</span>
                                </a>

                                <a href="{{url('admin/permission/add')}}">
                                    <i class="am-icon-cog"></i>
                                    <span>权限添加</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
@show
@yield('content')
@section('js')
<script src="{{asset('novel/js/jquery.min.js')}}"></script>
<script src="{{asset('novel/js/amazeui.min.js')}}"></script>
<script src="{{asset('novel/js/iscroll.js')}}"></script>
<script src="{{asset('novel/js/app.js')}}"></script>
<script>
    var page = document.getElementsByClassName('pagination')[0];
    if(page){
        page.className += ' am-pagination tpl-pagination';
        $active = page.getElementsByClassName('active')[0];
        $active.style.color = '#fff';
        $span = $active.getElementsByTagName('span')[0];
        $span.style.background = '#20AAF0';
    }
</script>
@show
</body>

</html>