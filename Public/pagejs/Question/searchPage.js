
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
	$(".search-more").click(function(){
		$.post($(this).attr('url'),
		{
			page:$(this).attr('page'),
			type:$(this).attr('search-type'),
			key:$(this).attr('search-key')
		},function(data,status){
			if(data){
				$(".search-more").attr('page',(parseInt)($(".search-more").attr('page'))+1);
				if($(".search-more").attr('search-type')=="Question"){
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
						$(".search-more").before(questionitemHTML);
						$(".search-more").prev().find(".questionup").click(function(){
							$.post($(this).attr('url'),{
								questionid:$(this).attr('target-question-id'),
								votetype:1
							},function(data,status){
								if(data){
									location.reload();
								}
							});
						});
						$(".search-more").prev().find(".questiondown").click(function(){
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
				}
				if($(".search-more").attr('search-type')=="User"){
					for(item in data){
						var useritemHTML = '<div class="profile-header"><div class="profile-header-main"><div class="top"><div class="topdescribe"><span class="name">';
						useritemHTML += data[item]['name'];
						useritemHTML += '</span>，<span class="info-wrap persondes"><span class="short_descriptionInfo">';
						useritemHTML += data[item]['short_description']?data[item]['short_description']:'暂无一句话介绍';
						useritemHTML += '</span></span></div></div><div class="clearfix"><div class="profile-header-avatar-container"><img alt="';
						useritemHTML += data[item]['name'];
						useritemHTML += '" src="http://harveyphp.qiniudn.com/';
						useritemHTML += data[item]['head_icon']?data[item]['head_icon']:'head_default.jpg';
						useritemHTML += '" class="profile-header-img"></div><div class="profile-header-info"><div class="profile-header-info-inner"><div class="items"><div class="item"><span class="glyphicon glyphicon-globe icon-nav"></span><span class="info-wrap location"><span class="location item"><a class="link-blue-normal locationInfo" href="">';
						useritemHTML += data[item]['location']?data[item]['location']:'居住地暂无';
						useritemHTML += '</a></span><span class="business item"><a class="topic-link subjectInfo" href="">';
						useritemHTML += data[item]['subject']?data[item]['subject']:'专业暂无';
						useritemHTML += '</a></span><span class="item small-text sexInfo">';
						useritemHTML += data[item]['sex']?data[item]['sex']:'性别神秘';
						useritemHTML += '</span></span></div><div class="item"><span class="glyphicon glyphicon-briefcase icon-nav"></span><span class="info-wrap school"><span class="location item"><a class="link-blue-normal schoolInfo" href="">';
						useritemHTML += data[item]['school']?data[item]['school']:'学校暂无';
						useritemHTML += '</a></span><span class="business item"><a class="topic-link academyInfo" href="">';
						useritemHTML += data[item]['academy']?data[item]['academy']:'学科暂无';
						useritemHTML += '</a></span></span></div></div><div class="profile-header-description"><span class="info-wrap description"><div class="fold-item"><span class="content long_descriptionInfo">';
						useritemHTML += data[item]['long_description']?data[item]['long_description']:'此人很懒，没有留下描述';
						useritemHTML += '</span></div></span></div></div></div></div></div><div class="profile-header-operation"><div class="profile-header-info-list"><span class="profile-header-info-title">获得</span><span class="profile-header-user-agree"><span class="glyphicon glyphicon-thumbs-up addquestionitemnav"></span><strong>';
						useritemHTML += data[item]['agree_vote'];
						useritemHTML += '</strong><span class="addquestionitem">赞同</span></span><span class="profile-header-user-disagree"><span class="glyphicon glyphicon-thumbs-down addquestionitemnav"></span><strong>';
						useritemHTML += data[item]['disagree_vote'];
						useritemHTML += '</strong><span class="addquestionitem">反对</span></span></div><a href="" class="score">积分:';
						useritemHTML += data[item]['score'];
						useritemHTML += '</a></div><div class="profile-navbar clearfix"><a href="/User/Index/userpage/user/';
						useritemHTML += data[item]['id'];
						useritemHTML += '.html" class="item first home"><span class="glyphicon glyphicon-home"></span></a><a href="/User/Index/userpage_questionTab/user/';
						useritemHTML += data[item]['id'];
						useritemHTML += '.html" class="item">提问<span class="num addquestionitem">';
						useritemHTML += data[item]['questionnum'];
						useritemHTML += '</span></a><a href="/User/Index/userpage_answerTab/user/';
						useritemHTML += data[item]['id'];
						useritemHTML += '.html" class="item">回答<span class="num addquestionitem">';
						useritemHTML += data[item]['answernum'];
						useritemHTML += '</span></a>';
						useritemHTML += '</div></div>';
						$(".search-more").before(useritemHTML);
						
					};
				}
			} else {
				$(".search-more").html("已无更多内容");
			}
		});
	});
});
