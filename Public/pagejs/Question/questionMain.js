function show_comment_box(which){
	$(which).parent().next().show();
	$(which).next().show();
	$(which).hide();
}
function hide_comment_box(which){
	$(which).parent().next().hide();
	$(which).prev().show();
	$(which).hide();
}
function command_cancel(which){
	$(which).parent().parent().hide();
	$(which).parent().parent().prev().html('<p style="color:#999;">写下你的评论不少于15字</p>');
}
function show_comment_mini_box(which){
	$(which).parent().addClass("mask");
	$(which).parent().parent().next().show();
	$(which).parent().parent().next().children().get(0).focus();
}
function command_mini_cancel(which){
	$(which).parent().parent().parent().prev().find(".minicomment").removeClass("mask");
	$(which).parent().parent().hide();
	$(which).parent().parent().parent().hide();
}
function comment_box_focus(which){
	if(!$(which).next().is(":visible")){
			$(which).html("");
			$(which).next().show();
		}
}
function submitcomment(which){
	var postable = true;
		if($(which).parent().prev().html().length<=15){alert("不少于15字！");$(which).parent().prev().focus();postable=false;}
		if(postable){
			$.post($(which).attr('url'),
			{
				content:$(which).parent().prev().html(),
				wordid:$(which).attr('target-word-id'),
				replyerid:$(which).attr('target-author-id')
			},function(data,status){
				if(data){
					location.reload();
				}
			});
		}
}
$(function(){
	$(".comment-edit-wrap").focus(function(){
		if(!$(this).next().is(":visible")){
			$(this).html("");
			$(this).next().show();
		}
	});
	$(".submit-answer-button").click(function(){
		var postable = true;
		if($('#summernote').code().length<=15){alert("不少于15字！");$(".note-editable").focus();postable=false;}
		if(postable){
			$.post($(this).attr('url'),
			{
				content:$('#summernote').code(),
				questionid:$(this).attr('target-question-id')
			},function(data,status){
				if(data){
					location.reload();
				}
			});
		}
		
	});
	$(".submit-comment-button").click(function(){
		var postable = true;
		if($(this).parent().prev().html().length<=15){alert("不少于15字！");$(this).parent().prev().focus();postable=false;}
		if(postable){
			$.post($(this).attr('url'),
			{
				content:$(this).parent().prev().html(),
				answerid:$(this).attr('target-answer-id'),
				replyerid:$(this).attr('target-author-id')
			},function(data,status){
				if(data){
					location.reload();
				}
			});
		}
		
	});
	$(".answerup").click(function(){
		$.post($(this).attr('url'),{
			answerid:$(this).attr('target-answer-id'),
			votetype:1
		},function(data,status){
			if(data){
				location.reload();
			}
		});
	});
	$(".answerdown").click(function(){
		$.post($(this).attr('url'),{
			answerid:$(this).attr('target-answer-id'),
			votetype:-1
		},function(data,status){
			if(data){
				location.reload();
			}
		});
	});
});
$(document).ready(function() {
	$('#summernote').summernote({
		height: 100,
		focus:false,
		lang:'zh-CN',
		
	});
});