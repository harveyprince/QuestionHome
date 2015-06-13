function keyDown(e) {
    var keycode = e.which;
    if(keycode==13){
    	if($(".btn-login").is(":visible")==false){
    		$(".btn-regist").click();
    	}else{
    		$(".btn-login").click();
    	}
    	
    }
}
$(document).ready(function(){
	document.onkeydown = keyDown;
});
$(function(){
	$(".action-tip.right").click(function(){
		$(".box.login").hide();
		$(".box.signup").fadeIn(1000);
	});
	$(".action-tip.left").click(function(){
		$(".box.signup").hide();
		$(".box.login").fadeIn(1000);
	});
	function loginalarm(text){
		$(".alarmbox.login").html(text);
		$(".alarmbox.login").fadeIn(500);
		setTimeout(function(){$(".alarmbox.login").fadeOut(500);},4000);
	}
	$(".btn-login").click(function(){
		var postable = true;
		$(this).parent().find(".form-text-input.required").each(function(i){
			if($(this).val().length<=0){
				$(this).focus();
				postable = false;
				loginalarm("不能为空！");
			} else if($(this).attr("type")=="password"){
				if($(this).val().length<6){
					$(this).focus();
					postable = false;
					loginalarm("密码不少于六位！");
				}
			} else if($(this).attr("type")=="email"){
				var mail = $(this).val();
				var filter  = /^\w{3,}@\w+(\.\w+)+$/;
				if(!filter.test(mail)){
					$(this).focus();
					postable = false;
					loginalarm("邮箱格式不正确！");
				}
			}
		});
		if(postable){
			$.post($(this).attr('url'),
			{
				email:$("#login_email").val(),
				password:$("#login_password").val()	
			},function(data,status){
				if(data){
					window.location.href=data['url'];
				} else {
					loginalarm("登录失败！");
				}
			});
		}
	});
	function signupalarm(text){
		$(".alarmbox.signup").html(text);
		$(".alarmbox.signup").fadeIn(500);
		setTimeout(function(){$(".alarmbox.signup").fadeOut(500);},4000);
	}
	$(".btn-regist").click(function(){
		var postable = true;
		$(this).parent().find(".form-text-input.required").each(function(i){
			if($(this).val().length<=0){
				$(this).focus();
				postable = false;
				signupalarm("不能为空！");
			} else if($(this).attr("type")=="password"){
				if($(this).val().length<6){
					$(this).focus();
					postable = false;
					signupalarm("密码不少于六位！");
				}
			} else if($(this).attr("type")=="email"){
				var mail = $(this).val();
				var filter  = /^\w{3,}@\w+(\.\w+)+$/;
				if(!filter.test(mail)){
					$(this).focus();
					postable = false;
					signupalarm("邮箱格式不正确！");
				}
			}
		});
		if(postable){
			$.post($(this).attr('url'),
			{
				surname:$("#signup_surname").val(),
				purename:$("#signup_purename").val(),
				email:$("#signup_email").val(),
				password:$("#signup_password").val()
			},function(data,status){
				if(data){
				signupalarm("注册成功！");
			} else {
				signupalarm("注册失败！");
			}
		});
		}
	});
})
