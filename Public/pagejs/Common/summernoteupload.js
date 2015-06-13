function sendFile(file, editor, $editable){
	$(".note-toolbar.btn-toolbar").append('<div class="note-alarm"><i class="fa fa-spinner fa-spin uploading-icon"></i>正在上传图片<div>');
	var filename = false;
	try{
		filename = file['name'];
	} catch(e){filename = false;}
	if(!filename){$(".note-alarm").remove();}
	var ext = filename.substr(filename.lastIndexOf("."));
	ext = ext.toUpperCase();
	var timestamp = new Date().getTime();
	var name = timestamp+"_"+$("#summernote").attr('aid')+ext;
	data = new FormData();
	data.append("file", file);
	data.append("key",name);
	data.append("token",$("#summernote").attr('token'));
	Pace.track(function(){
	$.ajax({
		data: data,
		type: "POST",
		url: "http://upload.qiniu.com",
		cache: false,
		contentType: false,
		processData: false,
		success: function(data) {
			editor.insertImage($editable, $("#summernote").attr('url-head')+data['key']);
			$(".note-alarm").html("上传成功,请等待加载");
			setTimeout(function(){$(".note-alarm").remove();},3000);
		},
		error:function(){
			$(".note-alarm").html("上传失败");
			setTimeout(function(){$(".note-alarm").remove();},3000);
		}
	});
});
}
$(document).ready(function() {
	$('#summernote').summernote({
		height: 300,
		focus:false,
		lang:'zh-CN',
		onImageUpload: function(files, editor, $editable) {
			sendFile(files[0],editor,$editable);
		}
	});
});