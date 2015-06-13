<?php if (!defined('THINK_PATH')) exit();?><div class="feed-item list-group-item">
	<div class="feed-item-inner">
		<div class="avatar">
			<a href="<?php echo U('/User/Index/userpage/user/'.W('Home/getQuestion',array($id))['author_id']);?>" class="item-head-home">
				<img class="img-circle" src="<?php echo W('Home/getQuestionAuthorHeadIcon',array($id));?>">
				<span class="author-name"><?php echo W('Home/getQuestionAuthor',array($id));?></span>
			</a>
			<span style="font-size:10px;">发表了问题</span>
		</div>
		<a class="title-item" href="<?php echo U('/Question/Index/questionContent/question/'.$id);?>"><h4 class="list-group-item-heading"><?php echo W('Home/getQuestion',array($id))['title'];?></h4></a>
	</div>
</div>