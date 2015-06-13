<?php
namespace Question\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$question = D('Question');
    	$list = $question->getAllQuestionIDs(0);
    	$this->assign('questionlist',$list);
    	$this->display('questionpage');
    }

    public function questionHot(){
        $type = I('get.type');
        $question = D('Question');
        if($type == "week"){
            $list = $question->getHotQuestionIDsByWeek(0);
            $this->assign('weektype',true);
        } else {
            $list = $question->getHotQuestionIDsByMonth(0);
        }
        $this->assign('questionlist',$list);
        $this->display('questionhotpage');
    }

    public function help(){
        $this->display('questionhelp');
    }

    public function test(){
        $search_key = "58";
        $this->assign('search_key',$search_key);
        $this->assign('search_type',"Question");
        $this->assign('questionActive',true);
        $wheresql = "";
        $keylist = explode(" ", $search_key);
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
        ->field('title,content,harvey_question.id,GROUP_CONCAT(harvey_question_tag.tag SEPARATOR " ") as tags')
        ->group('harvey_question.id')
        ->order('time desc')
        ->buildSql();
        $result = $questionsql
        ->table($subsql.' a')
        ->where($wheresql)
        ->select();
        dump($result);
    }

    public function Search(){
        $search_key = I('get.search-key');
        $this->assign('search_key',$search_key);
        $this->assign('search_type',"Question");
        $this->assign('questionActive',true);
        $wheresql = "";
        $keylist = explode(" ", $search_key);
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
        ->field('time,title,content,harvey_question.id,GROUP_CONCAT(harvey_question_tag.tag SEPARATOR " ") as tags')
        ->group('harvey_question.id')
        ->where('harvey_question.type=1')
        ->order('time desc')
        ->buildSql();
        $list = $questionsql
        ->table($subsql.' a')
        ->limit(6)
        ->page(1)
        ->where($wheresql)
        ->order('time desc')
        ->select();
        $this->assign('questionlist',$list);
        $this->display('searchpage');
    }

    public function SearchUser(){
        $search_key = I('get.search-key');
        $this->assign('search_key',$search_key);
        $this->assign('search_type',"User");
        $this->assign('userActive',true);
        $wheresql = "";
        $keylist = explode(" ", $search_key);
        foreach ($keylist as $key => $value) {
            $wheresql = $wheresql." instr(concat(surname,purename),'".$value."')>0 ";
            $wheresql = $wheresql."and";
        }
        $wheresql = $wheresql."and";
        $wheresql = str_replace("andand", "", $wheresql);
        $wheresql = trim($wheresql);
        $questionsql = M('UserAccount');
        $list = $questionsql
        ->limit(1)
        ->page(1)
        ->field('id')
        ->where($wheresql)
        ->select();
        $this->assign('userlist',$list);
        $this->display('searchpage');
    }

    public function modifyQuestion(){
        if(session('?harvey_user_id')){
            $questionid = I('get.questionid');
            $questionsql = D('Question');
            $question = $questionsql->getQuestionWithoutJudge($questionid);
            if($question['author_id'] == session('harvey_user_id')){
                $qiniu = A('File/Index');
                $this->assign('token',$qiniu->qiniuToken());
                $this->assign('url_head',$qiniu->getUrlHead());
                $this->assign('aid',session('harvey_user_id'));
                $this->assign('qid',$questionid);
                $this->assign('question',$question);
                $questiontagsql = D('QuestionTag');
                $taglist = $questiontagsql->getTags($questionid);
                $this->assign('questiontags',$taglist);
                $this->display('questionmodify');
            }else{
                echo 'you have no access to this question!';
            }
        } else {
            echo 'you have to login first!';
        }
        
    }

    public function updateSubmittedQuestion(){
        $questionid = I('post.questionid');
        $title = I('post.title');
        $content = I('post.content',"","");
        $tags = I('post.tags');
        $questionsql = D('Question');
        $question = $questionsql->getQuestionWithoutJudge($questionid);
        if($question['author_id'] == session('harvey_user_id')){
            $question['title'] = $title;
            $question['content'] = $content;
            $question['time'] = time();
            $question['type'] = 1;
            $question['id'] = $questionid;
            $questionsql->updateQuestion($question);
            $tagsql = D('QuestionTag');
            $tagsql->updateTags($tags,$questionid);
            $this->ajaxReturn(array(true,$questionid));
        }else{
            $this->ajaxReturn(false);
        }

    }

    public function updateSubmittedDraft(){
        $questionid = I('post.questionid');
        $title = I('post.title');
        $content = I('post.content',"","");
        $tags = I('post.tags');
        $questionsql = D('Question');
        $question = $questionsql->getQuestionWithoutJudge($questionid);
        if($question['author_id'] == session('harvey_user_id') and $question['type']==0){
            $question['title'] = $title;
            $question['content'] = $content;
            $question['time'] = time();
            $question['type'] = 0;
            $question['id'] = $questionid;
            $questionsql->updateQuestion($question);
            $tagsql = D('QuestionTag');
            $tagsql->updateTags($tags,$questionid);
            $this->ajaxReturn(array(true,$questionid));
        }else{
            $this->ajaxReturn(false);
        }
    }

    public function searchMore(){
        $pagenumber = (int)(I('post.page'));
        $search_key = I('post.key');
        $search_type = I('post.type');
        if($search_type=="Question"){
            $question = D('Question');
            $list = $question->findQuestions($pagenumber,$search_key);
            foreach ($list as $key => $item) {
                $id = $item['id'];
                $list[$key]['questionvotenum'] = $this->getQuestionVoteNum($id);
                $list[$key]['answernum'] = $this->getAnswerNum($id);
                $pattern="/<img.*?src=[\'|\"](.*?(?:[\.png|\.gif|\.jpg]))[\'|\"].*?[\/]?>/i";
                $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
                $list[$key]['image'] = $matchs[1][0];
                if(!$list[$key]['image']){
                    $pattern="/(<iframe[^>]*>[^<]*<\/iframe>)/i";
                    $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
                    $list[$key]['video'] = $matchs[1][0];
                    $pattern='/height="([\d]*)"/';
                    $list[$key]['video'] = preg_replace($pattern, 'heigth="100"', $list[$key]['video']);
                    $pattern='/width="([\d]*)"/';
                    $list[$key]['video'] = preg_replace($pattern, 'width="200"', $list[$key]['video']);
                }
                $list[$key]['content'] = utf_substr(htmlspecialchars(strip_tags($list[$key]['content'])),300);
                $tags = $this->getTags($id);
                if($tags){
                    $tagresult = "";
                    foreach ($tags as $single => $tagvalue) {
                        $tagresult = $tagresult.$tagvalue['tag'];
                        $tagresult = $tagresult."___harveyprince___";
                    }
                    $tagresult = $tagresult."___harveyprince___";
                    $tagresult = str_replace("___harveyprince______harveyprince___","",$tagresult);
                }
                $list[$key]['tags'] = $tagresult;
            }
        }
        if($search_type=="User"){
            $usersql = D('User/UserAccount');
            $list = $usersql->findUsers($pagenumber,$search_key);
            foreach ($list as $key => $item) {
                $id = $item['id'];
                $list[$key]['name'] = $item['surname'].$item['purename'];
                $list[$key]['agree_vote'] = $this->getUserAgreeVoteByID($id);
                $list[$key]['disagree_vote'] = $this->getUserDisagreeVoteByID($id);
                $list[$key]['questionnum'] = $this->getUserQuestionNumByID($id);
                $list[$key]['answernum'] = $this->getUserAnswerNumByID($id);
                $list[$key]['draftnum'] = $this->getUserDraftNumByID($id);
            }
        }
        $this->ajaxReturn($list);
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

    public function questionMore(){
        $pagenumber = (int)(I('post.page'));
        $question = D('Question');
        $list = $question->getAllQuestions($pagenumber);
        foreach ($list as $key => $item) {
            $id = $item['id'];
            $list[$key]['questionvotenum'] = $this->getQuestionVoteNum($id);
            $list[$key]['answernum'] = $this->getAnswerNum($id);
            $pattern="/<img.*?src=[\'|\"](.*?(?:[\.png|\.gif|\.jpg]))[\'|\"].*?[\/]?>/i";
            $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
            $list[$key]['image'] = $matchs[1][0];
            if(!$list[$key]['image']){
                $pattern="/(<iframe[^>]*>[^<]*<\/iframe>)/i";
                $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
                $list[$key]['video'] = $matchs[1][0];
                $pattern='/height="([\d]*)"/';
                $list[$key]['video'] = preg_replace($pattern, 'heigth="100"', $list[$key]['video']);
                $pattern='/width="([\d]*)"/';
                $list[$key]['video'] = preg_replace($pattern, 'width="200"', $list[$key]['video']);
            }
            $list[$key]['content'] = utf_substr(htmlspecialchars(strip_tags($list[$key]['content'])),300);
            $tags = $this->getTags($id);
            if($tags){
                $tagresult = "";
                foreach ($tags as $single => $tagvalue) {
                    $tagresult = $tagresult.$tagvalue['tag'];
                    $tagresult = $tagresult."___harveyprince___";
                }
                $tagresult = $tagresult."___harveyprince___";
                $tagresult = str_replace("___harveyprince______harveyprince___","",$tagresult);
            }
            $list[$key]['tags'] = $tagresult;
        }
        $this->ajaxReturn($list);
    }

    public function hotQuestionMoreByMonth(){
        $pagenumber = (int)(I('post.page'));
        $question = D('Question');
        $list = $question->getAllHotQuestionsByMonth($pagenumber);
        foreach ($list as $key => $item) {
            $id = $item['id'];
            $list[$key]['questionvotenum'] = $this->getQuestionVoteNum($id);
            $list[$key]['answernum'] = $this->getAnswerNum($id);
            $pattern="/<img.*?src=[\'|\"](.*?(?:[\.png|\.gif|\.jpg]))[\'|\"].*?[\/]?>/i";
            $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
            $list[$key]['image'] = $matchs[1][0];
            if(!$list[$key]['image']){
                $pattern="/(<iframe[^>]*>[^<]*<\/iframe>)/i";
                $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
                $list[$key]['video'] = $matchs[1][0];
                $pattern='/height="([\d]*)"/';
                $list[$key]['video'] = preg_replace($pattern, 'heigth="100"', $list[$key]['video']);
                $pattern='/width="([\d]*)"/';
                $list[$key]['video'] = preg_replace($pattern, 'width="200"', $list[$key]['video']);
            }
            $list[$key]['content'] = utf_substr(htmlspecialchars(strip_tags($list[$key]['content'])),300);
            $tags = $this->getTags($id);
            if($tags){
                $tagresult = "";
                foreach ($tags as $single => $tagvalue) {
                    $tagresult = $tagresult.$tagvalue['tag'];
                    $tagresult = $tagresult."___harveyprince___";
                }
                $tagresult = $tagresult."___harveyprince___";
                $tagresult = str_replace("___harveyprince______harveyprince___","",$tagresult);
            }
            $list[$key]['tags'] = $tagresult;
        }
        $this->ajaxReturn($list);
    }

    public function hotQuestionMoreByWeek(){
        $pagenumber = (int)(I('post.page'));
        $question = D('Question');
        $list = $question->getAllHotQuestionsByWeek($pagenumber);
        foreach ($list as $key => $item) {
            $id = $item['id'];
            $list[$key]['questionvotenum'] = $this->getQuestionVoteNum($id);
            $list[$key]['answernum'] = $this->getAnswerNum($id);
            $pattern="/<img.*?src=[\'|\"](.*?(?:[\.png|\.gif|\.jpg]))[\'|\"].*?[\/]?>/i";
            $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
            $list[$key]['image'] = $matchs[1][0];
            if(!$list[$key]['image']){
                $pattern="/(<iframe[^>]*>[^<]*<\/iframe>)/i";
                $output = preg_match_all($pattern,$list[$key]['content'],$matchs);
                $list[$key]['video'] = $matchs[1][0];
                $pattern='/height="([\d]*)"/';
                $list[$key]['video'] = preg_replace($pattern, 'heigth="100"', $list[$key]['video']);
                $pattern='/width="([\d]*)"/';
                $list[$key]['video'] = preg_replace($pattern, 'width="200"', $list[$key]['video']);
            }
            $list[$key]['content'] = utf_substr(htmlspecialchars(strip_tags($list[$key]['content'])),300);
            $tags = $this->getTags($id);
            if($tags){
                $tagresult = "";
                foreach ($tags as $single => $tagvalue) {
                    $tagresult = $tagresult.$tagvalue['tag'];
                    $tagresult = $tagresult."___harveyprince___";
                }
                $tagresult = $tagresult."___harveyprince___";
                $tagresult = str_replace("___harveyprince______harveyprince___","",$tagresult);
            }
            $list[$key]['tags'] = $tagresult;
        }
        $this->ajaxReturn($list);        
    }

    public function getQuestionVoteNum($id){
        $votesql = D('QuestionVote');
        $vote = $votesql->getQuestionVoteNum($id);
        if($vote){
            return $vote;
        } else {
            return "0";
        }
    }

    public function getAnswerNum($id){
        $answersql = D('Answer');
        return $answersql->getAnswerNum($id);
    }

    public function getTags($id){
        $questiontagsql = D('QuestionTag');
        return $questiontagsql->getTags($id);
    }

    public function questionContent(){
        $questionid = I('get.question');
        $questionorder = I('get.order');
        $this->assign('id',$questionid);
        $questiontagsql = D('QuestionTag');
        $tags = $questiontagsql->getTags($questionid);
        $this->assign('taglist',$tags);
        $answersql = D('Answer');
        if($questionorder == "vote"){
            $answers = $answersql->getAnswersOrderByVote($questionid);
            $this->assign('order','vote');
        }else{
            $answers = $answersql->getAnswers($questionid);
        }
        $qiniu = A('File/Index');
        $this->assign('token',$qiniu->qiniuToken());
        $this->assign('url_head',$qiniu->getUrlHead());
        $this->assign('aid',session('harvey_user_id'));
        $this->assign('answerlist',$answers);
        $this->display('questionmainpage');
    }

    public function toSubmitQuestion(){
        if(session('?harvey_user_id')){
            $qiniu = A('File/Index');
            $this->assign('token',$qiniu->qiniuToken());
            $this->assign('url_head',$qiniu->getUrlHead());
            $this->assign('aid',session('harvey_user_id'));
            $this->display('questionsubmit');
        } else {
            echo 'you have to login first!';
        }
    }

    public function submitQuestion(){
        $title = I('post.title');
        $content = I('post.content',"","");
        $tags = I('post.tags');
        $usersql = D('User/UserAccount');
        $userscore = $usersql->getScore();
        $questionsqlforscore = D('Question');
        $today_question_num = $questionsqlforscore->getTodaySubmit();
        if($title and $content and session('?harvey_user_id') and ($userscore>10?true:($today_question_num<3))){
            $questionsql['author_id'] = session('harvey_user_id');
            $questionsql['title'] = $title;
            $questionsql['content'] = $content;
            $questionsql['time'] = time();
            $questionsql['type'] = 1;
            $question = D('Question');
            $questionid = $question->createQuestion($questionsql);
            $questiontag = D('QuestionTag');
            foreach ($tags as $key => $value) {
                $singletag['id'] = $questionid;
                $singletag['tag'] = $value;
                $questiontag->addTag($singletag);
            }
            $this->ajaxReturn(array(true,$questionid));
        } else {
            $this->ajaxReturn(false);
        }
    }

    public function saveQuestion(){
        $title = I('post.title');
        $content = I('post.content',"","");
        $tags = I('post.tags');
        if($title and $content and session('?harvey_user_id')){
            $questionsql['author_id'] = session('harvey_user_id');
            $questionsql['title'] = $title;
            $questionsql['content'] = $content;
            $questionsql['time'] = time();
            $questionsql['type'] = 0;
            $question = D('Question');
            $question->createQuestion($questionsql);
            $questionid = $question->getQuestionID($questionsql);
            $questiontag = D('QuestionTag');
            foreach ($tags as $key => $value) {
                $singletag['id'] = $questionid;
                $singletag['tag'] = $value;
                $questiontag->addTag($singletag);
            }
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    }

    public function submitAnswer(){
        $content = I('post.content',"","");
        $questionid = I('post.questionid');
        if($questionid and $content and session('?harvey_user_id')){
            $answersql['question_id'] = $questionid;
            $answersql['author_id'] = session('harvey_user_id');
            $answersql['content'] = $content;
            $answersql['time'] = time();
            $answer = D('Answer');
            $answer->createAnswer($answersql);
            $usersql = D('User/UserAccount');
            $usersql->submitAnswerScorePlus();
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    }

    public function submitComment(){
        $content = I('post.content');
        $answerid = I('post.answerid');
        $replyerid = I('post.replyerid');
        if($answerid and $content and session('?harvey_user_id')){
            $commentsql['answer_id'] = $answerid;
            $commentsql['author_id'] = session('harvey_user_id');
            $commentsql['replyer_id'] = $replyerid;
            $commentsql['content'] = $content;
            $commentsql['time'] = time();
            $comment = D('Comment');
            $comment->createComment($commentsql);
            $usersql = D('User/UserAccount');
            $usersql->submitCommentScorePlus();
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    }

    public function deleteQuestion(){
        if(session('?harvey_user_id')){
            $questionid = I('post.questionid');
            $questionsql = D('Question');
            $question = $questionsql->getQuestionWithoutJudge($questionid);
            if($question['author_id'] == session('harvey_user_id')){
                $questionsql->where('id = %d',$questionid)->delete();
                $tagsql = D('QuestionTag');
                $tagsql->where('id = %d',$questionid)->delete();
                $this->ajaxReturn(true);
            }else{
                $this->ajaxReturn(false);
            }
        } else {
            $this->ajaxReturn(false);
        }
    }

    public function voteQuestion(){
        $questionid = I('post.questionid');
        $voterid = session('harvey_user_id');
        $votetype = I('post.votetype');
        if($questionid and ($votetype==1 or $votetype==-1) and session('?harvey_user_id')){
            $votesql['voter_id'] = $voterid;
            $votesql['question_id'] = $questionid;
            $votesql['vote_type'] = $votetype;
            $vote = D('QuestionVote');
            $vote->addVote($votesql);
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    }

    public function voteAnswer(){
        $answerid = I('post.answerid');
        $voterid = session('harvey_user_id');
        $votetype = I('post.votetype');
        if($answerid and ($votetype==1 or $votetype==-1) and session('?harvey_user_id')){
            $votesql['voter_id'] = $voterid;
            $votesql['answer_id'] = $answerid;
            $votesql['vote_type'] = $votetype;
            $vote = D('AnswerVote');
            $vote->addVote($votesql);
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    }

}