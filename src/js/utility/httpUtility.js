// Server Url
var getServerUrl = function(){
	return "../../../api/index.php";
};

// Module Info
var generateModInfoReqData = function(moduleCode, content){
	var modInfoReqUrl = generateModInfoReqUrl(moduleCode);
	return {
		"url":modInfoReqUrl,
		"data":content
	};
};

var generateModInfoReqUrl = function(moduleCode){
	return "api/modules/"+moduleCode;
};


// Module Review
var generateModReviewReqData = function(moduleCode, content){
	var modReviewReqUrl = generateModReviewReqUrl(moduleCode);
	return {
		"url":modReviewReqUrl,
		"data":content
	};
};

var generateModReviewReqUrl = function(moduleCode){
	return "api/modules/"+moduleCode+"/reviews";
};

// Module Resource
var generateModResourceReqData = function(moduleCode, content){
	var modResourceReqUrl = generateModResourceReqUrl(moduleCode);
	return {
		"url":modResourceReqUrl,
		"data":content
	};
};

var generateModResourceReqUrl = function(moduleCode){
	return "api/modules/"+moduleCode+"/resources";
};