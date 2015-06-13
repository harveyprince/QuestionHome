
function getLocaleTime(nS) {     
	var d = new Date(parseInt(nS)*1000);
	return formatDate(d);      
} 

function   formatDate(now)   {     
	var   year=now.getFullYear();
	var   month=now.getMonth()+1;     
	var   date=now.getDate();     
	var   hour=now.getHours();     
	var   minute=now.getMinutes();     
	var   second=now.getSeconds();     
	return   year+"-"+(month<10?("0"+month):month)+"-"+(date<10?("0"+date):date)+"   "+(hour<10?("0"+hour):hour)+":"+(minute<10?("0"+minute):minute)+":"+(second<10?("0"+second):second);     
}  
$(function(){
	$(".question-more").click(function(){
		$.post($(this).attr('url'),
		{
			page:$(this).attr('page')
		},function(data,status){
			if(data){
				$(".question-more").attr('page',(parseInt)($(".question-more").attr('page'))+1);
				for(item in data){
					var questionitemHTML = '<div class=feed-item><div class=feed-item-inner><div class=avatar><a href="';
					questionitemHTML += 'http://localhost/User/Index/userpage/user/';
					questionitemHTML += data[item]['author_id'];
					questionitemHTML += '"><img src="http://harveyphp.qiniudn.com/';
					questionitemHTML += data[item]['head_icon'];
					questionitemHTML += '"></a></div><div class=feed-main><div class=source>发表了问题<span class=time>';
					questionitemHTML += getLocaleTime(data[item]['time']);
					questionitemHTML += '</span></div><div class=content><h2 class=subtitlesection>';
					questionitemHTML += data[item]['title'];
					questionitemHTML += '</h2><div class=entry-body><div class=item-vote style="display:block;"><a name=expand class=item-vote-count href="" data-votecount="">';
					questionitemHTML += data[item]['score'];
					questionitemHTML += '</a></div><div class=item-answer-detail><div class=item-answer-author-info><h3 class=item-answer-author-wrap><a href="">';
					questionitemHTML += data[item]['surname'];
					questionitemHTML += data[item]['purename'];
					questionitemHTML += '</a></h3></div><div class=item-rich-text><div class="zh-summary clearfix" style="display:block;">';
					if(data[item]['image']){
						questionitemHTML += '<img class="short-image" src="';
						questionitemHTML += data[item]['image'];
						questionitemHTML += '">';
					} else {
						if(data[item]['video']){
							questionitemHTML += data[item]['video'];
						}
					}
					questionitemHTML += '<span class="questioncontent">';
					questionitemHTML += data[item]['content'];
					questionitemHTML += '</span><a class=toggle-expand href="/Question/Index/questionContent/question/';
					questionitemHTML += data[item]['id'];
					questionitemHTML += '.html">显示全部</a></div></div></div></div><div class=feed-meta><div class="item-meta clearfix"><div class=meta-panel><a href="/Question/Index/questionContent/question/';
					questionitemHTML += data[item]['id'];
					questionitemHTML += '.html" name=addcomment class="meta-item toggle-comment"><span class="glyphicon glyphicon-comment addquestionitemnav"></span>';
					questionitemHTML += data[item]['answernum'];
					questionitemHTML += '条评论</a><a href="/Question/Index/questionContent/question/';
					questionitemHTML += data[item]['id'];
					questionitemHTML += '.html" name=addgood class="meta-item toggle-good addquestionitem"><span class="glyphicon glyphicon-heart addquestionitemnav"></span>';
					questionitemHTML += data[item]['questionvotenum'];
					questionitemHTML += '个支持</a>';
					if(data[item]['tags']){
						var tagslist = data[item]['tags'].split("___harveyprince___");
						for(tag in tagslist){
							questionitemHTML += '<div class="meta-item tags"><a href="">';
							questionitemHTML += tagslist[tag];
							questionitemHTML += '</a></div>';
						}
					}
					questionitemHTML += '<a href="javascript:;" class="meta-item autohide questionup" url=/Question/Index/voteQuestion.html target-question-id="';
					questionitemHTML += data[item]['id'];
					questionitemHTML += '"><span class="glyphicon glyphicon-thumbs-up addquestionitemnav"></span>点赞</a><a href="javascript:;" class="meta-item autohide questiondown" url=/Question/Index/voteQuestion.html target-question-id="';
					questionitemHTML += data[item]['id'];
					questionitemHTML += '"><span class="glyphicon glyphicon-thumbs-down addquestionitemnav"></span>踩</a></div></div></div></div></div></div>';
					questionitemHTML += '<div class="divider"></div></div>';
					$(".question-more").before(questionitemHTML);
					$(".question-more").prev().find(".questionup").click(function(){
						$.post($(this).attr('url'),{
							questionid:$(this).attr('target-question-id'),
							votetype:1
						},function(data,status){
							if(data){
								location.reload();
							}
						});
					});
					$(".question-more").prev().find(".questiondown").click(function(){
						$.post($(this).attr('url'),{
							questionid:$(this).attr('target-question-id'),
							votetype:-1
						},function(data,status){
							if(data){
								location.reload();
							}
						});
					});
				};
			} else {
				$(".question-more").html("已无更多内容");
			}
		});
	});
});
