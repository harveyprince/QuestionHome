<?php if (!defined('THINK_PATH')) exit();?><div class="profile-section-item clearfix">
	<a href="javascript:void(0);" class="profile-vote-count delete-draft" did="<?php echo ($id); ?>" delete-url="<?php echo U('/Question/Index/deleteQuestion');?>">
		<span class="glyphicon glyphicon-trash"></span>
		<div class="profile-vote-type">删除</div>
	</a>
	<div class="profile-section-main">
		<div class="profile-question">
			<a href="<?php echo U('/Question/Index/modifyQuestion').'?questionid='.$id;?>" class="question_link"><?php echo W('User/getDraft',array($id))['title'];?></a>
		</div>
	</div>
</div>