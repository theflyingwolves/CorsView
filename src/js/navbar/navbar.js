function addNavBarListener(){
	
	$('.top-nav').mouseenter(function(){
	$('.modulebook').css("opacity","1.0");
	});
	
	$('#fb-icon').mouseover(function(){
		$(this).find("img").attr("src","../../res/img/fbicon-color-30.png");
	});
	
	$('#fb-icon').mouseout(function(){
		$(this).find("img").attr("src","../../res/img/fbicon-30.png");
	});

	jQuery.extend(jQuery.expr[':'], {
	  focus: "a == document.activeElement"
	});
	
	$("#search-form input").hover(function() {
		$(this).parent().addClass("active");	
	}, function() {
		if(!$(this).is(":focus")){
			$(this).parent().removeClass("active");
		}
	})
	
	$("#search-form input").focusin(function() {
		$(this).parent().addClass("active");
	});
	
	$("#search-form input").focusout(function() {
		$(this).parent().removeClass("active");
	});
}
