// var moduleReviewData = [
// {
// 	moduleCode:"CS2102",
// 	moduleReview:["Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102.",
// 								"Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102.",
// 								"Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102."]
// },

// {
// 	moduleCode:"CS2020",
// 	moduleReview:["Just some randome review for CS2020",
// 								"Some random review for CS2020",
// 								"Random review for CS2020"]
// },

// {
// 	moduleCode:"MA3238",
// 	moduleReview:["Just some randome review for MA3238",
// 								"Some random review for MA3238",
// 								"Random review for MA3238"]
// },

// {
// 	moduleCode:"MA1100",
// 	moduleReview:["Just some randome review for MA1100",
// 								"Some random review for MA1100",
// 								"Random review for MA1100"]
// }];
var moduleReviewData;
var ReviewDB = Backbone.Collection.extend({});
var moduleReviewDB = new ReviewDB({});

var reformatData = function(data){
	var updatedData = {};
	var reviews = [];
	for(var index = 0; index < data.reviewList.length;index++){
		reviews[index] = data.reviewList[index].reviewContent;
	}

	updatedData.moduleCode = data.reviewList[0].moduleCode;
	updatedData.moduleReview = reviews;
	moduleReviewData = updatedData;
	return updatedData;
};

var moduleReviewDataInit = function(moduleCode){
	console.log("Retrieving review data for "+moduleCode);
	$.ajax({
	  //url: "../../api/modules/"+moduleCode+"/documents",
	    url: "../../api/modules/"+moduleCode+"/reviews",
	    type : 'GET',
	    dataType: "json",
	    //contentType: "appliction/json; charset=utf-8",
	    success : function(data) {
	    	if(data.message != "reviews are not found."){
					// var reviewArrayFromDB = [];
	  	 //    $.each(data['reviewList'],function(index,value){
	    // 	  	reviewArrayFromDB.push(data['reviewList'][index]['reviewContent']);
	    //   	  // console.log(data['reviewList'][index]['reviewContent']);
	    //  		});
	    //   	renderSlidingPanel(reviewArrayFromDB);
	    		var newData = reformatData(data);
	    		moduleReviewDB.reset(newData);
	    		loadModuleReviewPanelData(moduleCode,"success");
	      }else{
	      	loadModuleReviewPanelData(moduleCode,"fail");
	      	console.log("no module review data received");
	      }
	    },
	    error : function(err, req) {
	                 console.log(err);
	                 console.log(req);
	    }
	});
};