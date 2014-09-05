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

function addProfileListener(){

  $('#profile').popover({ 
    html : true,
    content: function() {
    	var contentHtml = "<a href=\"personalPage.html\"><input type=\"submit\" class=\"btn btn-default\"  value=\"Profile\"></input></a>";
    	contentHtml += "<button class=\"btn btn-default\" onClick=\"fblogout();\">Log out</button>";

    	return contentHtml;
      // return $($(this).attr('data-id')).html();
    }
  });
  	if(typeof(FB) !== 'undefined'){
  	  	FB.getLoginStatus(function(response) {
       		 if (response.session) {
       		   console.log('I am logged in');
       		 } else {
       		   console.log('I am logged out');
	  			$("#profile").hide();
       		}
    	});
  	} else {
  		console.log('I am logged out');
	  	$("#profile").hide();
  	}

}