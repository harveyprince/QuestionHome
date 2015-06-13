function keyDown(e) {
    var keycode = e.which;
    if(keycode==13){
    	$(".add_tag_box").blur();
    }
}
function showbox_add_tag(which){
	$(which).hide();
	$(which).next().show();
	$(which).next().children().get(0).focus();
	$(which).next().children().get(0).onkeydown=keyDown;
}
function add_tag(which){
	$(".form-text-input.add_tag_box").val("");
	$(which).parent().hide();
	$(which).parent().prev().show();
}
$(function(){
	$(".add_tag_box").blur(function(){
		if($(".tags-box").children().length<5){
			var tag = $(".form-text-input.add_tag_box").val();
			if(tag.length>0){
				$(".tags-box").append('<div class="meta-item tags"><a href="javascript:;">'+tag+'</a><span class="delete-tag">x</span></div>');
			}
		}
		$(".meta-item.tags").click(function(){
			$(this).remove();
		});
		$(".form-text-input.add_tag_box").val("");
		$(this).parent().hide();
		$(this).parent().prev().show();
	});
	$(".meta-item.tags").click(function(){
		$(this).remove();
	});
});
