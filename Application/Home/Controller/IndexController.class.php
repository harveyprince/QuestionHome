<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $questionsql = D('Question/Question');
        $questionlist = $questionsql->getHotQuestionIDsByMonth(0);
        $this->assign('hot_question_list',$questionlist);
    	$this->display('welcomepagecontent');
    }

    public function test2(){
        echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
        $usermodel = D('User/UserAccount');
        $variable = $usermodel->getUser();
        foreach ($variable as $key => $value) {
            echo $value['id'];
            echo $value['surname'];
            echo $value['purename'];
        }
    }
}