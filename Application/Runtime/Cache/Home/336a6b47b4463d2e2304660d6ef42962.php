<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>轩辕秘境</title>
	<link rel="shortcut icon" href="/Public/image/favicon.ico">
	<script src="/Public/jquery/jquery.min.js"></script>
	<link href="/Public/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- include libraries(jQuery, bootstrap, fontawesome) -->
	<link rel="stylesheet" href="/Public/font-awesome-4.2.0/css/font-awesome.min.css" />

	<!-- include summernote css/js-->
	<link href="/Public/dist/css/summernote.css" rel="stylesheet">
	<script src="/Public/dist/js/summernote.min.js"></script>

	<link href="/Public/pagecss/Common/page.css" rel="stylesheet">
	<link href="/Public/pagecss/Home/home.css" rel="stylesheet">
	
	<script src="/Public/pagejs/Home/home.js"></script>

</head>
<body class="harveyprince">
	<div class="hot-question-list">
		<div class="list-group">
			<?php if(is_array($hot_question_list)): $i = 0; $__LIST__ = $hot_question_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$singlequestion): $mod = ($i % 2 );++$i; echo W('Home/questionitem',array($singlequestion['id'])); endforeach; endif; else: echo "" ;endif; ?>
			<div class="hot-question-icon pageicon"></div>
		</div>
	</div>
	<div class="cover">
		<div class="centerbox">
			<div class="verticalcenter">
				
	<div class="box login">
		<div class="top-tip">
			<span class="operation-tip">注册帐号</span>
			<a href="javascript:void(0);" class="action-tip right">
				登录
				<span class="glyphicon glyphicon-circle-arrow-right"></span>
			</a>
		</div>
		<form class="signup-box">
			<input id="signup_surname" autocomplete="off" arja-haspopup="true" type="text" value class="form-text-input signupfirstname" placeholder="姓氏"></input>
			<input id="signup_purename" autocomplete="off" arja-haspopup="true" type="text" value class="form-text-input required signupname" placeholder="名称"></input>
			<input id="signup_email" autocomplete="off" arja-haspopup="true" type="email" value class="form-text-input required verticaldown" placeholder="邮箱"></input>
			<input id="signup_password" autocomplete="off" arja-haspopup="true" type="password" value class="form-text-input required verticaldown" placeholder="密码"></input>
			<div class="alarmbox signup"></div>
			<a href="javascript:void(0);" url="/User/Index/signupController" class="button-more btn-regist">注册</a>
		</form>
	</div>

				
	<div class="box signup active">
		<div class="top-tip">
			<span class="operation-tip">登录</span>
			<a href="javascript:void(0);" class="action-tip left">
				注册
				<span class="glyphicon glyphicon-circle-arrow-left"></span>
			</a>
		</div>
		<form class="signup-box">
			<input id="login_email" autocomplete="off" arja-haspopup="true" type="email" value class="form-text-input required verticaldown" placeholder="邮箱"></input>
			<input id="login_password" autocomplete="off" arja-haspopup="true" type="password" value class="form-text-input required verticaldown" placeholder="密码"></input>
			<div class="alarmbox login"></div>
			<a href="javascript:void(0);" url="/User/Index/loginController" class="button-more btn-login">登录</a>
		</form>
	</div>

			</div>
		</div>
		<div class="pageicon icon-head-page pagehead"></div>
		<div class="pageicon icon-text-page pagehead pagetext"></div>
	</div>
	
	<script src="/Public/dist/js/bootstrap.min.js"></script>
</body>
</html>