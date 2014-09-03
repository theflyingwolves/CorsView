function loginIVLE(){
    var ivleLoginUrl = ivle.login("RLhd3fF75U1wzkSi71Ua4", "http://localhost/~wulifu/corsview/src/html/test2.html");
    window.location.href = ivleLoginUrl;
}

function importModules(){
  var token = ivle.getToken(window.location.href);
  if(token != null){
      var user = ivle.User("RLhd3fF75U1wzkSi71Ua4", token);
        user.init().done(
          function() {
            user.modulesTaken(function(mods) {
              console.log(mods);
            })
      })
  } else {
    
  }
}