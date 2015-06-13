<?php
namespace User\Model;
use Think\Model;
class UserBoxModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_user_box (id int(20) primary key auto_increment,user_id int(20) not null,author_id int(20) not null,content text not null,time int(20) not null)");
	}

	public function createWord($word){
		$wordsql['user_id'] = $word['user_id'];
		$wordsql['author_id'] = $word['author_id'];
		$wordsql['content'] = $word['content'];
		$wordsql['time'] = $word['time'];
		return $this->add($wordsql);
	}

	public function getWords($userid,$page){
		$wordsql['user_id'] = $userid;
		return $this->limit(1)->page($page+1)->where($wordsql)->order('time desc')->select();
	}

	public function getAuthorID($id){
		$result = $this
		->field('author_id')
		->where('id=%d',$id)
		->order('time desc')
		->select();
		return $result[0]['author_id'];
	}

	public function getWord($id){
		$result = $this
		->where('id=%d',$id)
		->order('time desc')
		->select();
		return $result[0];
	}
}