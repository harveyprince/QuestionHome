$(function(){
	$(".submit-question-text").click(function(){
		var postable = true;
		if($(".questiontitle").val().length<=0){alert("标题不能为空！");$(".questiontitle").focus();postable=false;}
		if($('#summernote').code().length<=15){alert("内容不少于15字！");$(".note-editable").focus();postable=false;}
		var tags = [];
		$(".meta-item.tags>a").each(function(){
			tags.push($(this).html());
		});
		if(postable){
			$.post($(this).attr('url'),
			{
				title:$(".questiontitle").val(),
				content:$('#summernote').code(),
				tags:tags
			},function(data,status){
				if(data){
					if(data[0]){
						window.location.href = "/Question/Index/questionContent/question/"+data[1]+".html";
					}
				}else{
					alert("发布失败：达到了今日上限！详情查看帮助！");
				}
			});
		}
	});

	$(".saveQuestion").click(function(){
		var postable = true;
		if($(".questiontitle").val().length<=0){$(".questiontitle").focus();postable=false;}
		if($('#summernote').code().length<=15){$(".note-editable").focus();postable=false;}
		var tags = [];
		$(".meta-item.tags>a").each(function(){
			tags.push($(this).html());
		});
		if(postable){
			$.post($(this).attr('url'),
			{
				title:$(".questiontitle").val(),
				content:$('#summernote').code(),
				tags:tags
			},function(data,status){
				if(data){
					window.location.href = "/User/Index/draftTab.html";
				}else{
					alert("error accoured");
				}
			});
		}
	});
});
