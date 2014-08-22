var courseInfoViewHtml = "<div class = \"jumbotron\">"+
  "<div class=\"page-header\">"+
    "<h2><%= moduleCode %> <small><%= moduleTitle %></small></h2>"+
  "</div>"+
  "<hr>"+
  "<div class=\"page-header module-subheading\">"+
    "<h4>General Information</h4>"+
  "</div>"+
  "<p id=\"module-info\">"+
    "<%=  moduleDescription %>"+
  "</p>"+
  "<div class=\"page-header module-subheading\">"+
    "<h4>Pre-requisites</h4> "+
  "</div>"+
  "<p id=\"module-info\"><%= modulePrerequisite %></p>"+
  "<div class=\"page-header module-subheading\">"+
    "<h4>Preclusions</h4>"+
  "</div>"+
  "<p id=\"module-info\"><%= modulePreclusion %></p>"+
  "<div class=\"page-header module-subheading\">"+
    "<h4>Module Credits</h4>"+
  "</div>"+
  "<p id=\"module-info\"><%= moduleCredit %></p>"+
"</div>";