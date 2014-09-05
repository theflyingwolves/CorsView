function shareReview(){
  FB.ui({
          method: 'share',
          href: 'http://54.179.139.143/',
        }, function(response){});          
}

function shareTakeModuleStory(){
      console.log("share taken module story");
	FB.api(
      'me/corsview:take',
      'post', 
      {
        module: "http://samples.ogp.me/1464373243834483"
      },
      function(response) {
        
      }
    );
}

function getUserPicture(){
  FB.api("/me/picture?width=30&height=30",  function(fbPictureResponse) {
    console.log(fbPictureResponse.data.url);
    $("#profile img").attr("src",fbPictureResponse.data.url);
    $("#profile").show();
  });  
}

