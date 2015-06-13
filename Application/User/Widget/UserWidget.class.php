<?php
namespace User\Widget;
use Think\Controller;
class UserWidget extends Controller{
	public function gettest(){
		echo 'happy';
	}	

	public function businessoption(){
		$this->display('businessoption');
	}

	// user
	public function getWordAuthorID($id){
		$wordsql = D('UserBox');
		$result = $wordsql->getAuthorID($id);
		return $result;
	}

	public function getWordAuthor($id){
		$wordsql = D('UserBox');
		$authorID = $wordsql->getAuthorID($id);
		$usersql = D('User/UserAccount');
		$name = $usersql->getUserNameByID($authorID);
		return $name;
	}

	public function getWordContent($id){
		$wordsql = D('UserBox');
		$word= $wordsql->getWord($id);
		return $word['content'];
	}

	public function getWordTime($id){
		$wordsql = D('UserBox');
		$word= $wordsql->getWord($id);
		return $word['time'];
	}

	public function getCommentNum($id){
		$commentsql = D('UserBoxComment');
		return $commentsql->getCommentNum($id);
	}

	public function getWordAuthorDes($id){
		$wordsql = D('UserBox');
		$authorID = $wordsql->getAuthorID($id);
		$usersql = D('User/UserDetail');
		$data = $usersql->getUser($authorID);
		return $data['short_description'];
	}

	public function getWordAuthorHeadIcon($id){
		$wordsql = D('UserBox');
		$authorID = $wordsql->getAuthorID($id);
		return $this->getUserHeadIcon($authorID);
	}

	public function getUserHeadIcon($aid){
		$user = D('UserDetail');
		$result = $user->getUser($aid);
		return $result['head_icon']?'http://harveyphp.qiniudn.com/'.$result['head_icon']:'http://harveyphp.qiniudn.com/head_default.jpg';
	}

	public function getUserHeadIconBySession(){
		return $this->getUserHeadIcon(session('harvey_user_id'));
	}

	public function getUserNameBySession(){
		return session('?harvey_user')?session('harvey_user'):false;
	}

	public function getUserNameByID($id){
		$usersql = M('UserAccount');
		$result = $usersql
		->where('id = %d',$id)
		->select();
		$name = $result[0]['surname'].$result[0]['purename'];
		return $name;
	}

	public function getUserIDBySession(){
		return session('?harvey_user_id')?session('harvey_user_id'):false;
	}

	public function getUserInfoBySession(){
		$id = session('?harvey_user_id')?session('harvey_user_id'):false;
		return $this->getUserInfoByID($id);
	}

	public function getUserInfoByID($id){
		if($id){
			$usersql = D('UserDetail');
			return $usersql->getUser($id);
		}
	}

	public function getUserAgreeVoteBySession(){
		return $this->getUserAgreeVoteByID(session('harvey_user_id'));
	}

	public function getUserAgreeVoteByID($id){
		$usersql = M('UserAccount');
		$answerresult = $usersql
		->join('harvey_answer on harvey_user_account.id = harvey_answer.author_id')
		->join('harvey_answer_vote on harvey_answer.id = harvey_answer_vote.answer_id')
		->where('harvey_answer_vote.vote_type = 1 and harvey_user_account.id = %d',$id)
		->count();
		$questionresult = $usersql
		->join('harvey_question on harvey_user_account.id = harvey_question.author_id')
		->join('harvey_question_vote on harvey_question.id = harvey_question_vote.question_id')
		->where('harvey_question_vote.vote_type = 1 and harvey_user_account.id = %d',$id)
		->count();
		return $answerresult+$questionresult;
	}

	public function getUserDisagreeVoteBySession(){
		return $this->getUserDisagreeVoteByID(session('harvey_user_id'));
	}

	public function getUserDisagreeVoteByID($id){
		$usersql = M('UserAccount');
		$answerresult = $usersql
		->join('harvey_answer on harvey_user_account.id = harvey_answer.author_id')
		->join('harvey_answer_vote on harvey_answer.id = harvey_answer_vote.answer_id')
		->where('harvey_answer_vote.vote_type = -1 and harvey_user_account.id = %d',$id)
		->count();
		$questionresult = $usersql
		->join('harvey_question on harvey_user_account.id = harvey_question.author_id')
		->join('harvey_question_vote on harvey_question.id = harvey_question_vote.question_id')
		->where('harvey_question_vote.vote_type = -1 and harvey_user_account.id = %d',$id)
		->count();
		return $answerresult+$questionresult;
	}

	public function getUserScoreBySession(){
		return $this->getUserScoreByID(session('harvey_user_id'));
	}

	public function getUserScoreByID($id){
		$usersql = M('UserAccount');
		$result = $usersql->field('score')->where('id = %d',$id)->select();
		return $result[0]['score'];
	}

	public function getUserQuestionNumBySession(){
		return $this->getUserQuestionNumByID(session('harvey_user_id'));
	}

	public function getUserQuestionNumByID($id){
		$questionsql = M('Question');
		$result = $questionsql->where('type = 1 and author_id = %d',$id)->count();
		return $result;
	}

	public function getUserAnswerNumBySession(){
		return $this->getUserAnswerNumByID(session('harvey_user_id'));
	}

	public function getUserAnswerNumByID($id){
		$answersql = M('Answer');
		$result = $answersql->where('author_id = %d',$id)->count();
		return $result;
	}

	public function getUserDraftNumBySession(){
		return $this->getUserDraftNumByID(session('harvey_user_id'));
	}

	public function getUserDraftNumByID($id){
		$questionsql = M('Question');
		$result = $questionsql->where('type = 0 and author_id = %d',$id)->count();
		return $result;
	}

	public function getUserHomeDraft($id){
		$this->assign('id',$id);
		$this->display('draftitem');
	}

	public function getUserHomeAnswer($id){
		$this->assign('id',$id);
		$this->display('answeritem');
	}

	public function getUserHomeQuestion($id){
		$this->assign('id',$id);
		$this->display('questionitem');
	}

	public function getUserHomeWord($id){
		$this->assign('id',$id);
		$commentsql = D('UserBoxComment');
		$comment = $commentsql->getComments($id);
		$this->assign('commentlist',$comment);
		$this->display('worditem');
	}

	public function commentitem($comment){
		$this->assign('comment',$comment);
		$this->display('commentitem');
	}

	public function getDraft($draftid){
		$questionsql = M('Question');
		$result = $questionsql
		->where('type = 0 and id = %d',$draftid)
		->select();
		return $result[0];
	}

	public function getQuestion($questionid){
		$questionsql = M('Question');
		$result = $questionsql
		->where('type = 1 and id = %d',$questionid)
		->select();
		return $result[0];
	}

	public function getQuestionTitle($questionid){
		return $this->getQuestion($questionid)['title'];
	}

	public function getQuestionContent($questionid){
		return utf_substr(htmlspecialchars(strip_tags($this->getQuestion($questionid)['content'])),100);
	}

	public function getQuestionAnswerNum($questionid){
		$questionsql = M('Question');
		$result = $questionsql
		->join('harvey_answer on harvey_answer.question_id = harvey_question.id')
		->where('harvey_question.id = %d',$questionid)
		->count();
		return $result;
	}

	public function getAnswerVoteNum($answerid){
		$answersql = M('Answer');
		$result = $answersql
		->join('harvey_answer_vote on harvey_answer.id = harvey_answer_vote.answer_id')
		->where('harvey_answer.id = %d',$answerid)
		->sum('harvey_answer_vote.vote_type');
		return $result?$result:0;
	}

	public function getQuestionForAnswer($answerid){
		$answersql = M('Answer');
		$result = $answersql
		->join('harvey_question on harvey_answer.question_id = harvey_question.id')
		->field('harvey_question.title,harvey_question.id')
		->where('harvey_answer.id = %d',$answerid)
		->select();
		return $result[0];
	}

	public function getAnswerContent($answerid){
		$answersql = M('Answer');
		$result = $answersql
		->field('content')
		->where('id = %d',$answerid)
		->select();
		return utf_substr(htmlspecialchars(strip_tags($result[0]['content'])),100);
	}



	

}