function editinfo_location(){
	$(".locationupbox").val($(".locationInfo").html());
	$(".subjectupbox").val($(".subjectInfo").html());
	if($(".sexInfo").html()=="男"){
		$(".male").attr('checked','checked');
		$(".female").removeAttr('checked');
	} else {
		$(".female").attr('checked','checked');
		$(".male").removeAttr('checked');
	};
	$(".info-wrap.location").hide();
	$(".edit-wrap.location").show();
}
function saveinfo_location(which){
	$.post($(which).attr('url'),
	{
		location:$(".locationupbox").val(),
		subject:$(".subjectupbox").val(),
		sex:$("input[type='radio']:checked").attr('sex')
	},function(data,status){
		if(data){
			if($(".locationupbox").val().length>0){
				$(".locationInfo").html($(".locationupbox").val());
			} else {
				$(".locationInfo").html("居住地");
			}
			if($(".subjectupbox").val().length>0){
				$(".subjectInfo").html($(".subjectupbox").val());
			}
			$(".sexInfo").html($("input[type='radio']:checked").attr('sex'));
		}
	});
	$(".info-wrap.location").show();
	$(".edit-wrap.location").hide();
}
function editinfo_school(){
	$(".schoolupbox").val($(".schoolInfo").html());
	$(".academyupbox").val($(".academyInfo").html());
	$(".info-wrap.school").hide();
	$(".edit-wrap.school").show();
}
function saveinfo_school(which){
	$.post($(which).attr('url'),
	{
		school:$(".schoolupbox").val(),
		academy:$(".academyupbox").val(),
	},function(data,status){
		if(data){
			if($(".schoolupbox").val().length>0){
				$(".schoolInfo").html($(".schoolupbox").val());
			} else {
				$(".schoolInfo").html("学校");
			}
			if($(".academyupbox").val().length>0){
				$(".academyInfo").html($(".academyupbox").val());
			} else {
				$(".academyInfo").html("学院");
			}
		}
	});
	$(".info-wrap.school").show();
	$(".edit-wrap.school").hide();
}
function editinfo_description(){
	$(".long_descriptionupbox").val($(".long_descriptionInfo").html());
	$(".info-wrap.description").hide();
	$(".edit-wrap.description").show();
}
function saveinfo_description(which){
	$.post($(which).attr('url'),
	{
		long_description:$(".long_descriptionupbox").val(),
	},function(data,status){
		if(data){
			if($(".long_descriptionupbox").val().length>0){
				$(".long_descriptionInfo").html($(".long_descriptionupbox").val());
			} else {
				$(".long_descriptionInfo").html("个人详细描述");
			}
		}
	});
	$(".info-wrap.description").show();
	$(".edit-wrap.description").hide();
}
function editinfo_persondes(){
	$(".short_descriptionupbox").val($(".short_descriptionInfo").html());
	$(".info-wrap.persondes").hide();
	$(".edit-wrap.persondes").show();
}
function saveinfo_persondes(which){
	if($(".short_descriptionupbox").val().length<=20){
		$.post($(which).attr('url'),
		{
			short_description:$(".short_descriptionupbox").val(),
		},function(data,status){
			if(data){
				if($(".short_descriptionupbox").val().length>0){
					$(".short_descriptionInfo").html($(".short_descriptionupbox").val());
				} else {
					$(".short_descriptionInfo").html("请用一句话描述");
				}
			}
		});
		$(".info-wrap.persondes").show();
		$(".edit-wrap.persondes").hide();
	}else{
		alert("不能超过20个字数");
	}
}
$(function(){
	$(".word-box-button").click(function(){
		$.post($(this).attr('url'),{
			content:$(".word-box").val(),
			uid:$(this).attr('aid')
		},function(data,status){
			location.reload();
		});
	});
	$(".delete-draft").click(function(){
		$.post($(this).attr('delete-url'),{
			questionid:$(this).attr('did')
		},function(data,status){
			location.reload();
		});
	});
	$(".male").change(function(){
		$(".female").removeAttr("checked");
	});
	$(".female").change(function(){
		$(".male").removeAttr("checked");
	});
	$(".filebtn").click(function(){
		//upload the image
		var imageCheck = /\.(GIF|JPG|JPEG|PNG)$/i;
		var filename = $("#uploadfile").val();
		if(imageCheck.test(filename)){
			$(".uploading-icon").show();
			$(".upload-text").html("正在上传");
			var timestamp = new Date().getTime();
			var aid = $(this).attr('user-id');
			var ext = filename.substr(filename.lastIndexOf("."));
			ext = ext.toUpperCase();
			var exportname = timestamp+'_'+aid+ext;
			$("#formkey").val(exportname);
			$(".fileform").submit();
		}
		
	});
	$(".modal-cancel").click(function(){
		//delete the photo from qiniu
		if($("#formkey").val().length>1){
		$.post($(this).attr('url'),
			{
				head_icon:$("#formkey").val(),
			},function(data,status){
				if(data){
					$("#formkey").val("");
					$(".modal-body>img").remove();
				}
			});
		}
	});
	$(".modal-sure").click(function(){
		//set the head icon
		if($("#formkey").val().length>1){
		$.post($(this).attr('url'),
			{
				head_icon:$("#formkey").val(),
			},function(data,status){
				if(data){
					location.reload();
				}
			});
		}
	});
	
});
$(document).ready(function() {
	//head icon uploaded successfully
	document.getElementById("hidden_frame").onload = function(){
		$(".uploading-icon").hide();
		$(".upload-text").html("上传头像");
		var key = $("#formkey").val();
		$(".modal-body>img").remove();
		$(".modal-body").append('<img src="'+$(".filebtn").attr("url-head")+key+'" class="upload-head-icon-display profile-header-img">');
	}

});