<?php
namespace Home\Widget;
use Think\Controller;
class HomeWidget extends Controller{
	public function questionitem($id){
		$this->assign('id',$id);
		$this->display('questionitem');
	}

	public function getQuestion($id){
		$questionsql = D('Question/Question');
		$result = $questionsql->getQuestion($id);
		return $result;
	}

	public function getQuestionAuthorHeadIcon($id){
		$questionsql = D('Question/Question');
		$authorID = $questionsql->getAuthorID($id);
		return $this->getUserHeadIcon($authorID);
	}

	public function getQuestionAuthor($id){
		$questionsql = D('Question/Question');
		$authorID = $questionsql->getAuthorID($id);
		$usersql = D('User/UserAccount');
		$name = $usersql->getUserNameByID($authorID);
		return $name;
	}

	public function getUserHeadIcon($aid){
		$user = D('User/UserDetail');
		$result = $user->getUser($aid);
		return $result['head_icon']?'http://harveyphp.qiniudn.com/'.$result['head_icon']:'http://harveyphp.qiniudn.com/head_default.jpg';
	}
}