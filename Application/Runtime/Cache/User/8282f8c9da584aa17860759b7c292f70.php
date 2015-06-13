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
	<script src="/Public/pagejs/Common/questionpage.js"></script>
	<script src="/Public/pagejs/Common/page.js"></script>
	
	<link href="/Public/pagecss/User/user.css" rel="stylesheet">
	<link href="/Public/pagecss/Question/questionMain.css" rel="stylesheet">

	
	<script src="/Public/pagejs/User/user.js"></script>
	<script src="/Public/pagejs/Question/questionMain.js"></script>

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
						<span class="name"><?php echo W('User/getUserNameBySession');?></span>
						<img class="avatar" src="<?php echo W('User/getUserHeadIconBySession');?>">
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

	<div class="page-main">
		<div class="page-content">
			<div class="page-content-inner">
				<div class="profile-header">
					<div class="profile-header-main">
						<div class="top">
							<div class="topdescribe">
								<span class="name"><?php echo W('User/getUserNameByID',array($aid));?></span>
								，
								<span class="info-wrap persondes">
									
									<?php if(W('User/getUserInfoByID',array($aid))['short_description'] == null): ?><span class="short_descriptionInfo">请用一句话描述（20字内）</span>
										<?php else: ?><span class="short_descriptionInfo"><?php echo W('User/getUserInfoByID',array($aid))['short_description'];?></span><?php endif; ?>
									<?php if(!$userpage): ?><a href="javascript:;" onclick="editinfo_persondes()" class="edit-button">
										<span>修改</span>
									</a><?php endif; ?>
								</span>
								<?php if(!$userpage): ?><span class="edit-wrap persondes" style="display:none;">
									<span class="topic-input-wrap">
										<input autocomplete="off" arja-haspopup="true" type="text" name="persondes" value class="form-text-input persondes short_descriptionupbox" placeholder="一句话描述" arja-label="一句话描述"></input>
									</span>
									<a href="javascript:;" url="/User/Index/saveInfoPersondes" onclick="saveinfo_persondes(this)" class="btn-blue">确定</a>
								</span><?php endif; ?>
							</div>
						</div>
						<div class="clearfix">
							<div class="profile-header-avatar-container">
								<img alt="<?php echo W('User/getUserNameByID',array($aid));?>" src="<?php echo W('User/getUserHeadIcon',array($aid));?>" class="profile-header-img">
								<?php if(!$userpage): ?><a data-target="#headModal" data-toggle="modal" class="head-avatar-edit-button change-head-icon">修改头像</a>
								<!-- Button trigger modal -->
								<!-- Modal -->
								<div class="modal fade" id="headModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myModalLabel">修改头像</h4>
											</div>
											<div class="modal-body">
												<form class="fileform" role="form" method="post" action="http://upload.qiniu.com" enctype="multipart/form-data" target="hidden_frame">
													<input id="uploadfile" type="file" name="file" accept="image/*">
													<input type="hidden" name="token" value="<?php echo ($token); ?>">
													<input type="hidden" name="key" id="formkey">
													<iframe name='hidden_frame' id="hidden_frame" style='display:none'></iframe>
												</form>
												<button url-head="<?php echo ($url_head); ?>" class="filebtn btn btn-success" user-id="<?php echo ($aid); ?>"><i class="fa fa-spinner fa-spin uploading-icon"></i><span class="upload-text">上传头像</span></button>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default modal-cancel" data-dismiss="modal" url="<?php echo U('/User/Index/deleteHeadIcon');?>">取消操作</button>
												<button type="button" class="btn btn-primary modal-sure" url="<?php echo U('/User/Index/saveHeadIcon');?>">确定设定</button>
											</div>
										</div>
									</div>
								</div><?php endif; ?>

							</div>
							<div class="profile-header-info">
								<div class="profile-header-info-inner">
									<div class="items">
										<div class="item">
											<span class="glyphicon glyphicon-globe icon-nav"></span>
											<span class="info-wrap location">
												<span class="location item">

													<?php if(W('User/getUserInfoByID',array($aid))['location'] == null): ?><a class="link-blue-normal locationInfo" href="">居住地</a>
														<?php else: ?>
														<a class="link-blue-normal locationInfo" href=""><?php echo W('User/getUserInfoByID',array($aid))['location'];?></a><?php endif; ?>
												</span>
												<span class="business item">
													<?php if(W('User/getUserInfoByID',array($aid))['subject'] == null): ?><a class="topic-link subjectInfo" href="">学科专业</a>
														<?php else: ?>
														<a class="topic-link subjectInfo" href=""><?php echo W('User/getUserInfoByID',array($aid))['subject'];?></a><?php endif; ?>
												</span>
												<?php if(W('User/getUserInfoByID',array($aid))['sex'] == null): ?><span class="item small-text sexInfo">性别</span>
													<?php else: ?><span class="item small-text sexInfo"><?php echo W('User/getUserInfoByID',array($aid))['sex'];?></span><?php endif; ?>
												<?php if(!$userpage): ?><a href="javascript:;" onclick="editinfo_location()" class="edit-button">
													<span>修改</span>
												</a><?php endif; ?>
											</span>
											<?php if(!$userpage): ?><span class="edit-wrap location" style="display:none;">
												<span class="topic-input-wrap">
													<input autocomplete="off" arja-haspopup="true" type="text" name="location" value class="form-text-input location locationupbox" placeholder="居住地" arja-label="居住地"></input>
												</span>
												<div class="business-selection">
													<select name=​"business" class="subjectupbox">​
														<?php echo W('User/businessoption');?>
													</select>​
												</div>
												<span class="zig-bull">|</span>
												<input type="radio" checked="checked" sex="男" class="male">
												男
												<input type="radio" sex="女" class="female">
												女
												<a href="javascript:;" url="/User/Index/saveInfoLocation" onclick="saveinfo_location(this)" class="btn-blue">确定</a>
											</span><?php endif; ?>
										</div>
										<div class="item">
											<span class="glyphicon glyphicon-briefcase icon-nav"></span>
											<span class="info-wrap school">
												<span class="location item">
													<?php if(W('User/getUserInfoByID',array($aid))['school'] == null): ?><a class="link-blue-normal schoolInfo" href="">学校</a>
														<?php else: ?><a class="link-blue-normal schoolInfo" href=""><?php echo W('User/getUserInfoByID',array($aid))['school'];?></a><?php endif; ?>
												</span>
												<span class="business item">
													<?php if(W('User/getUserInfoByID',array($aid))['academy'] == null): ?><a class="topic-link academyInfo" href="">学院</a>
														<?php else: ?><a class="topic-link academyInfo" href=""><?php echo W('User/getUserInfoByID',array($aid))['academy'];?></a><?php endif; ?>
												</span>
												<?php if(!$userpage): ?><a href="javascript:;" onclick="editinfo_school()" class="edit-button">
													<span>修改</span>
												</a><?php endif; ?>
											</span>
											<?php if(!$userpage): ?><span class="edit-wrap school" style="display:none;">
												<span class="topic-input-wrap">
													<input autocomplete="off" arja-haspopup="true" type="text" name="school" value class="form-text-input school schoolupbox" placeholder="<?php echo W('User/getUserInfoByID',array($aid))['school'];?>" arja-label="<?php echo W('User/getUserInfoByID',array($aid))['school'];?>"></input>
												</span>
												<span class="topic-input-wrap">
													<input autocomplete="off" arja-haspopup="true" type="text" name="academy" value class="form-text-input academy academyupbox" placeholder="<?php echo W('User/getUserInfoByID',array($aid))['academy'];?>" arja-label="<?php echo W('User/getUserInfoByID',array($aid))['academy'];?>"></input>
												</span>
												<a href="javascript:;" url="/User/Index/saveInfoSchool" onclick="saveinfo_school(this)" class="btn-blue">确定</a>
											</span><?php endif; ?>
										</div>
									</div>
									<div class="profile-header-description">
										<span class="info-wrap description">
											<div class="fold-item">
												<?php if(W('User/getUserInfoByID',array($aid))['long_description'] == null): ?><span class="content long_descriptionInfo">个人详细描述</span>
													<?php else: ?><span class="content long_descriptionInfo"><?php echo W('User/getUserInfoByID',array($aid))['long_description'];?></span><?php endif; ?>

											</div>
											<?php if(!$userpage): ?><a href="javascript:;" onclick="editinfo_description()" class="edit-button">
												<span>修改</span>
											</a><?php endif; ?>
										</span>
										<?php if(!$userpage): ?><span class="edit-wrap description" style="display:none;">
											<div class="edit-description">
												<div class="edit-description-inner form-text-input clearfix">
													<?php if(W('User/getUserInfoByID',array($aid))['long_description'] == null): ?><textarea name="description" value class="description long_descriptionupbox" style="white-space:pre;">请详细描述</textarea>
														<?php else: ?>
														<textarea name="description" value class="description long_descriptionupbox" style="white-space:pre;"><?php echo W('User/getUserInfoByID',array($aid))['long_description'];?></textarea><?php endif; ?>

												</div>
											</div>
											<a href="javascript:;" url="/User/Index/saveInfoDescription" onclick="saveinfo_description(this)" class="btn-blue">确定</a>
										</span><?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="profile-header-operation">
						<div class="profile-header-info-list">
							<span class="profile-header-info-title">获得</span>
							<span class="profile-header-user-agree">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								<strong><?php echo W('User/getUserAgreeVoteByID',array($aid));?></strong>
								赞同
							</span>
							<span class="profile-header-user-disagree">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								<strong><?php echo W('User/getUserDisagreeVoteByID',array($aid));?></strong>
								反对
							</span>
						</div>
						<a href="<?php echo U('/Question/Index/questionhelp').'#score';?>" class="score">积分:<?php echo W('User/getUserScoreByID',array($aid));?></a>
					</div>
					<div class="profile-navbar clearfix">
						<?php if(!$userpage): ?><a href="<?php echo U('/User/Index/index');?>" class="item <?php if($homeActive){echo 'active';} ?> first home">
							<span class="glyphicon glyphicon-home"></span>
						</a>
						<a href="<?php echo U('/User/Index/questionTab');?>" class="item <?php if($questionActive){echo 'active';} ?>">
							提问
							<span class="num"><?php echo W('User/getUserQuestionNumByID',array($aid));?></span>
						</a>
						<a href="<?php echo U('/User/Index/answerTab');?>" class="item <?php if($answerActive){echo 'active';} ?>">
							回答
							<span class="num"><?php echo W('User/getUserAnswerNumByID',array($aid));?></span>
						</a>
						<a href="<?php echo U('/User/Index/draftTab');?>" class="item <?php if($draftActive){echo 'active';} ?>">
							草稿
							<span class="num"><?php echo W('User/getUserDraftNumByID',array($aid));?></span>
						</a><?php endif; ?>
					<?php if($userpage): ?><a href="<?php echo U('/User/Index/userpage/user/'.$aid);?>" class="item <?php if($homeActive){echo 'active';} ?> first home">
							<span class="glyphicon glyphicon-home"></span>
						</a>
						<a href="<?php echo U('/User/Index/userpage_questionTab/user/'.$aid);?>" class="item <?php if($questionActive){echo 'active';} ?>">
							提问
							<span class="num"><?php echo W('User/getUserQuestionNumByID',array($aid));?></span>
						</a>
						<a href="<?php echo U('/User/Index/userpage_answerTab/user/'.$aid);?>" class="item <?php if($answerActive){echo 'active';} ?>">
							回答
							<span class="num"><?php echo W('User/getUserAnswerNumByID',array($aid));?></span>
						</a>
						<?php if(!$userpage): ?><a href="<?php echo U('/User/Index/userpage_draftTab/user/'.$aid);?>" class="item <?php if($draftActive){echo 'active';} ?>">
							草稿
							<span class="num"><?php echo W('User/getUserDraftNumByID',array($aid));?></span>
						</a><?php endif; endif; ?>
					</div>
				</div>
				<?php if(($homeActive OR $draftActive) and !$userpage): ?><div class="profile-section-wrap">
						<div class="profile-section-title">
							<a href="" class="profile-section-title-inner">
								<span class=​"profile-section-title-name">​草稿</span>​
								<span class="glyphicon glyphicon-chevron-right more-btn"></span>
							</a>
						</div>
						<div class="profile-section-list">
							<!-- draft item place -->
							<?php if(is_array($draftlist)): $i = 0; $__LIST__ = $draftlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$draftitem): $mod = ($i % 2 );++$i; echo W('User/getUserHomeDraft',array($draftitem['id'])); endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div><?php endif; ?>
				<?php if($homeActive OR $questionActive): ?><div class="profile-section-wrap">
						<div class="profile-section-title">
							<a href="" class="profile-section-title-inner">
								<span class=​"profile-section-title-name">​提问</span>​
								<span class="glyphicon glyphicon-chevron-right more-btn"></span>
							</a>
						</div>
						<div class="profile-section-list">
							<!-- question item place -->
							<?php if(is_array($questionlist)): $i = 0; $__LIST__ = $questionlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$questionitem): $mod = ($i % 2 );++$i; echo W('User/getUserHomeQuestion',array($questionitem['id'])); endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div><?php endif; ?>
				<?php if($homeActive OR $answerActive): ?><div class="profile-section-wrap">
						<div class="profile-section-title">
							<a href="" class="profile-section-title-inner">
								<span class=​"profile-section-title-name">​回答​</span>​
								<span class="glyphicon glyphicon-chevron-right more-btn"></span>
							</a>
						</div>
						<div class="profile-section-list">
							<!-- answer item place -->
							<?php if(is_array($answerlist)): $i = 0; $__LIST__ = $answerlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$answeritem): $mod = ($i % 2 );++$i; echo W('User/getUserHomeAnswer',array($answeritem['id'])); endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div><?php endif; ?>
			</div>
		</div>
		<div class="main-sidebar">
			<div class="side-section">
				<div class="side-section-inner">
					<div class="side-nav-group">
						<div class="profile-header profile-navbar clearfix">
						<?php if($_SESSION['harvey_user_id']> 0): ?><div class="box-sec">
							<div class="form-text-input">
							<textarea name="description" value="" class="word-box" style="white-space:pre;" placeholder="留下你想说的话吧～"></textarea>
							</div>
							<button aid="<?php echo ($aid); ?>" url="<?php echo U('/User/Index/submitWord');?>" class="top-add-question to-submit-question word-box-button" style="float:right;">留言</button>
							</div><?php endif; ?>
						<span class="box-label" page="0"><i class="fa fa-book fa-fw"></i>留言板</span>
						<?php if($_GET['user']> 0): ?><span class="page-controller page-right <?php echo ($rightable); ?>"><a href="/User/Index/index.html?page=<?php echo ($page+1); ?>&amp;user=<?php echo ($_GET['user']); ?>"><i class="fa fa-chevron-circle-right"></i></a></span>
						<?php if($page > 0): ?><span class="page-controller page-left <?php echo ($leftable); ?>"><a href="/User/Index/index.html?page=<?php echo ($page-1); ?>&amp;user=<?php echo ($_GET['user']); ?>"><i class="fa fa-chevron-circle-left"></i></a></span>
						<?php else: ?>
							<span class="page-controller page-left <?php echo ($leftable); ?>"><a href="/User/Index/index.html?page=0&amp;user=<?php echo ($_GET['user']); ?>"><i class="fa fa-chevron-circle-left"></i></a></span><?php endif; ?>
						<?php else: ?>
							<span class="page-controller page-right <?php echo ($rightable); ?>"><a href="/User/Index/index.html?page=<?php echo ($page+1); ?>"><i class="fa fa-chevron-circle-right"></i></a></span>
						<?php if($page > 0): ?><span class="page-controller page-left <?php echo ($leftable); ?>"><a href="/User/Index/index.html?page=<?php echo ($page-1); ?>"><i class="fa fa-chevron-circle-left"></i></a></span>
						<?php else: ?>
							<span class="page-controller page-left <?php echo ($leftable); ?>"><a href="/User/Index/index.html?page=0"><i class="fa fa-chevron-circle-left"></i></a></span><?php endif; endif; ?>
						
						<div class="profile-header profile-navbar clearfix">
							<?php if($wordlist): if(is_array($wordlist)): $i = 0; $__LIST__ = $wordlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$worditem): $mod = ($i % 2 );++$i; echo W('User/getUserHomeWord',array($worditem['id']));?>
									<div class="divider"></div><?php endforeach; endif; else: echo "" ;endif; ?>
							<?php else: ?>
								<?php if($page > 0): ?><span class="empty-box-text">后面没有啦～</span>
								<?php else: ?>
									<span class="empty-box-text">(つ﹏⊂)<br/>还没有留言哦～</span><?php endif; endif; ?>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<script src="/Public/dist/js/bootstrap.min.js"></script>
</body>
</html>