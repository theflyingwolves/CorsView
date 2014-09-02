function shareReview(){
  FB.ui({
          method: 'share',
          href: 'https://developers.facebook.com/docs/',
        }, function(response){});          
}

function shareTakeModuleStory(){
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

