<?php if (!defined('THINK_PATH')) exit();?><div class="profile-section-item clearfix">
	<a href="javascript:void(0);" class="profile-vote-count">
		<div class="profile-vote-num"><?php echo W('User/getQuestionAnswerNum',array($id));?></div>
		<div class="profile-vote-type">回答</div>
	</a>
	<div class="profile-section-main">
		<div class="profile-question">
			<a href="<?php echo U('/Question/Index/QuestionContent/question/'.$id);?>" class="question_link"><?php echo W('User/getQuestionTitle',array($id));?></a>
		</div>
		<div>
			<?php echo W('User/getQuestionContent',array($id));?>
		</div>
	</div>
</div>