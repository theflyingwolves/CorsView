var generateReviewContentHtml = function(reviews){
  var reviewContentStart = "<div class=\"jumbotron\">"+
    "<div class=\"page-header\" id=\"module-header\">"+
      "<h2>CS2102 Database Systems</h2>"+
      "<h2><small>Module Review</small></h2>"+
    "</div>"+
    "<hr>";

  var reviewContentMiddleOpen = "<div class=\"review-box\">"+
      "<p id=\"review-content\">";

  var reviewContentMiddleClosed = "</p>"+"</div>";

  var reviewContentEnd = "</div>";

  var length = reviews.length;
  var reviewContentHtml = reviewContentStart;
  var index = 0;
  for(index = 0; index < length; index++){
    reviewContentHtml += (reviewContentMiddleOpen + reviews[index] + reviewContentMiddleClosed);
  }

  reviewContentHtml += reviewContentEnd;

  return reviewContentHtml;
};