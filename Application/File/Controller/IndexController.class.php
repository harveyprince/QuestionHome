<?php
namespace File\Controller;
use Think\Controller;
class IndexController extends Controller{
	private $qiniuconfig = array(
	        'secrectKey'     => '', //七牛服务器
	        'accessKey'      => '', //七牛用户
	        'domain'         => '', //七牛域名
	        'bucket'         => '', //空间名称
	        'timeout'        => 300, //超时时间
	        );

	public function index(){
		echo 'this is file';
	}

	public function deleteQiniuFile($filename){
		$qiniu = new \Think\Upload\Driver\Qiniu($this->qiniuconfig);
		return $qiniu->deleteFile($filename);
	}

	public function getUrlHead(){
		return "http://[空间名称].qiniudn.com/";
	}

	public function qiniuToken(){
		$qiniu = new \Think\Upload\Driver\Qiniu($this->qiniuconfig);
		return $qiniu->getToken();
	}
}