<?php if (!defined('THINK_PATH')) exit();?><div class="item-answer">
	<div class="answer-head">
		<div class="item-answer-author-info">
			<h3 class="item-answer-author-wrap">
				<a href="<?php echo U('/User/Index/userpage/user/'.W('User/getWordAuthorID',array($id)));?>" class="item-link-avatar">
					<img class="list-avatar headicon" src="<?php echo W('User/getWordAuthorHeadIcon',array($id));?>">
				</a>
				<a href="<?php echo U('/User/Index/userpage/user/'.W('User/getWordAuthorID',array($id)));?>"><?php echo W('User/getWordAuthor',array($id));?></a>
				,
				<strong><?php echo W('User/getWordAuthorDes',array($id));?></strong>
			</h3>
		</div>
		<div class="item-vote-info">
			<a href="javascript:;">发表留言</a>
		</div>
	</div>
	<div class="item-rich-text">
		<div class="content clearfix infocontent">
			<?php echo W('User/getWordContent',array($id));?>
		</div>
	</div>
	<div class="feed-meta">
		<div class="item-meta clearfix">
			<div class="meta-panel">
				<a href="javascript:;" onclick="show_comment_box(this)" name="addcomment" class="meta-item toggle-comment show-comment-box">
					<span class="glyphicon glyphicon-comment"></span>
					<?php echo W('User/getCommentNum',array($id));?>条评论
				</a>
				<a href="javascript:;" onclick="hide_comment_box(this)" name="addcomment" class="toggle-comment hide-comment-box" style="display:none;">
					<span class="glyphicon glyphicon-comment"></span>
					收起评论
				</a>
				<span class="meta-item stamp">
					<span class="glyphicon glyphicon-dashboard"></span>
					<?php echo date("Y-m-d H:i:s",W('User/getWordTime',array($id))) ?>
				</span>
			</div>
			<div class="comment-box" style="display:none;">
				<span class="glyphicon glyphicon-chevron-up bubble"></span>
				<span class="glyphicon glyphicon-chevron-up bubble-mask"></span>
				<div class="comment-list">
					<?php if(is_array($commentlist)): $i = 0; $__LIST__ = $commentlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$singlecommentitem): $mod = ($i % 2 );++$i; echo W('User/commentitem',array($singlecommentitem));?>
						<div class="divider"></div><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php if($_SESSION['harvey_user_id']> 0): ?><div class="comment-form expanded item-comment clearfix last-edit-box">
							<div class="comment-edit-wrap" aria-label="写下你的评论" contentEditable="true" onfocus="comment_box_focus(this)"><p style="color:#999;">写下你的评论不少于15字</p></div>
							<div class="command clearfix">
								<button href="javascript:;" url="<?php echo U('/User/Index/submitComment');?>" target-word-id="<?php echo ($id); ?>" target-author-id="-1" class="top-add-question submit-comment-button" style="float:right;" onclick="submitcomment(this)">评论</button>
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