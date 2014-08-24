var generateResourceContentHtml = function(resources){
  var resourceContentHtmlBegin =   "<div class=\"jumbotron\">"+
    "<div class=\"page-header\" id=\"module-header\">"+
      "<h2>CS2102 <small>Database Systems</small></h2>"+
    "</div>"+
    "<hr>";
  var resourceContentHtmlEnd = "</div>";

  var resourceContentHtmlMiddleTitle = "<div class=\"resource-box\"><h4>";
  var resourceContentHtmlMiddleHref = "</h4><hr><a href=\"";
  var resourceContentHtmlMiddleLinkText = "\"><p>";
  var resourceContentHtmlMiddleClose = "</p></a></div></div>";

  var resCount = resources.length;
  var index = 0;

  var resBoxHtml = resourceContentHtmlBegin;

  for(index = 0; index < resCount; index++){
    var title = resources[index]["resTitle"];
    var link = resources[index]["resLink"];
    resBoxHtml += (resourceContentHtmlMiddleTitle+
                    title+
                    resourceContentHtmlMiddleHref+
                    link+
                    resourceContentHtmlMiddleLinkText+
                    link+
                    resourceContentHtmlMiddleClose);
  }

  resBoxHtml += resourceContentHtmlEnd;
  alert(resBoxHtml);
  return resBoxHtml;
};