<?php
namespace Question\Model;
use Think\Model;
class QuestionVoteModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_question_vote (voter_id int(20) not null,question_id int(20) not null,vote_type int(1) not null,primary key(voter_id,question_id))");
	}

	public function createVote($vote){
		$votesql['voter_id'] = $vote['voter_id'];
		$votesql['question_id'] = $vote['question_id'];
		$votesql['vote_type'] = $vote['vote_type'];
		$this->add($votesql);
	}

	public function getQuestionVoteNum($questionid){
		$votesql['question_id'] = $questionid;
		return $this->where($votesql)->sum('vote_type');
	}

	public function addVote($vote){
		$votesql['voter_id'] = $vote['voter_id'];
		$votesql['question_id'] = $vote['question_id'];
		$check = $this->where($votesql)->select();
		$questionsql = D('Question');
		if($check[0]){
			if($check[0]['vote_type']!=$vote['vote_type']){
				$this->where($votesql)->save($vote);
				if($vote['vote_type']==1){
					$questionsql->getVoted($vote['question_id']);
				}
				if($vote['vote_type']==-1){
					$questionsql->deleteVoted($vote['question_id']);
				}
			}else{
				$this->where($votesql)->delete();
				if($vote['vote_type']==1){
					$questionsql->deleteVoted($vote['question_id']);
				}
			}
		} else {
			$this->add($vote);
			if($vote['vote_type']==1){
				$questionsql->getVoted($vote['question_id']);
			}
		}
	}
}