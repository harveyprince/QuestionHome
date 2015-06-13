<?php if (!defined('THINK_PATH')) exit();?><div class="item-comment clearfix">
	<a href="<?php echo U('/User/Index/userpage/user/'.$comment['author_id']);?>" class="item-link-avatar">
		<img class="list-avatar" src="<?php echo W('Question/getUserHeadIcon',array($comment['author_id']));?>">
	</a>
	<div class="comment-content-wrap">
		<div class="comment-hd"><?php echo W('Question/getUserNameByID',array($comment['author_id']));?> <?php if($comment['replyer_id']!=-1){echo "回复 ".W('Question/getUserNameByID',array($comment['replyer_id']));} ?>:</div>
		<div class="comment-content">
			<?php echo ($comment['content']); ?>
		</div>
	</div>
	<div class="meta-panel">
		<span class="meta-item stamp">
			<span class="glyphicon glyphicon-dashboard"></span>
			<?php echo date("Y-m-d H:i:s",$comment['time']) ?>
		</span>
		<?php if($_SESSION['harvey_user_id']> 0): ?><span class="minicomment">
				<a href="javascript:;" onclick="show_comment_mini_box(this)" name="addcomment" class="meta-item stamp">
					<span class="glyphicon glyphicon-comment"></span>
					回复
				</a>
			</span><?php endif; ?>
	</div>
	<?php if($_SESSION['harvey_user_id']> 0): ?><div class="comment-form expanded clearfix minibox">
			<div class="comment-edit-wrap commentupbox" contentEditable="true"></div>
			<div class="command clearfix">
				<button href="javascript:;" url="<?php echo U('/Question/Index/submitComment');?>" target-answer-id="<?php echo ($comment['answer_id']); ?>" target-author-id="<?php echo ($comment['author_id']); ?>" class="top-add-question submit-comment-button" style="float:right;">评论</button>
				<span class="command-cancel">
					<a href="javascript:;" onclick="command_mini_cancel(this)" class="">取消</a>
				</span>
			</div>
		</div><?php endif; ?>
</div>