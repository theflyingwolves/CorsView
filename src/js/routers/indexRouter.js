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
	addNavBarListener();
};

var loadModuleShelf = function(){

	var query = getSearch();
	console.log(query)
	if(query == undefined || query == null || query == ""){
		moduleDataInit("");
	} else {
		moduleDataInit(query);
	}
};

var loadModuleData = function(){
	if(moduledb.length == 0){
		console.log("empty module");
		// $(".moduleShelf").append("<div class=\"backboard\"><p>No such course</p></div>");
	} else {
		console.log("load module data");
		cleanupPageForModuleShelfView();
		this.moduleShelfView = new modulesShelfView({el:$(".moduleShelf"),collection:moduledb});
		this.moduleShelfView.render();
		initIndexEventListeners();

	}
}

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
		console.log("bookshelf defined");
		slideModuleOut(bookShelf);
	}else{
		loadModuleReviewPanel(moduleCode);
	}
};

var getTheme = function(){
	var currentUrl = window.location.href;
	var urlSearch = currentUrl.substring(currentUrl.indexOf("?"));
	var query = getQueryParams(urlSearch);
	return query.theme;
}

var getIndex = function(){
	var currentUrl = window.location.href;
	var urlSearch = currentUrl.substring(currentUrl.indexOf("?"));
	var query = getQueryParams(urlSearch);
	return query.index;
}

var getSearch = function() {
	var currentUrl = window.location.href;
	var urlSearch = currentUrl.substring(currentUrl.indexOf("?"));
	var query = getQueryParams(urlSearch);
	return query.search;	
}

var loadModuleReviewPanel = function(moduleCode){

		console.log("bookshelf undefined; theme"+getURLParameter("theme"));
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
		createSlidingPanel(moduleCode);
		bindOverPanel(currentColor);

};

var loadModuleInfoSidebar = function(moduleCode){
	console.log("Loading module info sidebar");
	this.moduleSideBarView = new moduleInfoSideBarView({el:$("#module-info-container"),collection:moduledb});
	this.moduleSideBarView.render(moduleCode);
};

function getQueryParams(qs) {
    qs = qs.split("+").join(" ");

    var params = {}, tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}


var initIndexEventListeners = function(){
	// $(".modulebook").unbind();
	// $(".moduleShelf").unbind();
	// $("#fb-icon").unbind();
	$("#reg-search-input").unbind();
	$('.modulebook').mouseenter(function(){
		$('.modulebook').not(this).animate({
			opacity:'0.4'
		},100);
		$(this).css("opacity","1.0");
	});

	$('.modulebook').click(function(){
		// slideModuleOut($(this));
		var moduleCode = $(this).find("h2").text().toUpperCase();
		var currentUrl = window.location.href;
		var themeColor = $(this).css("background-color");

		var index = $(".moduleShelf .modulebook").index($(this));
		var index1 = currentUrl.indexOf("#");
		var index2 = currentUrl.indexOf("?");
		console.log("index1 "+index1+" 2 "+index2);
		if(index1 > -1){
			index2 = Math.min(index1, index2);
		}
		console.log(currentUrl.substring(0,index2));
		window.location.href = (currentUrl.substring(0,index2)) + ("#"+moduleCode)+"?theme="+themeColor+"&index="+index;
	});

	$('.moduleshelf').mouseout(function(){
		$('.modulebook').css("opacity","1.0");
	});


	$("#reg-search-input").on("keyup change",function(){
		moduleDataInit($(this).val());
	});
};