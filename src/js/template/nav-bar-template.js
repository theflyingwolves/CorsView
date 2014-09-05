var generateNavBarHtml = function(){

	var navBarHtml = 
   "<div id=\"search-container\">"+
    "<div id=\"search-form\" class=\"form-group has-feedback\">"+
     "<input id=\"reg-search-input\" type=\"text\" class=\"form-control\" placeholder=\"Search Module to Add\">"+

     "<span  class=\"glyphicon glyphicon-search form-control-feedback\"></span>"+
    "</div>"+
    // "<div class=\"fb-like\" data-href=\"http://54.179.139.143/\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\" style=\"float:left\"></div>"+

   "</div>"+

    "<a class=\"logo\" href=\"../html/index.html\"><img src=\"../../res/img/icon.png\"></img></a>"+    
    "<div class=\"links\">"+
      "<a href=\"#\">ABOUT</a>"+
    "</div>"+
    "<div class=\"links\">"+
      "<a href=\"#\">CONTACT</a>"+
    "</div>"+
      "<fb:login-button id=\"fb-icon\" scope=\"public_profile,email\"  onlogin=\"checkLoginState();\"></fb:login-button>";

  return navBarHtml;
};

var userProfile = "<a id=\"profile\" type=\"button\" class=\"btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" rel=\"tooltip\"><img></img></a>";