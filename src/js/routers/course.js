var globalModuleCode;
var router = Backbone.Router.extend({
	routes:{
	'':'home',
	':moduleCode':'loadModuleInfo',
	':moduleCode/info':'loadModuleInfo',
	':moduleCode/reviews':'loadModuleReview',
	':moduleCode/resources':'loadModuleResource'
	},

	initialize:function(){
		loadNavBar();
	},

	home: function(){
		initEventListeners();
	},

	loadModuleInfo: function(moduleCode){
		globalModuleCode = moduleCode;
		resetUrl();
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var httpRequestData = generateModInfoReqData(moduleCode, {});
		var serverUrl = getServerUrl();
		$.ajax({
			url:serverUrl,
			data:httpRequestData,
			success:function(data){
				var moduledb = data;
				this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
				this.infoView.render(moduleCode);
			},
			error : function(err, req) {
		        console.log(err);
		        console.log(req);
		  }
		});

		// this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});

		initEventListeners();
	},

	loadModuleReview:function(moduleCode){
		globalModuleCode = moduleCode;
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var moduleReview = moduleReviewDB;
		this.reviewView = new courseReviewView({el:$("#module-info-container"),collection:moduleReview});
		this.reviewView.render(moduleCode);

		initEventListeners();
	},

	loadModuleResource:function(moduleCode){
		globalModuleCode = moduleCode;
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var moduleResource = moduleResourceDB;
		this.resourceView = new courseResourceView({el:$("#module-info-container"),collection:moduleResource});
		this.resourceView.render(moduleCode);

		initEventListeners();
	}
});

var resetWrapper = function(){
		if(!$("#wrapper").hasClass("toggled")){
			$($("#wrapper").addClass("toggled"));
		}
};

var loadNavBar = function(){
		this.navigationBarView = new navBarView({el:$("#navigation-bar")});
		this.navigationBarView.render(globalModuleCode);
};

var loadSidebarWrapper = function(moduleCode){
	this.sidebarView = new sideBarView({el:$("#sidebar-wrapper")});
	this.sidebarView.render(moduleCode);
};

var initEventListeners = function(){
	$("#search-button").unbind("click");
	$("#search-button").click(function(e){
		// var serverUrl = getServerUrl();
		// var moduleCode = $("#search-text").val().toUpperCase();
		// if(moduleCode.length > 0){
		// 	var httpRequestData = generateModInfoReqData(moduleCode,{});
		// 	$.ajax({
		// 		url:serverUrl,
		// 		data:httpRequestData,
		// 		success:function(data){
		// 			var moduledb = data;
		// 			this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
		// 			this.infoView.render(moduleCode);
		// 		}
		// 	});
		// }
		var moduleCode = $("#search-text").val().toUpperCase();
		globalModuleCode = moduleCode;
		resetUrl();
	});

	$(".review-like-button").click(function(e){
		alert("liked "+e.target.id);
	});

	$(".review-dislike-button").click(function(e){
		alert("disliked "+e.target.id);
	});
};

var resetUrl = function(){
		var prevUrl = window.location.href;
		window.location.href = prevUrl.substring(0,prevUrl.indexOf("?"))+"#"+globalModuleCode+"/info";
};