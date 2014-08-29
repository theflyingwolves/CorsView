$('.modulebook').mouseenter(function(){

	$('.modulebook').not(this).animate({
		opacity:'0.4'
	},300);
	$(this).css("opacity","1.0");
});

$('.modulebook').click(function(){
	slideModuleOut($(this));
	var moduleCode = $(this).find("h2").val().toUpperCase();
	globalModuleCode = moduleCode;
	resetUrl();
	console.log("click"+$(this).attr("class"));
})

$(".sidebar-module").click(function(){
		console.log("clicked2");

})

function slideModuleOut(moduleBook) {
	var offsetLeft = moduleBook.offset().left;
	setBgcolor(moduleBook);
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
		moduleBook.removeClass("modulebook");
		moduleBook.addClass("sidebar-module");
				console.log("before "+moduleBook.attr("class"));
}
	);
	moduleBook.nextAll().animate({
		right:-$(window).width()-offsetLeft
	});
}

function setBgcolor(moduleBook){

	//color the background with the module book color and make the color deeper
	var currentColor = moduleBook.css("background-color");
    var lastComma = currentColor.lastIndexOf(')');
    var newColor = "rgba"+currentColor.slice(3, lastComma) + ", 0.3 )";
	$(".moduleshelf").css("background-color", newColor);
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