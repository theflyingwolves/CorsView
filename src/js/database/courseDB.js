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
  		  callback(response, keyword);
  	  },
  	  error : function(err, req) {
  	    console.log(err);
  	    console.log(req);
  	  }
  });
};

var ModuleDatabase = Backbone.Collection.extend({});
var moduledb = new ModuleDatabase();
var moduleData;

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


var homepageHandler = function(response,moduleCode){
	var moduleInfoList = response['moduleInfoList'];
    var moduleInfoToBeUsed = moduleInfoList.slice(0,9);
    moduledb.reset(moduleInfoToBeUsed);
  	loadModuleData();
  	console.log("size "+moduledb.length);
};

var modulePageHandler = function(response,moduleCode){
	var moduleInfoList = response['moduleInfoList'];
  	var moduleInfoToBeUsed = moduleInfoList.slice(0,9);
   	moduledb.reset(moduleInfoToBeUsed);
  	loadModuleHomepage(moduleCode);
};
