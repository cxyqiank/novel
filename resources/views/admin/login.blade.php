@extends('admin.main')
@section('data-type','login')
@section('side-bar')
@show
@section('content')
<div class="am-g myapp-login">
	<div class="myapp-login-logo-block  tpl-login-max">
		<div class="myapp-login-logo-text">
			<div class="myapp-login-logo-text">
				揽阅<span> 后台登录</span> <i class="am-icon-skyatlas"></i>
				
			</div>
		</div>

		<div class="login-font">
			<i>Log In </i> or <span> Sign Up</span>
		</div>
		<div class="am-u-sm-10 login-am-center">
			<form class="am-form" action="{{url('admin/doLogin')}}" method="post">
				<fieldset>
					<div class="am-form-group">
						<input type="text" class="" id="admin" name="admin" value="{{(session('admin'))?:''}}" placeholder="输入用户名">
					</div>
					<div class="am-form-group">
						<input type="password" class="" id="pwd" name="pwd" placeholder="密码">
					</div>
					<div class="am-form-group">
						<input type="text" style="width:55%;display:inline-block;" id="captcha" name="captcha" placeholder="验证码">
						<img style="margin-left:10px;width:40%;" src="{{url('/admin/captcha/2')}}" onclick="this.src='/admin/captcha/'+new Date().getTime();" alt="">
					</div>
					<p style="color: #ff6666; font-weight: bold">
						@if(session('msg'))
							{{session('msg')}}
						@endif
						@if(count($errors)>0)
								@foreach($errors->all() as $value)
									{{$value}}<br>
								@endforeach
						@endif
           			</p>
					{{csrf_field()}}
<p><button type="submit" class="am-btn am-btn-default">登录</button></p>

</fieldset>
<p>信息管理员：admin_info 密码：12345678</p>
<p>小说管理员：admin_author 密码：12345678</p>
<p>管理员：admin_root 密码：admin123</p>
</form>
</div>
</div>
</div>
@endsection

