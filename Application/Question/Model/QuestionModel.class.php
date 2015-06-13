<?php
namespace Question\Model;
use Think\Model;
class QuestionModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_question (id int(20) primary key auto_increment,author_id int(20) not null,title varchar(20) not null,content mediumtext not null,time int(20) not null,type int(1) not null)");
	}

    public function createQuestion($question){
    	$questionsql['author_id'] = $question['author_id'];
    	$questionsql['title'] = $question['title'];
    	$questionsql['content'] = $question['content'];
        $questionsql['time'] = $question['time'];
        $questionsql['type'] = $question['type'];
    	return $this->add($questionsql);
    }

    public function updateQuestion($question){
        $questionsql['title'] = $question['title'];
        $questionsql['content'] = $question['content'];
        $questionsql['time'] = $question['time'];
        $questionsql['type'] = $question['type'];
        $questionsql['id'] = $question['id'];
        return $this->save($questionsql);
    }

    public function getQuestionID($question){
        $result = $this->field('id')->where($question)->select();
        return $result[0]['id'];
    }

    public function getQuestion($id){
        $question['id'] = $id;
        $question['type'] = 1;
        $result = $this->where($question)->select();
        $result = $result[0];
        return $result;
    }

    public function getQuestionWithoutJudge($id){
        $question['id'] = $id;
        $result = $this->where($question)->select();
        $result = $result[0];
        return $result;
    }

    public function getAuthorID($id){
        $question['id'] = $id;
        $question['type'] = 1;
        $result = $this->field('author_id')->where($question)->select();
        $result = $result[0];
        return $result['author_id'];
    }

    public function getAllQuestions($page){
        $result =  $this
        ->limit(6)
        ->page($page+1)
        ->join('harvey_user_detail on harvey_question.author_id = harvey_user_detail.id')
        ->join('harvey_user_account on harvey_user_detail.id = harvey_user_account.id')
        ->field('head_icon,harvey_question.id,harvey_question.time,harvey_question.title,harvey_question.author_id,score,surname,purename,harvey_question.content')
        ->where('harvey_question.type = 1')
        ->order('time desc')
        ->select();
        return $result;
    }

    public function getAllHotQuestionsByWeek($page){
        $start = strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))));
        $end = strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))));
        $result =  $this
        ->limit(6)
        ->page($page+1)
        ->join('harvey_question_vote on harvey_question_vote.question_id = harvey_question.id','LEFT')
        ->join('harvey_user_detail on harvey_question.author_id = harvey_user_detail.id')
        ->join('harvey_user_account on harvey_user_detail.id = harvey_user_account.id')
        ->field('IFNULL(SUM(harvey_question_vote.vote_type),0) as vote,head_icon,harvey_question.id,harvey_question.time,harvey_question.title,harvey_question.author_id,score,surname,purename,harvey_question.content')
        ->group('id')
        ->where('harvey_question.type = 1 and time > %d and time < %d',$start,$end)
        ->order('vote desc,time desc')
        ->select();
        return $result;
    }

    public function getAllHotQuestionsByMonth($page){
        $year = date("Y");
        $month = date("m");
        $allday = date("t");
        $start = strtotime($year."-".$month."-1");
        $end = strtotime($year."-".$month."-".$allday);
        $result =  $this
        ->limit(6)
        ->page($page+1)
        ->join('harvey_question_vote on harvey_question_vote.question_id = harvey_question.id','LEFT')
        ->join('harvey_user_detail on harvey_question.author_id = harvey_user_detail.id')
        ->join('harvey_user_account on harvey_user_detail.id = harvey_user_account.id')
        ->field('IFNULL(SUM(harvey_question_vote.vote_type),0) as vote,head_icon,harvey_question.id,harvey_question.time,harvey_question.title,harvey_question.author_id,score,surname,purename,harvey_question.content')
        ->group('id')
        ->where('harvey_question.type = 1 and time > %d and time < %d',$start,$end)
        ->order('vote desc,time desc')
        ->select();
        return $result;
    }

    public function findQuestions($page,$key){
        $wheresql = "";
        $keylist = explode(" ", $key);
        foreach ($keylist as $key => $value) {
            $wheresql = $wheresql." (instr(title,'".$value."')>0 ";
            $wheresql = $wheresql."or";
            $wheresql = $wheresql." instr(content,'".$value."')>0 ";
            $wheresql = $wheresql."or";
            $wheresql = $wheresql." instr(tags,'".$value."')>0) ";
            $wheresql = $wheresql."and";
        }
        $wheresql = $wheresql."and";
        $wheresql = str_replace("andand", "", $wheresql);
        $wheresql = trim($wheresql);
        $questionsql = M('Question');
        $subsql = $questionsql
        ->join('harvey_question_tag on harvey_question_tag.id = harvey_question.id','LEFT')
        ->field('time,title,content,harvey_question.id,harvey_question.author_id,GROUP_CONCAT(harvey_question_tag.tag SEPARATOR " ") as tags')
        ->group('harvey_question.id')
        ->where('harvey_question.type=1')
        ->order('time desc')
        ->buildSql();
        $result = $questionsql
        ->table($subsql.' a')
        ->limit(6)
        ->page($page+1)
        ->join('harvey_user_detail on a.author_id = harvey_user_detail.id')
        ->join('harvey_user_account on a.author_id = harvey_user_account.id')
        ->field('head_icon,a.id,time,title,author_id,score,surname,purename,content')
        ->where($wheresql)
        ->order('time desc')
        ->select();
        return $result;
    }

    public function getAllQuestionIDs($page){
        $question['type'] = 1;
        return $this->limit(6)->page($page+1)->field('id')->where($question)->order('time desc')->select();
    }

    public function getHotQuestionIDsByWeek($page){
        $start = strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))));
        $end = strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))));
        $result = $this
        ->limit(6)
        ->page($page+1)
        ->field('id,IFNULL(SUM(harvey_question_vote.vote_type),0) as vote,time')
        ->group('id')
        ->join('harvey_question_vote on harvey_question_vote.question_id = harvey_question.id','LEFT')
        ->where('type = 1 and time > %d and time < %d',$start,$end)
        ->order('vote desc,time desc')
        ->select();
        return $result;
    }

    public function getHotQuestionIDsByMonth($page){
        $year = date("Y");
        $month = date("m");
        $allday = date("t");
        $start = strtotime($year."-".$month."-1");
        $end = strtotime($year."-".$month."-".$allday);
        $result = $this
        ->limit(6)
        ->page($page+1)
        ->field('id,IFNULL(SUM(harvey_question_vote.vote_type),0) as vote')
        ->group('id')
        ->join('harvey_question_vote on harvey_question_vote.question_id = harvey_question.id','LEFT')
        ->where('type = 1 and time > %d and time < %d',$start,$end)
        ->order('vote desc,time desc')
        ->select();
        return $result;
    }

    public function getTodaySubmit(){
        $time = date("Y-m-d");
        $todaybegin = strtotime($time." "."00:00:00");
        $todayend = strtotime($time." "."23:59:59");
        $result = $this
        ->where('author_id = %d and time > %d and time < %d and type = 1',session('harvey_user_id'),$todaybegin,$todayend)
        ->count();
        return $result;
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