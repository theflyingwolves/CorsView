var generateReviewContentHtml = function(reviews){
  var reviewContentStart = "<div class=\"jumbotron\">"+
    "<div class=\"page-header\" id=\"module-header\">"+
      "<h2>CS2102 Database Systems</h2>"+
      "<h2><small>Module Review</small></h2>"+
    "</div>"+
    "<hr>";

  var reviewContentMiddleOpen = "<div class=\"review-box\">"+
      "<div class=\"row\">"+
      "<div class = \"col-sm-6 col-md-11\">"+
      "<p id=\"review-content\">";

  // var reviewContentMiddleClosed = "</p>"+"</div>"+
  //     "<div class= \"col-sm-6 col-md-1\">"+
  //     "<div class=\"row\">"+
  //       "<img src=\"../../res/img/like.png\" width=30 class=\"review-like-button\"/>"+
  //     "</div>"+
  //     "<div class=\"row\">"+
  //       "<img src=\"../../res/img/dislike.png\" width=30 class=\"review-dislike-button\"/>"+
  //     "</div>"+
  //     "</div>"+ "</div>"+"</div>";

  var reviewContentEnd = "<hr><div class=\"row\" id=\"add-review-div\">"+
        "<div class = \"col-sm-6 col-md-12\">"+
        "<form>"+
          "<textarea type=\"text\" class=\"form-control\" id=\"add-review-textbox\"></textarea>"+
          "<button type=\"submit\" class=\"btn btn-default pull-right\" id=\"review-submit-button\">Submit New Review</button>"+
        "</form>"+
        "</div>"+
      "</div>"+
      "</div>";

  var length = reviews.length;
  var reviewContentHtml = reviewContentStart;
  var index = 0;
  for(index = 0; index < length; index++){
    var reviewContentMiddleClosed = generateReviewBoxEnding(index);
    reviewContentHtml += (reviewContentMiddleOpen + reviews[index] + reviewContentMiddleClosed);
  }

  reviewContentHtml += reviewContentEnd;

  return reviewContentHtml;
};

var generateReviewBoxEnding = function(index){
    var reviewContentMiddleClosed = "</p>"+"</div>"+
      "<div class= \"col-sm-6 col-md-1\">"+
      "<div class=\"row\">"+
        "<img src=\"../../res/img/like.png\" width=30 class=\"review-like-button\" id=\"review-like-button-"+index+"\"/>"+
      "</div>"+
      "<div class=\"row\">"+
        "<img src=\"../../res/img/dislike.png\" width=30 class=\"review-dislike-button\" id=\"review-dislike-button-"+index+"\"/>"+
      "</div>"+
      "</div>"+ "</div>"+"</div>";

    return reviewContentMiddleClosed;
};