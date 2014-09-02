/********** add event listner for nav bar *************/
var addEventListener = function(){
	$('#fb-icon').mouseover(function(){
	$(this).attr("src","../../res/img/fbicon-color-30.png");
	});
	
	$('#fb-icon').mouseout(function(){
		$(this).attr("src","../../res/img/fbicon-30.png");
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

	$(".module-table li").hover(function() {
		$(this).append(removeButtonHtml);
		$(this).css("padding-bottom","5px");
	}, function() {
		$(this).find("span").remove();
		$(this).css("padding-bottom","15px");

	});
}


function createPersonalPage(){
	$("#wrapper").append(personalPageHtml);
}

