<?php
namespace User\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function test(){
		$str = 'www<p>dreamdu</p>.com';
		echo htmlspecialchars($str).'<br>';
		echo strip_tags($str);
	}

	public function index(){
		$this->tabManage("homeActive",session('harvey_user_id'));
	}
	public function questionTab(){
		$this->tabManage("questionActive",session('harvey_user_id'));
	}
	public function answerTab(){
		$this->tabManage("answerActive",session('harvey_user_id'));
	}
	public function draftTab(){
		$this->tabManage("draftActive",session('harvey_user_id'));
	}
	public function userpage(){
		$aid = I('get.user');
		$this->assign('userpage',true);
		$this->tabManage("homeActive",$aid);
	}
	public function userpage_questionTab(){
		$aid = I('get.user');
		$this->assign('userpage',true);
		$this->tabManage("questionActive",$aid);
	}
	public function userpage_answerTab(){
		$aid = I('get.user');
		$this->assign('userpage',true);
		$this->tabManage("answerActive",$aid);
	}
	public function userpage_draftTab(){
		$aid = I('get.user');
		$this->assign('userpage',true);
		$this->tabManage("draftActive",$aid);
	}

	public function submitWord(){
		$uid = I('post.uid');
		$content = I('post.content');
		$wordsql = D('UserBox');
		if ($content and $uid) {
			$word['content'] = $content;
			$word['user_id'] = $uid;
			$word['author_id'] = session('harvey_user_id');
			$word['time'] = time();
			$wordsql->createWord($word);
			$this->ajaxReturn(true);
		} else {
			$this->ajaxReturn(false);
		}
		
	}

	public function submitComment(){
		$content = I('post.content');
        $wordid = I('post.wordid');
        $replyerid = I('post.replyerid');
        if($wordid and $content and session('?harvey_user_id')){
            $commentsql['word_id'] = $wordid;
            $commentsql['author_id'] = session('harvey_user_id');
            $commentsql['replyer_id'] = $replyerid;
            $commentsql['content'] = $content;
            $commentsql['time'] = time();
            $comment = D('UserBoxComment');
            $comment->createComment($commentsql);
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
	}

	public function tabManage($active,$id){
		// for file
		$page = I('get.page');
		$qiniu = A('File/Index');
		$this->assign('aid',$id);
		$this->assign('url_head',$qiniu->getUrlHead());
		$this->assign('token',$qiniu->qiniuToken());
		// for item id list:draftlist,answerlist,questionlist
		$questionsql = M('Question');
		$draftlist = $questionsql->field('id')->where('type = 0 and author_id = %d',$id)->select();
		$questionlist = $questionsql->field('id')->where('type = 1 and author_id = %d',$id)->select();
		$answersql = M('Answer');
		$answerlist = $answersql->field('id')->where('author_id = %d',$id)->select();
		$this->assign('draftlist',$draftlist);
		$this->assign('questionlist',$questionlist);
		$this->assign('answerlist',$answerlist);
		$this->assign($active,true);
		$wordsql = D('UserBox');
		$word = $wordsql->getWords($id,$page?$page:0);
		$this->assign('wordlist',$word);
		$this->assign('leftable',$page<=0?'false':'true');
		$this->assign('rightable',$word?'true':'false');
		$this->assign('page',$page?$page:0);
		$this->display('userhome');
	}
	public function Logout(){
		session(null);
		$this->redirect(__ROOT__.'Home/Index/index','loading',1);
	}

	public function loginController(){
		if(strlen(I('post.password'))>6 and filter_var(I('post.email'), FILTER_VALIDATE_EMAIL)){
			$har_user['har_email'] = I('post.email');
			$har_user['har_password'] = I('post.password');
			$user = D('UserAccount');
			$result = $user->checkUser($har_user);
			if($result == null){
				$result = false;
				session(null);
			} else {
				session('harvey_user',$result['surname'].$result['purename']);
				session('harvey_user_id',$result['id']);
				$result = array();
				$result['url'] = U('../Question/index');
			}
		} else {
			$result = false;
		}
		$this->ajaxReturn($result);
	}

	public function signupController(){
		if(strlen(I('post.purename'))>0 and strlen(I('post.password'))>6 and filter_var(I('post.email'), FILTER_VALIDATE_EMAIL)){
			$har_user['surname'] = I('post.surname');
			$har_user['purename'] = I('post.purename');
			$har_user['har_email'] = I('post.email');
			$har_user['har_password'] = I('post.password');
			$user = D('UserAccount');
			$search = $user->where('har_email = "'.$har_user['har_email'].'"')->select();
			if($search){
				$result = false;
			}else{
				$user->createUser($har_user);
				$result = true;
			}
			
		} else {
			$result = false;
		}
		$this->ajaxReturn($result);
	}

	public function saveInfoLocation(){
		$data['location'] = I('post.location');
		$data['subject'] = I('post.subject');
		$data['sex'] = I('post.sex');
		$data['id'] = session('harvey_user_id');
		$user = D('UserDetail');
		if(!$user->getUser(session('harvey_user_id'))){
			$user->createUserInfoByID(session('harvey_user_id'));
		}
		$user->updateInfo($data);
		$this->ajaxReturn($data);
	}

	public function saveInfoSchool(){
		$data['school'] = I('post.school');
		$data['academy'] = I('post.academy');
		$data['id'] = session('harvey_user_id');
		$user = D('UserDetail');
		if(!$user->getUser(session('harvey_user_id'))){
			$user->createUserInfoByID(session('harvey_user_id'));
		}
		$user->updateInfo($data);
		$this->ajaxReturn($data);
	}

	public function saveInfoDescription(){
		$data['long_description'] = I('post.long_description');
		$data['id'] = session('harvey_user_id');
		$user = D('UserDetail');
		if(!$user->getUser(session('harvey_user_id'))){
			$user->createUserInfoByID(session('harvey_user_id'));
		}
		$user->updateInfo($data);
		$this->ajaxReturn($data);
	}

	public function saveInfoPersondes(){
		$data['short_description'] = I('post.short_description');
		$data['id'] = session('harvey_user_id');
		$user = D('UserDetail');
		if(!$user->getUser(session('harvey_user_id'))){
			$user->createUserInfoByID(session('harvey_user_id'));
		}
		$user->updateInfo($data);
		$this->ajaxReturn($data);
	}

	public function deleteHeadIcon(){
		$imageCheck = '/\\.(GIF|JPG|JPEG|PNG)$/';
		if(preg_match($imageCheck,I('post.head_icon'))){
			$headIcon = I('post.head_icon');
			$qiniu = A('File/Index');
			return $qiniu->deleteQiniuFile($headIcon);
		}else {
			return false;
		}
	}

	public function saveHeadIcon(){
		$imageCheck = '/\.(GIF|JPG|JPEG|PNG)$/';
		if(preg_match($imageCheck,I('post.head_icon'))){
			$headIcon['head_icon'] = I('post.head_icon');
			$headIcon['id'] = session('harvey_user_id');
			$user = D('UserDetail');
			$oldHead = $user->getUserHeadIcon(session('harvey_user_id'));
			$user->updateInfo($headIcon);
			if($oldHead){
				$qiniu = A('File/Index');
				$qiniu->deleteQiniuFile($oldHead);
			}
			$this->ajaxReturn(true);
		}else{
			$this->ajaxReturn(false);
		}
	}
}