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
          "<input type=\"text\" class=\"form-control\"  id=\"searchText\" placeholder=\"Search Modules\">"+
        "</div>"+
        "<button type=\"submit\" class=\"btn btn-default\">Search</button>"+
      "</form>"+
      "<ul class=\"nav navbar-nav navbar-right\">"+
        "<li class=\"dropdown\">"+
          "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><img src=\"../../res/img/user.png\" width=20><span class=\"caret\"></span></a>"+
          "<ul class=\"dropdown-menu\" role=\"menu\">"+
            "<li><a href=\"#\">Action</a></li>"+
            "<li><a href=\"#\">Another action</a></li>"+
            "<li><a href=\"#\">Something else here</a></li>"+
            "<li class=\"divider\"></li>"+
            "<li><a href=\"#\">Separated link</a></li>"+
          "</ul>"+
        "</li>"+
      "</ul>"+
    "</div>"+
  "</div>"+
  "</nav>";