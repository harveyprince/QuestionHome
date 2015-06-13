<?php
namespace Question\Model;
use Think\Model;
class CommentModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_comment (answer_id int(20) not null,author_id int(20) not null,replyer_id int(20) not null,content text not null,time int(20) not null)");
	}

	public function createComment($comment){
		$commentsql['answer_id'] = $comment['answer_id'];
		$commentsql['author_id'] = $comment['author_id'];
		$commentsql['replyer_id'] = $comment['replyer_id'];
		$commentsql['content'] = $comment['content'];
		$commentsql['time'] = $comment['time'];
		$this->add($commentsql);
	}

	public function getComments($id){
		$commentsql['answer_id'] = $id;
		return $this->where($commentsql)->select();
	}

	public function getCommentNum($id){
		$commentsql['answer_id'] = $id;
		return $this->where($commentsql)->count();
	}
}