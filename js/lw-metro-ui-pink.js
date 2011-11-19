(function($) {
	$(document).ready(function(){
		$("body.home #content div.post, body.search #content div.post, body.archive #content div.post").mouseover(function() {
			$(this).stop().animate({ backgroundColor: '#f3bfde', color: '#000000' },'fast');
		}).mouseout(function() {
			$(this).stop().animate({ backgroundColor: '#1C1C1C', color: '#999999'},'fast');
		});    

		$("body.home #content div.post, body.search #content div.post, body.archive #content div.post").click(function(){
			window.location=$(this).find("h2 a").attr("href");
			return false;
		});
		
		$("div.nav-previous, div.nav-next").click(function(){
			window.location=$(this).find("a").attr("href");
			return false;
		});
		
		$("div.nav-previous, div.nav-next").mouseover(function(){
			$(this).find("a").css({'text-decoration' : 'underline'});
		}).mouseout(function() {
			$(this).find("a").css({'text-decoration' : 'none'});
		});
		
		$("ul.ctc-tag-cloud li").mouseover(function(){
			$(this).find("a").css({'color' : '#1C1C1C'});
		}).mouseout(function() {
			$(this).find("a").css({'color' : '#FFFFFF'});
		});
		
		$("ul.ctc-tag-cloud li").click(function(){
			window.location=$(this).find("a").attr("href");
			return false;
		});
		
	});
})(jQuery);