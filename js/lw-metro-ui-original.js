(function($) {
	$(document).ready(function(){
		$("body.home #content div.post, body.search #content div.post, body.archive #content div.post").mouseover(function() {
			$(this).stop().animate({ backgroundColor: '#9ECAE1', color: '#000000' },'fast');
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
		
		var colors = ["#C82344","#19A054","#532203","#BDDC30","#034480","#651858","#1B3042","#D5B200","#427E17","#E76422","#931411","#7F9076","#C9ABD0","#151A1C","#48A1A9","#E7AD09","#200044","#758C00"];
		
		var ck = 0;
		$('li.ctc li').each(function(i) {
			//var rand = Math.floor(Math.random()*colors.length);
			$(this).css({'background-color': colors[ck], 'border' : '1px '+ colors[ck] +' solid'});
			ck++;
		});
		
		$("ul.ctc-tag-cloud li").click(function(){
			window.location=$(this).find("a").attr("href");
			return false;
		});
		
	});
})(jQuery);