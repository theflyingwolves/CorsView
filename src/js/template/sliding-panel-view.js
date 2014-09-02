var slidingPanelViewHtml = "<div id=\"review-container\" >"+
//"<div class=\"col-md-1\">"+
   "<a id=\"prev-btn\" class=\"left carousel-control disabled\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>"+
 // "<button class=\"btn btn-default\" id=\"prev-btn\" >Prev</button>"+ 
  "<div  id=\"main-container\" class=\"col-md-9\">"+  
    "<div class=\"row\" id=\"box-container\">"+
    "</div></div>"+  
 // "<div class=\"col-md-1\">"+
    "<a id=\"next-btn\" class=\"right carousel-control\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>"+
//	"<button class=\"btn btn-default\" id=\"next-btn\">Next</button>"+
  "</div>";

 var carouselIndicators = function(slideCount){
 	if(slideCount > 0) {
 		var html = "<ol class=\"carousel-indicators\">"+
 		"<li data-slide-to=\"0\" class=\"active\"></li>";
 		for(var i=0; i<slideCount-1; i++) {
 		html += "<li ></li>";
 		}
 		html += "</ol>";
 	}
 	console.log(html);
 	return html;
  }

  var addButton = "<div class=\"circle\"><span class=\"glyphicon glyphicon-plus\"></span></circle>"