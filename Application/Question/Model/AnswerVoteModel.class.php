<?php
namespace Question\Model;
use Think\Model;
class AnswerVoteModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_answer_vote (voter_id int(20) not null,answer_id int(20) not null,vote_type int(1) not null,primary key(voter_id,answer_id))");
	}

	public function createVote($vote){
		$votesql['voter_id'] = $vote['voter_id'];
		$votesql['answer_id'] = $vote['answer_id'];
		$votesql['vote_type'] = $vote['vote_type'];
		$this->add($votesql);
	}

	public function getAnswerVoteNum($answerid){
		$votesql['answer_id'] = $answerid;
		return $this->where($votesql)->sum('vote_type');
	}

	public function addVote($vote){
		$votesql['voter_id'] = $vote['voter_id'];
		$votesql['answer_id'] = $vote['answer_id'];
		$check = $this->where($votesql)->select();
		$answersql = D('Answer');
		if($check[0]){
			if($check[0]['vote_type']!=$vote['vote_type']){
				$this->where($votesql)->save($vote);
				if($vote['vote_type']==1){
					$answersql->getVoted($vote['answer_id']);
				}
				if($vote['vote_type']==-1){
					$answersql->deleteVoted($vote['answer_id']);
				}
			}else{
				$this->where($votesql)->delete();
				if($vote['vote_type']==1){
					$answersql->deleteVoted($vote['answer_id']);
				}
			}
		} else {
			$this->add($vote);
			if($vote['vote_type']==1){
				$answersql->getVoted($vote['answer_id']);
			}
		}
	}
}