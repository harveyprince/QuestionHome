<?php if (!defined('THINK_PATH')) exit();?><div class="profile-section-item clearfix">
	<a href="javascript:void(0);" class="profile-vote-count">
		<div class="profile-vote-num"><?php echo W('User/getAnswerVoteNum',array($id));?></div>
		<div class="profile-vote-type">赞同</div>
	</a>
	<div class="profile-section-main">
		<div class="profile-question">
			<a href="<?php echo U('/Question/Index/questionContent/question/'.W('User/getQuestionForAnswer',array($id))['id']);?>" class="question-link"><?php echo W('User/getQuestionForAnswer',array($id))['title'];?></a>
		</div>
		<div>
			<?php echo W('User/getAnswerContent',array($id));?>
		</div>
	</div>
</div>