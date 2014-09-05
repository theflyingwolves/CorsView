var addButton = "<div id=\"addButton\" class=\"circle\" data-toggle=\"modal\" data-target=\"#review-modal\"><span class=\"glyphicon glyphicon-plus\"></span></div>";

var crossButton = "<div id=\"removeButton\" class=\"circle empty\" onclick=\"slideModuleIn();\"><span class=\"glyphicon glyphicon-remove\"></span></div>";

var slidingPanelViewHtml = "<div id=\"review-container\" >"+
   "<a id=\"prev-btn\" class=\"left carousel-control disabled\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>"+
  "<div  id=\"main-container\" class=\"col-md-9\">"+  
    "<div class=\"row\" id=\"box-container\">"+
    "</div></div>"+  
    "<a id=\"next-btn\" class=\"right carousel-control\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>"+
  "</div>" +addButton+crossButton;

 var carouselIndicators = function(slideCount){
 	if(slideCount > 0) {
 		var html = "<ol class=\"carousel-indicators\">"+
 		"<li data-slide-to=\"0\" class=\"active\"></li>";
 		for(var i=0; i<slideCount-1; i++) {
 		html += "<li ></li>";
 		}
 		html += "</ol>";
 	}
 	return html;
  }


  