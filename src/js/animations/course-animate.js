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
	var lightColor = moduleBook.css("background-color");
	var darkColor = setBgcolor(moduleBook);
	var title = moduleBook.find("h1").text();
	moduleBook.prevAll().animate({
		left: -offsetLeft
	},300);
	verticalAlign(moduleBook.find("h1"));
	moduleBook.find("p,h2,footer").animate({
		opacity:0
	},150)
	moduleBook.animate({
		width:'20px',
		left: -offsetLeft
	},300,	function(){
		$(".moduleshelf").remove();
		$("#page-content-wrapper").append("<div id=\"sidebar-module\"></div>")
		$("#sidebar-module, #sidebar-wrapper").css("background-color",lightColor);
		$("#page-content-wrapper").css("background-color",darkColor);
		$("#sidebar-module").append("<h1>"+title+"</h1>");
		verticalAlign($("#sidebar-module").find("h1"));
		$("#page-content-wrapper").appendChild(slidingPanelViewHtml);
		createSidebar();
		slidingPanelInit(database,"box-container","prev-btn","next-btn", 2);
}
	);
	moduleBook.nextAll().animate({
		right:-$(window).width()-offsetLeft
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

function setBgcolor(moduleBook){

	//color the background with the module book color and make the color deeper
	var currentColor = moduleBook.css("background-color");
    var lastComma = currentColor.lastIndexOf(')');
    var newColor = "rgba"+currentColor.slice(3, lastComma) + ", 0.3 )";
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
})

$('#fb-icon').mouseout(function(){
	$(this).attr("src","../../res/img/fbicon-30.png")
})