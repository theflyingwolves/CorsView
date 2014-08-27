$('.modulebook').mouseenter(function(){

	$('.modulebook').not(this).animate({
		opacity:'0.4'
	},300);
	$(this).css("opacity","1.0");
});

$('.modulebook').click(function(){
	var offsetLeft = $(this).offset().left;
	//color the background with the module book color and make the color deeper
	var currentColor = $(this).css("background-color");
    var lastComma = currentColor.lastIndexOf(')');
    var newColor = "rgba"+currentColor.slice(3, lastComma) + ", 0.3 )";
	$(".moduleshelf").css("background-color", newColor);
	$(this).prevAll().animate({
		left: -offsetLeft
	},300);
	$(this).find("h1").css("-ms-writing-mode", "tb-rl");
	$(this).find("h1").css("-webkit-writing-mode","vertical-rl"); 
	$(this).find("h1").css("-moz-writing-mode","vertical-rl");
	$(this).find("h1").css("-ms-writing-mode","vertical-rl");
	$(this).find("h1").css("writing-mode","vertical-lr");
	$(this).find("p").animate({
		opacity:0
	},150)
	$(this).animate({
		width:'20px',
		left: -offsetLeft
	},300);
	$(this).nextAll().animate({
		right:-$(window).width()-offsetLeft
	})
	console.log(newColor+" "+currentColor);

})


$('.moduleshelf').mouseout(function(){
	$('.modulebook').css("opacity","1.0");
});

$('#fb-icon').mouseover(function(){
	$(this).attr("src","../../res/img/fbicon-color-30.png");
})

$('#fb-icon').mouseout(function(){
	$(this).attr("src","../../res/img/fbicon-30.png")
})