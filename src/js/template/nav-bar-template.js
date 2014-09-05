var generateNavBarHtml = function(){
  // if(！leftTitle || leftTitle == undefined) {
  //   leftTitle = "ABOUT";
  // }
  // if(！leftTitle || leftTitle == undefined) {
  //   rightTitle = "CONTACT";
  // }

	var navBarHtml = 
   "<div id=\"search-container\">"+
    "<div id=\"search-form\" class=\"form-group has-feedback\">"+
     "<input id=\"reg-search-input\" type=\"text\" class=\"form-control\" placeholder=\"Search Module to Add\">"+
     //"<input id=\"reg-search-input\" type=\"text\" class=\"form-control\" id=\"inputWarning2\" placeholder=\"Search Module to Add\">"+

     "<span  class=\"glyphicon glyphicon-search form-control-feedback\"></span>"+
    "</div>"+
   "</div>"+

  // "<div id=\"search-form\" role=\"form\" class=\"form-inline\">"+
  //     "<input type=\"text\" class=\"form-control\"/>"+
  //   "</div>"+  	
    "<a class=\"logo\" href=\"../html/index.html\"><img src=\"../../res/img/icon.png\"></img></a>"+    
    "<div class=\"links\">"+
      "<a href=\"#\">ABOUT</a>"+
    "</div>"+
    "<div class=\"links\">"+
      "<a href=\"#\">CONTACT</a>"+
      // "<img id=\"fb-icon\" src=\"../../res/img/fbicon-30.png\"></img>"+

    "</div>"+
      "<fb:login-button id=\"fb-icon\" scope=\"public_profile,email\"  onlogin=\"checkLoginState();;\"></fb:login-button>";

  return navBarHtml;
};

var userProfile = "<a id=\"profile\" type=\"button\" class=\"btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" rel=\"tooltip\"><img></img></a>";