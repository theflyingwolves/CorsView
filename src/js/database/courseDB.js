var moduleDataReceiver = function(keyword, callback){
	keyWord ={
		keyWord: keyword
	};

	$.ajax({
		url: '../../api/modules/search',
  		type : 'POST',
  		dataType: "json",
  		contentType: "application/json; charset=utf-8",
  		data: JSON.stringify(keyWord),
  	  success : function(response) {
  		  var moduleInfoList = response['moduleInfoList'];
        var moduleInfoToBeUsed = moduleInfoList.slice(0,9);
        moduledb.reset(moduleInfoToBeUsed);
  		  callback(keyword);
  	  },
  	  error : function(err, req) {
  	    console.log(err);
  	    console.log(req);
  	  }
  });
};

var ModuleDatabase = Backbone.Collection.extend({});
var moduledb = new ModuleDatabase();

var moduleDataInit = function(keyword,info) {
	//empty string seems causes exception in database searching
	if(keyword == ""){
		keyword = "CS";
	}

  if(info == "home"){
    moduleDataReceiver(keyword,homepageHandler);  
  }else if(info == "module-page"){
    moduleDataReceiver(keyword,modulePageHandler);
  }

};

var homepageHandler = function(moduleCode){
  loadModuleData();
};

var modulePageHandler = function(moduleCode){
  loadModuleHomepage(moduleCode);
};