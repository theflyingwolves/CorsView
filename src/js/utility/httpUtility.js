var generateModInfoReqData = function(moduleCode){
	var modInfoReqUrl = generateModInfoReqUrl(moduleCode);
	return {
		"url":modInfoReqUrl,
		"data":{};
	};
};

var generateModInfoReqUrl = function(moduleCode){
	return "api/modules/"+moduleCode;
};

var getServerUrl = function(){
	return "../../../api/index.php";
};