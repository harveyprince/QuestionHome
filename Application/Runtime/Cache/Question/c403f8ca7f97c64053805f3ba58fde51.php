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

	
	<link href="/Public/pagecss/Common/page.css" rel="stylesheet">
	<link href="/Public/pagecss/Common/head-navbar.css" rel="stylesheet">
	<link href="/Public/pagecss/Common/side-nav.css" rel="stylesheet">
	<link href="/Public/pagecss/Common/tags.css" rel="stylesheet">
	<script src="/Public/pagejs/Common/questionpage.js"></script>
	<script src="/Public/pagejs/Common/page.js"></script>
	
	<link href="/Public/pagecss/Question/question.css" rel="stylesheet">
	<link href="/Public/pagecss/Question/questionhelp.css" rel="stylesheet">

	
	<script src="/Public/pagejs/Question/question.js"></script>

</head>
<body class="harveyprince">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="nav-brand navbar-brand" href="#"><span class="pageicon icon-head-page-mini top-nav-place"></span></a>
				<form action="<?php echo U('/Question/Index/Search');?>" class="search-form" style="width:367px;">
					<input name="search-key" type="text" class="form-control" placeholder="Search...">
					<button type="submit" class="magnify-button">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</form>
				<button link-address="<?php echo U('/Question/Index/toSubmitQuestion');?>" class="top-add-question to-submit-question">提问</button>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="<?php echo U('/Question/Index/index');?>">首页</a></li>
					<li><a href="<?php echo U('/Question/Index/help');?>">帮助</a></li>
				</ul>
			</div>
			<div class="nav-profile">
				<?php if($_SESSION['harvey_user_id']> 0): ?><a href="" class="nav-userinfo">
						<span class="name"><?php echo W('Question/getUserNameBySession');?></span>
						<img class="avatar" src="<?php echo W('Question/getUserHeadIconBySession');?>">
					</a>
					<u1 class="top-nav-dropdown nav">
						<li><a href="<?php echo U('/User/index');?>"><span class="glyphicon glyphicon-home icon-nav"></span>主页</a></li>
						<!-- <li><a href="#"><span class="glyphicon glyphicon-envelope icon-nav"></span>私信</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-cog icon-nav"></span>设置</a></li> -->
						<li class="divider"></li>
						<li><a href="<?php echo U('/User/Index/Logout');?>"><span class="glyphicon glyphicon-off icon-nav"></span>退出</a></li>
					</u1>
					<?php else: ?>
					<a href="" data-target="#loginModal" data-toggle="modal" class="nav-userinfo">
						<span class="name">登录/注册</span>
					</a>
					<!-- Button trigger modal --><?php endif; ?>
			</div>
		</div>
	</nav>
	<!-- header end -->
	<?php if(!($_SESSION['harvey_user_id']> 0)): ?><!-- Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">登录/注册</h4>
					</div>
					<div class="modal-body loginmodal">
						<span class="form-label">登录时无需填写姓名</span>
						<div class="box login active top-nav-login-modal">
							<form class="signup-box">
								<input id="signup_surname" autocomplete="off" arja-haspopup="true" type="text" value class="form-text-input signupfirstname" placeholder="姓氏"></input>
								<input id="signup_purename" autocomplete="off" arja-haspopup="true" type="text" value class="form-text-input required signupname" placeholder="名称"></input>
								<input id="email" autocomplete="off" arja-haspopup="true" type="email" value class="form-text-input required verticaldown" placeholder="邮箱"></input>
								<input id="password" autocomplete="off" arja-haspopup="true" type="password" value class="form-text-input required verticaldown" placeholder="密码"></input>
								<div class="alarmbox"></div>
								<a href="javascript:void(0);" url="/User/Index/signupController" class="button-more btn-regist top-nav-modal-button">注册</a>
								<a href="javascript:void(0);" url="/User/Index/loginController" class="button-more btn-login top-nav-modal-button">登录</a>
							</form>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default modal-cancel" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div><?php endif; ?>
	
	<div class="page-content" role="main">
		<div class="main-content">
			<div class="main-content-inner">
				<h1>网站说明</h1>
				<div class="divider"></div>
				<p>
					&nbsp; &nbsp;本网站是一个在线问答网站，用户可以在本网站提出问题、参与他人的问答、对回答进行进一步回复等。可以点赞支持问题或者回答。
				</p>
				<p>
					&nbsp; &nbsp;采用了summernote富文本编辑器
					。支持丰富的多媒体文件交互，图片文件采用了七牛云存储提供的开发者接口存储至七牛云。局部采用bootstrap和font-awsome进行了优化。
				</p>
				<p>
					&nbsp; &nbsp;出现问题请联系<a style="font-weight: bold;" href="<?php echo U('/User/Index/userpage/user/1');?>">网站管理员</a>
				</p>
				<div class="divider"></div>
				<h1 id="score">积分说明</h1>
				<div class="divider"></div>
				<p>
					&nbsp; &nbsp;<span style="font-weight: bold;">积分规则</span>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp;发布问题不增加积分，参与回答增加积分2，对回答发表意见增加积分1，
					得到他人一个点赞增加积分1（包括问题和回答），踩不扣分。
				</p>
				<p>
					&nbsp; &nbsp;<span style="font-weight: bold;">积分限制</span>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp;
					积分少于10分者一天内不得发布超过三条问题
				</p>
				<div class="divider"></div>
				<h1>常见问题</h1>
				<div class="divider"></div>
				<p>
					&nbsp; &nbsp;<span id="qa1" style="font-weight: bold;">1.为什么我的图片上传失败？</span>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp;
					这种问题可能有几种情况，请检查一下网络连接是否顺畅，图片文件过大等，如果都不符合可能是七牛云接口发生变动，请及时联系网站管理员。
				</p>
				<p>
					&nbsp; &nbsp;<span id="qa2" style="font-weight: bold;">2.为什么我发表问题失败？</span>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp;
					请注意积分规则，有单日的发表限制，如遇其它情况请联系网站管理员。
				</p>
				<p>
					&nbsp; &nbsp;<span id="qa3" style="font-weight: bold;">3.为什么我发表评论回答问题总是没有反应？</span>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp;
					请注意不要禁用js，同时所有的问题评论回答都不得少于15字。
				</p>
				<p>
					&nbsp; &nbsp;<span id="qa4" style="font-weight: bold;">4.为什么我的页面显示很奇怪？</span>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp;
					不同浏览器会有不同的显示效果，出现局部偏差属于正常现象，如果想要优化显示效果，请使用chrome浏览器访问本网站。
				</p>
				<div class="divider"></div>
			</div>
		</div>
		<div class="main-sidebar">
			<div class="side-section">
				<div class="side-section-inner">
					<div class="side-nav-group">
						<?php if($_SESSION['harvey_user_id']> 0): ?><u1 class="side-nav">
								<li class="side-nav-li">
									<a href="<?php echo U('/User/Index/draftTab');?>" class="side-nav-link">我的草稿</a>
								</li>
								<li class="side-nav-li">
									<a href="<?php echo U('/User/Index/questionTab');?>" class="side-nav-link">我的发布</a>
								</li>
								<li class="side-nav-li">
									<a href="<?php echo U('/User/Index/answerTab');?>" class="side-nav-link">我的回答</a>
								</li>
							</u1><?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div style="right: 400px; display: block;" class="back-to" id="toolBackTop">
		<a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top pageicon"></a>
	</div>
	<script src="/Public/dist/js/bootstrap.min.js"></script>
</body>
</html>