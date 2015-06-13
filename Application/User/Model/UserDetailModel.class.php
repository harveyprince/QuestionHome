<?php
namespace User\Model;
use Think\Model;
class UserDetailModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_user_detail (id int(20) not null,head_icon text,short_description varchar(20),long_description text,location varchar(30),subject varchar(15),sex char(1),school varchar(10),academy varchar(15))");
	}

	public function createUserInfoByID($id){
		$usersql['id'] = $id;
		$this->add($usersql);
	}

	public function updateInfo($userinfo){
		$old = $this->where('id=%d',$userinfo['id'])->select();
		if(!$old){
			$this->createUserInfoByID($userinfo['id']);
		}
		$this->save($userinfo);
	}

	public function getUser($id){
		$usersql['id'] = $id;
		$result = $this->where($usersql)->select();
		return $result[0];
	}

	public function getUserHeadIcon($id){
		$usersql['id'] = $id;
		$result = $this->field('head_icon')->where($usersql)->select();
		$result = $result[0];
		return $result['head_icon'];
	}
}