<?php
namespace User\Model;
use Think\Model;
class UserBoxCommentModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_user_box_comment (word_id int(20) not null,author_id int(20) not null,replyer_id int(20) not null,content text not null,time int(20) not null)");
	}

	public function createComment($comment){
		$commentsql['word_id'] = $comment['word_id'];
		$commentsql['author_id'] = $comment['author_id'];
		$commentsql['replyer_id'] = $comment['replyer_id'];
		$commentsql['content'] = $comment['content'];
		$commentsql['time'] = $comment['time'];
		$this->add($commentsql);
	}

	public function getComments($id){
		$commentsql['word_id'] = $id;
		return $this->where($commentsql)->select();
	}

	public function getCommentNum($id){
		$commentsql['word_id'] = $id;
		return $this->where($commentsql)->count();
	}
}