<?php
namespace User\Model;
use Think\Model;
class UserAccountModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_user_account (id int(20) primary key auto_increment,surname varchar(15),purename varchar(20) not null,har_email varchar(40) not null,har_password varchar(20) not null,score int(10) not null default 0)");
	}

	public function createUser($user){
		//array: id,surname,purename,email,password
		//not nessesary,just prevent from array is not what we want
		$sqluser['surname'] = $user['surname'];
		$sqluser['purename'] = $user['purename'];
		$sqluser['har_email'] = $user['har_email'];
		$sqluser['har_password'] = $user['har_password'];
		$this->add($sqluser);
	}

	public function getAllUsers(){
		return $this->select();
	}

	public function checkUser($user){
		$result = $this->where($user)->select();
		return $result[0];
	}

	public function getUserNameByID($id){
		$usersql['id'] = $id;
		$name = $this->field('surname,purename')->where($usersql)->select();
		$name = $name[0];
		return $name['surname'].$name['purename'];
	}

	public function findUsers($page,$key){
		$wheresql = "";
        $keylist = explode(" ", $key);
        foreach ($keylist as $key => $value) {
            $wheresql = $wheresql." instr(concat(surname,purename),'".$value."')>0 ";
            $wheresql = $wheresql."and";
        }
        $wheresql = $wheresql."and";
        $wheresql = str_replace("andand", "", $wheresql);
        $wheresql = trim($wheresql);
        $result =  $this
        ->limit(1)
        ->page($page+1)
        ->join('harvey_user_detail on harvey_user_detail.id = harvey_user_account.id')
        ->field('harvey_user_account.id,surname,purename,score,head_icon,sex,location,subject,school,academy,short_description,long_description')
        ->where($wheresql)
        ->select();
        return $result;
	}

	public function getScore(){
		$result = $this
		->field('score')
		->where('id = %d',session('harvey_user_id'))
		->select();
		return $result[0]['score'];
	}

	public function submitCommentScorePlus(){
		$this
		->where('id = %d',session('harvey_user_id'))
		->setInc('score',1);
	}

	public function getVoteScorePlus($id){
		$this
		->where('id = %d',$id)
		->setInc('score',1);
	}

	public function deleteVoteScorePlus($id){
		$this
		->where('id = %d',$id)
		->setDec('score',1);
	}

	public function submitAnswerScorePlus(){
		$this
		->where('id = %d',session('harvey_user_id'))
		->setInc('score',2);
	}

}