var generateNavBarHtml = function(){
  var userName = FBUserName;
var navBarHtml = "<nav class=\"navbar-inverse navbar-default navbar-fixed-top\" role=\"navigation\">"+
  "<div class=\"container-fluid\">"+
    "<div class=\"navbar-header\">"+
      "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">"+
        "<span class=\"sr-only\">Toggle navigation</span>"+
        "<span class=\"icon-bar\"></span>"+
        "<span class=\"icon-bar\"></span>"+
        "<span class=\"icon-bar\"></span>"+
      "</button>"+
      "<a class=\"navbar-brand\" href=\"#\">CorsView</a>"+
    "</div>"+
    "<div class=\"collapse navbar-collapse\">"+
      "<form class=\"navbar-form navbar-left\" role=\"search\">"+
        "<div class=\"form-group\" id=\"searchDiv\">"+
          "<input type=\"text\" class=\"form-control\"  id=\"search-text\" placeholder=\"Search Modules\" name=\"moduleCode\">"+
        "</div>"+
        "<button type=\"submit\" class=\"btn btn-default\" id=\"search-button\">Search</button>"+
      "</form>"+
      "<div class=\"nav navbar-nav navbar-right row\" id=\"user-info-navbar\">"+
        "<div class=\"col-sm-6 col-md-6\">"+
          "<fb:login-button scope=\"public_profile,email\" id=\"fb-login-button\" onlogin=\"checkLoginState();\">"+
          "</fb:login-button>"+
        "</div>"+
        "<div class=\"col-sm-6 col-md-6\" id=\"user-profile-dropdown\">"+
          "<ul class=\"nav navbar-nav navbar-right\">"+
            "<li class=\"dropdown\">"+
              "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><img src=\"../../res/img/user.png\" width=20><span class=\"caret\"></span></a>"+
              "<ul class=\"dropdown-menu\" role=\"menu\">"+
                "<li id=\"fb-user-link\"></li>"+
                "<li><a href=\"#\">Profile</a></li>"+
                "<li><a href=\"#\">Settings</a></li>"+
                "<li class=\"divider\"></li>"+
                "<li id=\"fb-logout-navbar\"><a href=\"#\" onclick=\"fblogout()\">Log Out</a></li>"+
              "</ul>"+
            "</li>"+
          "</ul>"+
        "</div>"+
      "</div>"+
    "</div>"+
  "</div>"+
  "</nav>";
  return navBarHtml;
};