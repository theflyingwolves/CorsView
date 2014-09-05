String.prototype.hashCode = function(){
    var hash = 0;
    if (this.length == 0) return hash;
    for (i = 0; i < this.length; i++) {
        char = this.charCodeAt(i);
        hash = ((hash<<5)-hash)+char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}


var FBUserName = "";
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      fblogin();
      $("#fb-login-button").hide();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      // document.getElementById('status').innerHTML = 'Please log ' +
        // 'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      // document.getElementById('status').innerHTML = 'Please log ' +
        // 'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '490249021111231',
    //appId : '490249021111231',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function fblogin() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(fbResponse) {
      FBUserName = fbResponse.name;
      FBUserID = fbResponse.email.hashCode();
	console.log(FBUserID);
      console.log('Successful login for: ' + fbResponse.name);
      // document.getElementById('status').innerHTML =
        // 'Thanks for logging in, ' + response.name + '!';
      $("#fb-user-link").html("<a href=\"#\">"+FBUserName+"</a>");
      // $("#fb-logout-navbar").show();
      $("#user-profile-dropdown").show();
    
      //register or login our own server
      console.log('../../api/users/'+FBUserID);
      $.ajax({
            url: '../../api/users/'+FBUserID,
              type : 'GET',
              dataType: "json",
              contentType: "application/json; charset=utf-8",
              //data: JSON.stringify(content),
              success : function(response) {
		console.log(response['message']);
                if((response['message']) == "user's not registered"){
                       userInfo = {
                            facebookID: FBUserID,
                            facebookName: fbResponse.name,
                            gender: fbResponse.gender,
                            accessToken: FB.getAuthResponse()['accessToken']
                          };
                          $.ajax({
                            url: '../../api/users',
                            type: 'POST',
                            dataType: "json",
                            data: JSON.stringify(userInfo),
                            contentType: "application/json; charset=utf-8",
                            success: function(){
                                 //console.log("user registered successfully");
                            },
                            error : function(err, req) {
                                 console.log(err);
                                 console.log(req);
                            }
                          }); //user registration ends
                      
                  } else{
                          //user login
                          userInfo = {
                            facebookID: FBUserID,
                            accessToken: FB.getAuthResponse()['accessToken']
                          };
                          $.ajax({
                            url: '../../api/users',
                            type: 'PUT',
                            dataType: "json",
                            data: JSON.stringify(userInfo),
                            contentType: "application/json; charset=utf-8",
                            success: function(){
                                console.log("user logins successfully");
                                getUserPicture();
                            },
                            error : function(err, req) {
                                 console.log(err);
                                 console.log(req);
                            }
                          }); //user login ends
                  }
               },
                    error : function(err, req) {
                           console.log(err);
                           console.log(req);
              }
            });
    });
  }

  var fblogout = function(){
      FB.logout(function(response){
        console.log("Successfully Logout");
      });
      $("#fb-login-button").show();
      // $("#fb-user-link").html("");
      $("#user-profile-dropdown").hide();
      FBUserName = "";
      $("#profile").popover("hide");
      $("#profile").hide();
  };

//   window.fbAsyncInit = function() {
//     FB.init({
//         appId   : '490249021111231',
//         oauth   : true,
//         status  : true, // check login status
//         cookie  : true, // enable cookies to allow the server to access the session
//         xfbml   : true,// parse XFBML
//     version    : 'v2.1' // use version 2.1

//     });

//   };

// function fb_login(){
//     FB.login(function(response) {

//         if (response.authResponse) {
//             console.log('Welcome!  Fetching your information.... ');
//             //console.log(response); // dump complete info
//             access_token = response.authResponse.accessToken; //get access token
//             user_id = response.authResponse.userID; //get FB UID

//           FB.api('/me', function(fbResponse) {
//             FBUserName = fbResponse.name;
//             FBUserID = fbResponse.email.hashCode();
//         console.log(FBUserID);
//             console.log('Successful login for: ' + fbResponse.name);
//             // document.getElementById('status').innerHTML =
//               // 'Thanks for logging in, ' + response.name + '!';
//             $("#fb-user-link").html("<a href=\"#\">"+FBUserName+"</a>");
//             // $("#fb-logout-navbar").show();
//             $("#user-profile-dropdown").show();
          
//             //register or login our own server
//             console.log('../../api/users/'+FBUserID);
//             $.ajax({
//                   url: '../../api/users/'+FBUserID,
//                     type : 'GET',
//                     dataType: "json",
//                     contentType: "application/json; charset=utf-8",
//                     //data: JSON.stringify(content),
//                     success : function(response) {
//           console.log(response['message']);
//                       if((response['message']) == "user's not registered"){
//                              userInfo = {
//                                   facebookID: FBUserID,
//                                   facebookName: fbResponse.name,
//                                   gender: fbResponse.gender,
//                                   accessToken: FB.getAuthResponse()['accessToken']
//                                 };
//                                 $.ajax({
//                                   url: '../../api/users',
//                                   type: 'POST',
//                                   dataType: "json",
//                                   data: JSON.stringify(userInfo),
//                                   contentType: "application/json; charset=utf-8",
//                                   success: function(){
//                                        //console.log("user registered successfully");
//                                   },
//                                   error : function(err, req) {
//                                        console.log(err);
//                                        console.log(req);
//                                   }
//                                 }); //user registration ends
                            
//                         } else{
//                                 //user login
//                                 userInfo = {
//                                   facebookID: FBUserID,
//                                   accessToken: FB.getAuthResponse()['accessToken']
//                                 };
//                                 $.ajax({
//                                   url: '../../api/users',
//                                   type: 'PUT',
//                                   dataType: "json",
//                                   data: JSON.stringify(userInfo),
//                                   contentType: "application/json; charset=utf-8",
//                                   success: function(){
//                                       console.log("user logins successfully");
//                                       window.location.href = "index.html";
//                                   },
//                                   error : function(err, req) {
//                                        console.log(err);
//                                        console.log(req);
//                                   }
//                                 }); //user login ends
//                         }
//                      },
//                           error : function(err, req) {
//                                  console.log(err);
//                                  console.log(req);
//                     }
//                   });
//           });

//         } else {
//             //user hit cancel button
//             console.log('User cancelled login or did not fully authorize.');

//         }
//     }, {
//         scope: 'publish_stream,email'
//     });
// }
// (function() {
//     var e = document.createElement('script');
//     e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
//     e.async = true;
//     document.getElementById("fb-root").appendChild(e);
// }());
