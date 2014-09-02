var indexRouter = Backbone.Router.extend({
	routes:{
		'':'home',
		':moduleCode':'loadModulePage',
		':moduleCode/info':'loadModulePage'
	},

	initialize:function(){
		loadNavBar();
	},

	home:function(){
		loadModuleShelf();
		initEventListeners();
	},

	loadModulePage: function(moduleCode){
		loadModuleHomepage(moduleCode);
	}
});

var loadNavBar = function(){
	console.log("loading nav bar");
	this.navBarView = new navBarView({el:$(".top-nav")});
	this.navBarView.render();
};

var loadModuleShelf = function(){
	console.log("loading module shelf");
	this.moduleShelfView = new modulesShelfView({el:$(".moduleShelf"),collection:moduledb});
	this.moduleShelfView.render();
};

var loadModuleHomepage = function(moduleCode){
	loadModuleInfoSidebar(moduleCode);
};

var loadModuleInfoSidebar = function(moduleCode){
	console.log("Loading module info sidebar");
	this.moduleSideBarView = new moduleInfoSideBarView({el:$("#module-info-container"),collection:moduledb});
	this.moduleSideBarView.render(moduleCode);
};

var initEventListeners = function(){
	$('.modulebook').mouseenter(function(){
		$('.modulebook').not(this).animate({
			opacity:'0.4'
		},300);
		$(this).css("opacity","1.0");
	});

	$('.modulebook').click(function(){
		slideModuleOut($(this));
		var moduleCode = $(this).find("h2").text().toUpperCase();

		var currentUrl = window.location.href;
		window.location.href = (currentUrl.substring(0,currentUrl.indexOf("#"))) + ("#"+moduleCode);
	});

	$('.moduleshelf').mouseout(function(){
		$('.modulebook').css("opacity","1.0");
	});

	$('#fb-icon').mouseover(function(){
		$(this).attr("src","../../res/img/fbicon-color-30.png");
	});

	$('#fb-icon').mouseout(function(){
		$(this).attr("src","../../res/img/fbicon-30.png");
	});
};