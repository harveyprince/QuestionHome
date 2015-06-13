<?php if (!defined('THINK_PATH')) exit();?><div class="item-answer">
	<div class="votebar">
		<button class="up answerup" url="<?php echo U('/Question/Index/voteAnswer');?>" target-answer-id="<?php echo ($id); ?>">
			<span class="glyphicon glyphicon-chevron-up"></span>
			<span class="label">赞同</span>
			<span class="count"><?php echo W('Question/getAnswerVoteNum',array($id));?></span>
		</button>
		<button class="down answerdown" url="<?php echo U('/Question/Index/voteAnswer');?>" target-answer-id="<?php echo ($id); ?>">
			<span class="glyphicon glyphicon-chevron-down down-icon"></span>
			<span class="label">反对，不会显示您的姓名</span>
		</button>
	</div>
	<div class="answer-head">
		<div class="item-answer-author-info">
			<h3 class="item-answer-author-wrap">
				<a href="<?php echo U('/User/Index/userpage/user/'.W('Question/getAnswerAuthorID',array($id)));?>" class="item-link-avatar">
					<img class="list-avatar" src="<?php echo W('Question/getAnswerAuthorHeadIcon',array($id));?>">
				</a>
				<a href="<?php echo U('/User/Index/userpage/user/'.W('Question/getAnswerAuthorID',array($id)));?>"><?php echo W('Question/getAnswerAuthor',array($id));?></a>
				,
				<strong><?php echo W('Question/getAnswerAuthorDes',array($id));?></strong>
			</h3>
		</div>
		<div class="item-vote-info">
			<!-- <span class="voters">
				<a href="">lzx</a>
				、
				<a href="">lc</a>
				、
				<a href="">ly</a>
			</span> -->
			<a href="javascript:;">发表评论</a>
		</div>
	</div>
	<div class="item-rich-text">
		<div class="content clearfix infocontent">
			<?php echo W('Question/getAnswerContent',array($id));?>
		</div>
	</div>
	<div class="feed-meta">
		<div class="item-meta clearfix">
			<div class="meta-panel">
				<a href="javascript:;" onclick="show_comment_box(this)" name="addcomment" class="meta-item toggle-comment show-comment-box">
					<span class="glyphicon glyphicon-comment"></span>
					<?php echo W('Question/getCommentNum',array($id));?>条评论
				</a>
				<a href="javascript:;" onclick="hide_comment_box(this)" name="addcomment" class="toggle-comment hide-comment-box" style="display:none;">
					<span class="glyphicon glyphicon-comment"></span>
					收起评论
				</a>
				<span class="meta-item stamp">
					<span class="glyphicon glyphicon-dashboard"></span>
					<?php echo date("Y-m-d H:i:s",W('Question/getAnswerTime',array($id))) ?>
				</span>
			</div>
			<div class="comment-box" style="display:none;">
				<span class="glyphicon glyphicon-chevron-up bubble"></span>
				<span class="glyphicon glyphicon-chevron-up bubble-mask"></span>
				<div class="comment-list">
					<?php if(is_array($commentlist)): $i = 0; $__LIST__ = $commentlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$singlecommentitem): $mod = ($i % 2 );++$i; echo W('Question/commentitem',array($singlecommentitem));?>
						<div class="divider"></div><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php if($_SESSION['harvey_user_id']> 0): ?><div class="comment-form expanded item-comment clearfix last-edit-box">
							<div class="comment-edit-wrap" aria-label="写下你的评论" contentEditable="true"><p style="color:#999;">写下你的评论不少于15字</p></div>
							<div class="command clearfix">
								<button href="javascript:;" url="<?php echo U('/Question/Index/submitComment');?>" target-answer-id="<?php echo ($id); ?>" target-author-id="-1" class="top-add-question submit-comment-button" style="float:right;">评论</button>
								<span class="command-cancel">
									<a href="javascript:;" onclick="command_cancel(this)" class="">取消</a>
								</span>
							</div>
						</div><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>