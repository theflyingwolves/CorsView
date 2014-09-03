var generateNavBarHtml = function(){
	var navBarHtml = 
   "<div id=\"search-container\">"+
    "<div id=\"search-form\" class=\"form-group has-feedback\">"+
     "<input id=\"reg-search-input\" type=\"text\" class=\"form-control\" id=\"inputWarning2\" placeholder=\"Search Module to Add\">"+
     "<span  class=\"glyphicon glyphicon-search form-control-feedback\"></span>"+
    "</div>"+
   "</div>"+

  // "<div id=\"search-form\" role=\"form\" class=\"form-inline\">"+
  //     "<input type=\"text\" class=\"form-control\"/>"+
  //   "</div>"+  	
    "<a class=\"logo\" href=\"#\"><img src=\"../../res/img/icon.png\"></img></a>"+    
    "<div class=\"links\">"+
      "<a href=\"#\">ABOUT</a>"+
    "</div>"+
    "<div class=\"links\">"+
      "<a href=\"#\">CONTACT</a>"+
      // "<img id=\"fb-icon\" src=\"../../res/img/fbicon-30.png\"></img>"+

    "</div>"
      +"<a  id=\"fb-icon\" href=\"personalPage.html\"><img src=\"../../res/img/fbicon-30.png\"></img></a>"
    ;

  return navBarHtml;
};

