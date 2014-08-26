$('.modulebook').mouseenter(function(){

	$('.modulebook').not(this).animate({
		opacity:'0.4'
	},300);
	$(this).css("opacity","1.0");
});

$('mousebook').click(function(){
	$(this).animate({
		width:'100%'
	},300);
})


$('.moduleshelf').mouseout(function(){
	$('.modulebook').css("opacity","1.0");
	console.log("out");
});

$('#fb-icon').mouseover(function(){
	$(this).attr("src","../../res/img/fbicon-color-30.png");
})

$('#fb-icon').mouseout(function(){
	$(this).attr("src","../../res/img/fbicon-30.png")
})