var router = Backbone.Router.extend({
	routes:{
	'':'home',
	':moduleCode':'loadModuleInfo',
	':moduleCode/info':'loadModuleInfo',
	':moduleCode/review':'loadModuleReview'
	},

	initialize:function(){

	},

	home: function(){
		loadNavBar();
	},

	loadModuleInfo: function(moduleCode){
		loadNavBar();
		this.courseView = new courseView({el:$("#module-info-container"), collection:moduledb});
		this.courseView.render(moduleCode);
	},

	loadModuleReview:function(moduleCode){
		alert(moduleCode);
	}
});

var loadNavBar = function(){
		this.navigationBarView = new navBarView({el:$("#navigation-bar")});
		this.navigationBarView.render();
};