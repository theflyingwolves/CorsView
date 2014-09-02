var generateNavBarHtml = function(){
	var navBarHtml = "<div id=\"search-form\" role=\"form\" class=\"form-inline\">"+
      "<input type=\"text\" class=\"form-control\"/>"+
    "</div>"+  	
    "<a class=\"logo\" href=\"#\"><img src=\"../../res/img/icon.png\"></img></a>"+    
    "<div class=\"links\">"+
      "<a href=\"#\">ABOUT</a>"+
    "</div>"+
    "<div class=\"links\">"+
      "<a href=\"#\">CONTACT</a>"+
      "<img id=\"fb-icon\" src=\"../../res/img/fbicon-30.png\"></img></a>"+
    "</div>";
  return navBarHtml;
};