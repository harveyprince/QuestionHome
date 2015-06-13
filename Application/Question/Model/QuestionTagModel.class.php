<?php
namespace Question\Model;
use Think\Model;
class QuestionTagModel extends Model{
	function _initialize(){
		$Model = M();
		$Model->execute("create table if not exists harvey_question_tag (id int(20) not null,tag varchar(10) not null,primary key(id,tag))");
	}

	public function addTag($tag){
    	$tagsql['id'] = $tag['id'];
    	$tagsql['tag'] = $tag['tag'];
    	$this->add($tagsql);
    }

    public function updateTags($tags,$id){
        $this->where('id = %d',$id)->delete();
        foreach ($tags as $key => $tag) {
            $tagsql['id'] = $id;
            $tagsql['tag'] = $tag;
            $this->add($tagsql);
        }
    }

    public function getTags($id){
    	$tag['id'] = $id;
    	return $this->field('tag')->where($tag)->select();
    }
}