<?php
namespace Question\Model;
use Think\Model;
class AnswerModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_answer (id int(20) primary key auto_increment,question_id int(20) not null,author_id int(20) not null,content mediumtext not null,time int(20) not null)");
	}

	public function createAnswer($answer){
		$answersql['question_id'] = $answer['question_id'];
		$answersql['author_id'] = $answer['author_id'];
		$answersql['content'] = $answer['content'];
		$answersql['time'] = $answer['time'];
		$this->add($answersql);
	}

	public function getAnswers($questionid){
		$answersql['question_id'] = $questionid;
		return $this->where($answersql)->order('time desc')->select();
	}

	public function getAnswersOrderByVote($questionid){
		$result = $this->getAnswers($questionid);
		$vote = D('AnswerVote');
        foreach ($result as $key => $value) {
            $voteresult = $vote->getAnswerVoteNum($value['id']);
            $votelist[$key] = $voteresult?$voteresult:'0';
        }
        array_multisort($votelist,SORT_DESC,$result);
		return $result;
	}

	public function getAnswersOrderByVoteTest($questionid){
		$result = $this
		->field('IFNULL(SUM(harvey_answer_vote.vote_type),0) as vote,harvey_answer.question_id,harvey_answer.author_id,harvey_answer.content,harvey_answer.time,id')
		->group('id')
		->join('harvey_answer_vote on harvey_answer_vote.answer_id = harvey_answer.id','LEFT')
		->where('id = %d',$questionid)
		->order('vote desc')
		->select();
		return $result;
	}

	public function getAnswer($id){
		$answersql['id'] = $id;
		$result = $this->where($answersql)->select();
		$result = $result[0];
		return $result;
	}

	public function getAnswerNum($questionid){
		$answersql['question_id'] = $questionid;
		return $this->where($answersql)->count();
	}

	public function getAuthorID($id){
        $answersql['id'] = $id;
        $result = $this->field('author_id')->where($answersql)->select();
        $result = $result[0];
        return $result['author_id'];
    }

    public function getVoted($id){
        $usersql = D('User/UserAccount');
        $userid = $this->field('author_id')->where('id = %d',$id)->select();
        $userid = $userid[0]['author_id'];
        $usersql->getVoteScorePlus($userid);
    }

    public function deleteVoted($id){
        $usersql = D('User/UserAccount');
        $userid = $this->field('author_id')->where('id = %d',$id)->select();
        $userid = $userid[0]['author_id'];
        $usersql->deleteVoteScorePlus($userid);
    }
}