$('.modulebook').mouseenter(function(){
	$('.modulebook').not(this).animate({
		opacity:'0.4'
	},300);
	$(this).css("opacity","1.0");
});

$('.modulebook').click(function(){
	slideModuleOut($(this));
	var moduleCode = $(this).find("h2").text().toUpperCase();
	console.log("The module code clicked is" + moduleCode);

	var currentUrl = window.location.href;
	window.location.href = (currentUrl.substring(0,currentUrl.indexOf("#"))) + ("#"+moduleCode);
	// resetUrl();
})

function slideModuleOut(moduleBook) {
	var offsetLeft = moduleBook.offset().left;
	var currentColor = moduleBook.css("background-color");
	var alphaColor1 = getAlphacolor(currentColor,0.3);
	var title = moduleBook.find("h1").text();
	moduleBook.prevAll().animate({
		left: -offsetLeft
	},300);
	verticalAlign(moduleBook.find("h1"));
	moduleBook.find("p,h2,footer").animate({
		opacity:0
	},150);
	moduleBook.animate({
		width:'20px',
		left: -offsetLeft
	},300,	function(){
		$(".moduleshelf").remove();
		$("#page-content-wrapper").append("<div id=\"sidebar-module\" class=\"col-md-1\"></div>")
		$("#sidebar-module, #sidebar-wrapper").css("background-color",currentColor);
		$("#page-content-wrapper").css("background-color",alphaColor1);
		$("#sidebar-module").append("<span class=\"glyphicon glyphicon-chevron-right\"></span>"+"<h1>"+title+"</h1>");
		verticalAlign($("#sidebar-module").find("h1"));
		createSidebar();
		$("#page-content-wrapper").append(slidingPanelViewHtml);
		$("#page-content-wrapper").css("height","100%");
		$("#page-content-wrapper").append(addButton);
		createSlidingPanel();
		bindOverPanel(currentColor);
	});
			console.log("bind");

	moduleBook.nextAll().animate({
		right:-$(window).width()-offsetLeft
	});
};

function bindOverPanel(currentColor) {
	$("#page-content-wrapper").on("mouseenter",".data-box", function() {
		$(this).find(".over").css("width",$(this).css("width"));
		$(this).find(".over").css("height", $(this).css("height"));
		var alphaColor2 = getAlphacolor(currentColor,0.9);
		$(this).find(".over").css("background-color",alphaColor2);
		$(this).find(".over").animate({
			opacity:1
		}, 100);
		}
	);
	$("#page-content-wrapper").on("mouseleave",".data-box", function() {
			$(this).find(".over").animate({
				opacity:0
			}, 100);
		}
	);	
}


function createSlidingPanel() {
		var slideCount = slidingPanelInit(database,"box-container","prev-btn","next-btn", 3);
		$("#main-container").append(carouselIndicators(slideCount));
		$(".carousel-control.right").click(function(){
			var activeIndicator = $(".carousel-indicators .active:first");
			if(activeIndicator.next().length>0) {
				activeIndicator.removeClass("active");
				activeIndicator.next().addClass("active");
			} 
			if((activeIndicator.next().index()+1) == $(".carousel-indicators li").length) {
				$(".carousel-control.right").addClass("disabled");
			} 
			$(".carousel-control.left").removeClass("disabled");

		});
		$(".carousel-control.left").click(function(){
			var activeIndicator = $(".carousel-indicators .active:first");
			if(activeIndicator.prev().length>0) {
				activeIndicator.removeClass("active");
				activeIndicator.prev().addClass("active");
			}
			if(activeIndicator.prev().index()==0) {
				$(".carousel-control.left").addClass("disabled");
			} 
			$(".carousel-control.right").removeClass("disabled");
		});
	}


function createSidebar(){
	var showSidebar = function(e){
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    };

    $("#sidebar-wrapper").hover(function(e) {
      showSidebar(e);
    });

    $("#sidebar-toggle-area").hover(function(e){
      showSidebar(e);
      console.log("sidebar hovered");
    });
}

function getAlphacolor(currentColor, alpha){

	//color the background with the module book color and make the color deeper
    var lastComma = currentColor.lastIndexOf(')');
    var newColor = "rgba"+currentColor.slice(3, lastComma) + ","+alpha+" )";
	$(".moduleshelf").css("background-color", newColor);
	return newColor;
}

function verticalAlign(moduleBook) {
	moduleBook.css("-ms-writing-mode", "tb-rl");
	moduleBook.css("-webkit-writing-mode","vertical-rl"); 
	moduleBook.css("-moz-writing-mode","vertical-rl");
	moduleBook.css("-ms-writing-mode","vertical-rl");
	moduleBook.css("writing-mode","vertical-lr");
}

$('.moduleshelf').mouseout(function(){
	$('.modulebook').css("opacity","1.0");
});

$('#fb-icon').mouseover(function(){
	$(this).attr("src","../../res/img/fbicon-color-30.png");
});

$('#fb-icon').mouseout(function(){
	$(this).attr("src","../../res/img/fbicon-30.png");
});