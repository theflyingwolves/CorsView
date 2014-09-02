var globalModuleReviewColor;

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
		loadSidebarToggleArea();
		loadModuleHomepage(moduleCode);
	}
});

var loadNavBar = function(){
	console.log("loading nav bar");
	this.navBarView = new navBarView({el:$(".top-nav")});
	this.navBarView.render();
};

var loadModuleShelf = function(){
	cleanupPageForModuleShelfView();
	this.moduleShelfView = new modulesShelfView({el:$(".moduleShelf"),collection:moduledb});
	this.moduleShelfView.render();
};

var cleanupPageForModuleShelfView = function(){
	$("#page-content-wrapper").html("");
	$("#page-content-wrapper").css("height","0");
	$(".moduleShelf").css("background-color","black");
	$("#sidebar-toggle-area").remove();
};

var loadSidebarToggleArea = function(){
	$("#sidebar-toggle-area-container").html("<div id=\"sidebar-toggle-area\"></div>");
}

var loadModuleHomepage = function(moduleCode){
	loadModuleInfoSidebar(moduleCode);
	var bookShelf = $("#module-book-"+moduleCode);
	if(bookShelf.length > 0){
		console.log("bookShelf defined");
		slideModuleOut(bookShelf);
	}else{
		loadModuleReviewPanel(moduleCode);
	}
};

var loadModuleReviewPanel = function(moduleCode){
		console.log("bookshelf undefined");
		this.moduleReviewPanelViews = new moduleReviewPanelView({el:$("#page-content-wrapper"),collection:moduleReviewDB});
		this.moduleReviewPanelViews.render(moduleCode);
		currentColor = "rgb(100,0,0)";
		alphaColor1 = getAlphacolor(currentColor,0.4);
		console.log(alphaColor1);
		$(".module-shelf-inner").remove();
		$("#sidebar-module, #sidebar-wrapper").css("background-color",currentColor);
		$("#page-content-wrapper").css("background-color",alphaColor1);
		verticalAlign($("#sidebar-module").find("h1"));
		createSidebar();
		$("#page-content-wrapper").css("height","100%");
		createSlidingPanel();
		bindOverPanel(currentColor);
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