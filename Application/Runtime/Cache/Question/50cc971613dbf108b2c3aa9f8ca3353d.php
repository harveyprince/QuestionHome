<?php if (!defined('THINK_PATH')) exit();?><div class="profile-header">
	<div class="profile-header-main">
		<div class="top">
			<div class="topdescribe">
				<span class="name"><?php echo W('Question/getUserNameByID',array($id));?></span>
				，
				<span class="info-wrap persondes">
					<?php if(W('Question/getUserInfoByID',array($id))['short_description']): ?><span class="short_descriptionInfo"><?php echo W('Question/getUserInfoByID',array($id))['short_description'];?></span>	
					<?php else: ?>	
					<span class="short_descriptionInfo">暂无一句话介绍</span><?php endif; ?>			
				</span>
			</div>
		</div>
		<div class="clearfix">
			<div class="profile-header-avatar-container">
				<img alt="<?php echo W('Question/getUserNameByID',array($id));?>" src="<?php echo W('Question/getUserHeadIcon',array($id));?>" class="profile-header-img">

			</div>
			<div class="profile-header-info">
				<div class="profile-header-info-inner">
					<div class="items">
						<div class="item">
							<span class="glyphicon glyphicon-globe icon-nav"></span>
							<span class="info-wrap location">
								<span class="location item">

									<?php if(W('Question/getUserInfoByID',array($id))['location'] == null): ?><a class="link-blue-normal locationInfo" href="">居住地</a>
										<?php else: ?>
										<a class="link-blue-normal locationInfo" href=""><?php echo W('Question/getUserInfoByID',array($id))['location'];?></a><?php endif; ?>
								</span>
								<span class="business item">
									<?php if(W('Question/getUserInfoByID',array($id))['subject'] == null): ?><a class="topic-link subjectInfo" href="">学科专业</a>
										<?php else: ?>
										<a class="topic-link subjectInfo" href=""><?php echo W('Question/getUserInfoByID',array($id))['subject'];?></a><?php endif; ?>												
								</span>
								<?php if(W('Question/getUserInfoByID',array($id))['sex'] == null): ?><span class="item small-text sexInfo">性别</span>
									<?php else: ?><span class="item small-text sexInfo"><?php echo W('Question/getUserInfoByID',array($id))['sex'];?></span><?php endif; ?>																		
							</span>
						</div>
						<div class="item">
							<span class="glyphicon glyphicon-briefcase icon-nav"></span>
							<span class="info-wrap school">
								<span class="location item">
									<?php if(W('Question/getUserInfoByID',array($id))['school'] == null): ?><a class="link-blue-normal schoolInfo" href="">学校</a>
										<?php else: ?><a class="link-blue-normal schoolInfo" href=""><?php echo W('Question/getUserInfoByID',array($id))['school'];?></a><?php endif; ?>												
								</span>
								<span class="business item">
									<?php if(W('Question/getUserInfoByID',array($id))['academy'] == null): ?><a class="topic-link academyInfo" href="">学院</a>
										<?php else: ?><a class="topic-link academyInfo" href=""><?php echo W('Question/getUserInfoByID',array($id))['academy'];?></a><?php endif; ?>											
								</span>
							</span>
						</div>
					</div>
					<div class="profile-header-description">
						<span class="info-wrap description">
							<div class="fold-item">
								<?php if(W('Question/getUserInfoByID',array($id))['long_description'] == null): ?><span class="content long_descriptionInfo">个人详细描述</span>
									<?php else: ?><span class="content long_descriptionInfo"><?php echo W('Question/getUserInfoByID',array($id))['long_description'];?></span><?php endif; ?>
							</div>
						</span>
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
				<strong><?php echo W('Question/getUserAgreeVoteByID',array($id));?></strong>
				赞同
			</span>
			<span class="profile-header-user-disagree">
				<span class="glyphicon glyphicon-thumbs-down"></span>
				<strong><?php echo W('Question/getUserDisagreeVoteByID',array($id));?></strong>
				反对
			</span>
		</div>
		<a href="" class="score">积分:<?php echo W('Question/getUserScoreByID',array($id));?></a>
	</div>
	<div class="profile-navbar clearfix">
		<a href="<?php echo U('/User/Index/userpage/user/'.$id);?>" class="item first home">
			<span class="glyphicon glyphicon-home"></span>
		</a>
		<a href="<?php echo U('/User/Index/userpage_questionTab/user/'.$id);?>" class="item">
			提问
			<span class="num"><?php echo W('Question/getUserQuestionNumByID',array($id));?></span>
		</a>
		<a href="<?php echo U('/User/Index/userpage_answerTab/user/'.$id);?>" class="item">
			回答
			<span class="num"><?php echo W('Question/getUserAnswerNumByID',array($id));?></span>
		</a>
	</div>
</div>