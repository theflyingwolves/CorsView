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
	},

	loadModuleInfo: function(moduleCode){
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var httpRequestData = generateModInfoReqData(moduleCode, {});
		var serverUrl = getServerUrl();
		// $.get({
		// 	url:serverUrl,
		// 	data:httpRequestData,
		// 	success:function(data){
		// 		alert("Data Received");
		// 		alert(JSON.stringify(data));
		// 		var moduledb = data;
		// 		this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
		// 		this.infoView.render(moduleCode);
		// 	}
		// });

		this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
		this.infoView.render(moduleCode);
	},

	loadModuleReview:function(moduleCode){
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var moduleReview = moduleReviewDB;
		this.reviewView = new courseReviewView({el:$("#module-info-container"),collection:moduleReview});
		this.reviewView.render(moduleCode);
	},

	loadModuleResource:function(moduleCode){
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var moduleResource = moduleResourceDB;
		this.resourceView = new courseResourceView({el:$("#module-info-container"),collection:moduleResource});
		this.resourceView.render(moduleCode);
	}
});

var resetWrapper = function(){
		if(!$("#wrapper").hasClass("toggled")){
			$($("#wrapper").addClass("toggled"));
		}	
};

var loadNavBar = function(){
		this.navigationBarView = new navBarView({el:$("#navigation-bar")});
		this.navigationBarView.render();
};

var loadSidebarWrapper = function(moduleCode){
	this.sidebarView = new sideBarView({el:$("#sidebar-wrapper")});
	this.sidebarView.render(moduleCode);
};