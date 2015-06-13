<?php if (!defined('THINK_PATH')) exit();?><div class="feed-item">
	<div class="feed-item-inner">
		<div class="avatar">
			<a href="<?php echo U('/User/Index/userpage/user/'.W('Question/getQuestion',array($id))['author_id']);?>">
				<img src="<?php echo W('Question/getQuestionAuthorHeadIcon',array($id));?>">
			</a>
		</div>
		<div class="feed-main">
			<div class="source">
				发表了问题
				<span class="time"><?php echo date("Y-m-d H:i:s",W('Question/getQuestion',array($id))['time']) ?></span>
			</div>
			<div class="content">
				<h2 class="subtitlesection"><?php echo W('Question/getQuestion',array($id))['title'];?></h2>
				<div class="entry-body">
					<div class="item-vote" style="display:block;">
						<a name="expand" class="item-vote-count" href="" data-votecount=""><?php echo W('Question/getUserScore',array($id));?></a>
					</div>
					<div class="item-answer-detail">
						<div class="item-answer-author-info">
							<h3 class="item-answer-author-wrap">
								<a href="<?php echo U('/User/Index/userpage/user/'.W('Question/getQuestion',array($id))['author_id']);?>"><?php echo W('Question/getAuthor',array($id));?></a>
							</h3>
						</div>
						<div class="item-rich-text">
							<div class="zh-summary clearfix" style="display:block;">
								<?php if(W('Question/getShortQuestion',array($id))['image']): ?><img class="short-image" src="<?php echo W('Question/getShortQuestion',array($id))['image'];?>"><?php endif; ?>
								<?php if(W('Question/getShortQuestion',array($id))['video']): echo W('Question/getShortQuestion',array($id))['video']; endif; ?>
								<span class="questioncontent"><?php echo W('Question/getShortQuestion',array($id))['content'];?></span>
								<a class="toggle-expand" href="<?php echo U('/Question/Index/questionContent/question/'.$id);?>">显示全部</a>
							</div>
						</div>
					</div>
				</div>
				<div class="feed-meta">
					<div class="item-meta clearfix">
						<div class="meta-panel">
							<a href="<?php echo U('/Question/Index/questionContent/question/'.$id);?>" name="addcomment" class="meta-item toggle-comment">
								<span class="glyphicon glyphicon-comment"></span>
								<?php echo W('Question/getAnswerNum',array($id));?>条评论
							</a>
							<a href="<?php echo U('/Question/Index/questionContent/question/'.$id);?>" name="addgood" class="meta-item toggle-good">
								<span class="glyphicon glyphicon-heart"></span>
								<?php echo W('Question/getVoteNum',array($id));?>个支持
							</a>
							<?php if(is_array($taglist)): $i = 0; $__LIST__ = $taglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$singletag): $mod = ($i % 2 );++$i;?><div class="meta-item tags">
									<a href="<?php echo U('/Question/Index/Search').'?search-key='.$singletag['tag'];?>"><?php echo ($singletag['tag']); ?></a>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
							<a href="javascript:;" class="meta-item autohide questionup" url="<?php echo U('/Question/Index/voteQuestion');?>" target-question-id="<?php echo ($id); ?>">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								点赞
							</a>
							<a href="javascript:;" class="meta-item autohide questiondown" url="<?php echo U('/Question/Index/voteQuestion');?>" target-question-id="<?php echo ($id); ?>">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								踩
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>