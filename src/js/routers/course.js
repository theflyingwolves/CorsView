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
		resetWrapper();
		loadSidebarWrapper(moduleCode);
		var httpRequestData = generateModInfoReqData(moduleCode, {});
		var serverUrl = getServerUrl();
		console.log(serverUrl);
		// alert(serverUrl);
		console.log(httpRequestData);
		$.ajax({
			url:serverUrl,
			data:httpRequestData,
			success:function(data){
				// alert("Data Received");
				// alert(JSON.stringify(data));
				var moduledb = data;
				this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
				console.log("returned");
				this.infoView.render(moduleCode);
			},
			error : function(err, req) {
		        // alert("Your browser broke!");
		        console.log(err);
		        console.log(req);
		    }
		});

		this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
		// console.log("dummy");
		// this.infoView.render(moduleCode);

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
		// alert("event detected");
		var serverUrl = getServerUrl();
		console.log(serverUrl);
		var moduleCode = $("#search-text").val().toUpperCase();
		console.log(moduleCode);
		if(moduleCode.length > 0){
			console.log("length > 0");
			var httpRequestData = generateModInfoReqData(moduleCode,{});
			$.ajax({
				url:serverUrl,
				data:httpRequestData,
				success:function(data){
					// alert("hello");
					// alert(JSON.stringify(data));
					var moduledb = data;
					this.infoView = new courseInfoView({el:$("#module-info-container"), collection:moduledb});
					console.log("returned");
					this.infoView.render(moduleCode);
				}
			});
			// alert(serverUrl+" \n"+JSON.stringify(httpRequestData));
		}
	});

	$(".review-like-button").click(function(e){
		alert("liked "+e.target.id);
	});

	$(".review-dislike-button").click(function(e){
		alert("disliked "+e.target.id);
	});
};