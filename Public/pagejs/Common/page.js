$(function(){
	function alarm(text){
		$(".alarmbox").html(text);
		$(".alarmbox").fadeIn(500);
		setTimeout(function(){$(".alarmbox").fadeOut(500);},4000);
	}
	$(".top-nav-modal-button.btn-login").click(function(){
		var postable = true;
		$(this).parent().find(".form-text-input.required.verticaldown").each(function(i){
			if($(this).val().length<=0){
				$(this).focus();
				postable = false;
				alarm("不能为空！");
			} else if($(this).attr("type")=="password"){
				if($(this).val().length<6){
					$(this).focus();
					postable = false;
					alarm("密码不少于六位！");
				}
			} else if($(this).attr("type")=="email"){
				var mail = $(this).val();
				var filter  = /^\w{3,}@\w+(\.\w+)+$/;
				if(!filter.test(mail)){
					$(this).focus();
					postable = false;
					alarm("邮箱格式不正确！");
				}
			}
		});
		if(postable){
			$.post($(this).attr('url'),
			{
				email:$("#email").val(),
				password:$("#password").val()	
			},function(data,status){
				if(data){
					location.reload();
				} else {
					alarm("登录失败！");
				}
			});
		}
	});
	$(".top-nav-modal-button.btn-regist").click(function(){
		var postable = true;
		$(this).parent().find(".form-text-input.required").each(function(i){
			if($(this).val().length<=0){
				$(this).focus();
				postable = false;
				alarm("不能为空！");
			} else if($(this).attr("type")=="password"){
				if($(this).val().length<6){
					$(this).focus();
					postable = false;
					alarm("密码不少于六位！");
				}
			} else if($(this).attr("type")=="email"){
				var mail = $(this).val();
				var filter  = /^\w{3,}@\w+(\.\w+)+$/;
				if(!filter.test(mail)){
					$(this).focus();
					postable = false;
					alarm("邮箱格式不正确！");
				}
			}
		});
		if(postable){
			$.post($(this).attr('url'),
			{
				surname:$("#signup_surname").val(),
				purename:$("#signup_purename").val(),
				email:$("#email").val(),
				password:$("#password").val()
			},function(data,status){
				if(data){
					alarm("注册成功！");
				} else {
					alarm("注册失败！");
				}
			});
		}
	});
})
$(document).ready(function () {
	var bt = $('#toolBackTop');
	var sw = $(document.body)[0].clientWidth;

	var limitsw = 400;
	if (limitsw > 0){
		limitsw = parseInt(limitsw);
		bt.css("right",limitsw);
	}

	$(window).scroll(function() {
		var st = $(window).scrollTop();
		if(st > 30){
			bt.show();
		}else{
			bt.hide();
		}
	});
})