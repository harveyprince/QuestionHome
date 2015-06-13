<?php
namespace Question\Widget;
use Think\Controller;
class QuestionWidget extends Controller{
	public function get(){
		echo "test";
	}

	public function questionitem($id){
		$questiontagsql = D('QuestionTag');
		$tags = $questiontagsql->getTags($id);
		$this->assign('id',$id);
		$this->assign('taglist',$tags);
		$this->display('questionitem');
	}

	public function useritem($id){
		$this->assign('id',$id);
		$this->display('useritem');
	}

	public function answeritem($id){
		$commentsql = D('Comment');
		$comments = $commentsql->getComments($id);
		$this->assign('id',$id);
		$this->assign('commentlist',$comments);
		$this->display('answeritem');
	}

	public function commentitem($comment){
		$this->assign('comment',$comment);
		$this->display('commentitem');
	}

	public function getQuestion($id){
		$questionsql = D('Question');
		$result = $questionsql->getQuestion($id);
		return $result;
	}

	public function getShortQuestion($id){
		$questionsql = D('Question');
		$result = $questionsql->getQuestion($id);
		$pattern="/<img.*?src=[\'|\"](.*?(?:[\.png|\.gif|\.jpg]))[\'|\"].*?[\/]?>/i";
		$output = preg_match_all($pattern,$result['content'],$matchs);
		$result['image'] = $matchs[1][0];
		if(!$result['image']){
			$pattern="/(<iframe[^>]*>[^<]*<\/iframe>)/i";
	        $output = preg_match_all($pattern,$result['content'],$matchs);
	        $result['video'] = $matchs[1][0];
	        $pattern='/height="([\d]*)"/';
	        $result['video'] = preg_replace($pattern, 'heigth="100"', $result['video']);
	        $pattern='/width="([\d]*)"/';
	        $result['video'] = preg_replace($pattern, 'width="200"', $result['video']);
		}
		$result['content'] = utf_substr(htmlspecialchars(strip_tags($result['content'])),300);
		return $result;
	}

	public function getQuestionVoteNum($id){
		$votesql = D('QuestionVote');
		$vote = $votesql->getQuestionVoteNum($id);
		if($vote){
			return $vote;
		} else {
			return 0;
		}
	}

	public function getTitle($id){
		return 'Title';
	}

	public function getAuthor($id){
		$questionsql = D('Question');
		$authorID = $questionsql->getAuthorID($id);
		$usersql = D('User/UserAccount');
		$name = $usersql->getUserNameByID($authorID);
		return $name;
	}

	public function getAnswerAuthor($id){
		$answersql = D('Answer');
		$authorID = $answersql->getAuthorID($id);
		$usersql = D('User/UserAccount');
		$name = $usersql->getUserNameByID($authorID);
		return $name;
	}

	public function getUserNameByID($id){
		$usersql = D('User/UserAccount');
		$name = $usersql->getUserNameByID($id);
		return $name;
	}

	public function getAuthorDes($id){
		$questionsql = D('Question');
		$authorID = $questionsql->getAuthorID($id);
		$usersql = D('User/UserDetail');
		$data = $usersql->getUser($authorID);
		return $data['short_description'];
	}

	public function getQuestionAuthorHeadIcon($id){
		$questionsql = D('Question');
		$authorID = $questionsql->getAuthorID($id);
		return $this->getUserHeadIcon($authorID);
	}

	public function getAnswerAuthorDes($id){
		$answersql = D('Answer');
		$authorID = $answersql->getAuthorID($id);
		$usersql = D('User/UserDetail');
		$data = $usersql->getUser($authorID);
		return $data['short_description'];
	}

	public function getAnswerAuthorID($id){
		$answersql = D('Answer');
		$authorID = $answersql->getAuthorID($id);
		$usersql = D('User/UserDetail');
		$data = $usersql->getUser($authorID);
		return $data['id'];
	}

	public function getAnswerAuthorHeadIcon($id){
		$answersql = D('Answer');
		$authorID = $answersql->getAuthorID($id);
		return $this->getUserHeadIcon($authorID);
	}

	public function getAnswerContent($id){
		$answersql = D('Answer');
		$answer= $answersql->getAnswer($id);
		return $answer['content'];
	}

	public function getAnswerTime($id){
		$answersql = D('Answer');
		$answer= $answersql->getAnswer($id);
		return $answer['time'];
	}

	public function getAnswerVoteNum($id){
		$votesql = D('AnswerVote');
		$vote = $votesql->getAnswerVoteNum($id);
		if($vote){
			return $vote;
		} else {
			return 0;
		}
	}

	public function getCommentNum($id){
		$commentsql = D('Comment');
		return $commentsql->getCommentNum($id);
	}

	public function getShortText($id){
		return 'here is the content!';
	}

	public function getUserScore($id){
		$questionsql = M('Question');
		$result = $questionsql
		->join('harvey_user_account on harvey_question.author_id = harvey_user_account.id')
		->field('score')
		->where('harvey_question.id = %d',$id)
		->select();
		return $result[0]['score'];
	}

	public function getAnswerNum($id){
		$answersql = D('Answer');
		return $answersql->getAnswerNum($id);
	}

	public function getVoteNum($id){
		$votesql = D('QuestionVote');
		$vote = $votesql->getQuestionVoteNum($id);
		if($vote){
			return $vote;
		} else {
			return 0;
		}
	}

	// user
	public function getUserNameBySession(){
		return session('?harvey_user')?session('harvey_user'):false;
	}

	public function getUserIDBySession(){
		return session('?harvey_user_id')?session('harvey_user_id'):false;
	}

	public function getUserDesBySession(){
		if(session('?harvey_user_id')){
			$id = session('harvey_user_id');
			$usersql = D('User/UserDetail');
			$data = $usersql->getUser($id);
			return $data['short_description'];
		} else {
			return null;
		}
	}

	public function getUserHeadIcon($aid){
		$user = D('User/UserDetail');
		$result = $user->getUser($aid);
		return $result['head_icon']?'http://harveyphp.qiniudn.com/'.$result['head_icon']:'http://harveyphp.qiniudn.com/head_default.jpg';
	}

	public function getUserHeadIconBySession(){
		return $this->getUserHeadIcon(session('harvey_user_id'));
	}

	// user

	public function getUserInfoByID($id){
		if($id){
			$usersql = D('User/UserDetail');
			return $usersql->getUser($id);
		}
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

	public function getUserScoreByID($id){
		$usersql = M('UserAccount');
		$result = $usersql->field('score')->where('id = %d',$id)->select();
		return $result[0]['score'];
	}

	public function getUserQuestionNumByID($id){
		$questionsql = M('Question');
		$result = $questionsql->where('type = 1 and author_id = %d',$id)->count();
		return $result;
	}

	public function getUserAnswerNumByID($id){
		$answersql = M('Answer');
		$result = $answersql->where('author_id = %d',$id)->count();
		return $result;
	}

	public function getUserDraftNumByID($id){
		$questionsql = M('Question');
		$result = $questionsql->where('type = 0 and author_id = %d',$id)->count();
		return $result;
	}





}