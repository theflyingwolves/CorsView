var globalModuleReviewColor = undefined;

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
		console.log("loading home");
		loadModuleShelf();
		fadeinSearchForm();
	},

	loadModulePage: function(moduleCode){
		console.log("loading module: "+moduleCode);
		moduleDataInit(moduleCode, "module-page");
		loadSidebarToggleArea();
	}
});

var loadNavBar = function(){
	console.log("loading nav bar");
	this.navBarView = new navBarView({el:$(".top-nav")});
	this.navBarView.render();
	addNavBarListener();
	addProfileListener();
};

var loadModuleShelf = function(){
	var query = getSearch();

	if(query == undefined || query == null || query == ""){
		moduleDataInit("","home");
	} else {
		moduleDataInit(query,"home");
	}
};

var loadModuleData = function(){
	if(moduledb.length == 0){
		console.log("empty module");
		// $(".moduleShelf").append("<div class=\"backboard\"><p>No such course</p></div>");
	}else{
		cleanupPageForModuleShelfView();
		this.moduleShelfView = new modulesShelfView({el:$(".moduleShelf"),collection:moduledb});
		this.moduleShelfView.render();
		initIndexEventListeners();
	}
};

var cleanupPageForModuleShelfView = function(){
	$("#page-content-wrapper").html("");
	$("#page-content-wrapper").css("height","0");
	$(".moduleShelf").css("background-color","black");
	$("#sidebar-toggle-area").remove();
};

var loadSidebarToggleArea = function(){
	$("#sidebar-toggle-area-container").html("<div id=\"sidebar-toggle-area\"></div>");
};

var loadModuleHomepage = function(moduleCode){
	loadModuleInfoSidebar(moduleCode);
	var bookShelf = $("#module-book-"+moduleCode);
	if(bookShelf.length > 0){
		console.log("Loading with module shelf");
		slideModuleOut(bookShelf);
	}else{
		console.log("loading without module shelf");
		loadModuleReviewPanel(moduleCode,undefined);
	}
};

var fadeinSearchForm = function(){
	$(".top-nav .links:eq(0)").find("a").text("SEARCH");
	$(".top-nav .links:eq(1)").find("a").text("MODULE");
	$("#search-form").removeClass("inActive");
}

var fadeoutSearchForm = function(){
	$(".top-nav .links:eq(0)").find("a").text("MODULE");
	$(".top-nav .links:eq(1)").find("a").text("REVIEW");
	$("#search-form").addClass("inActive");
}

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

var loadModuleReviewPanel = function(moduleCode,color){
	if(color != undefined){
		globalModuleReviewColor = color;	
	}

	moduleReviewDataInit(moduleCode);
};

var loadModuleReviewPanelData = function(moduleCode,status){
		this.moduleReviewPanelViews = new moduleReviewPanelView({el:$("#page-content-wrapper"),collection:moduleReviewDB});
		this.moduleReviewPanelViews.render(moduleCode);

		if(globalModuleReviewColor == undefined){
			globalModuleReviewColor = getTheme();
		}
		currentColor = globalModuleReviewColor;
		alphaColor1 = getAlphacolor(currentColor,0.4);
		$(".module-shelf-inner").remove();
		$("#sidebar-module, #sidebar-wrapper").css("background-color",currentColor);
		$("#page-content-wrapper").css("background-color",alphaColor1);
		verticalAlign($("#sidebar-module").find("h1"));
		createSidebar();
		$("#page-content-wrapper").css("height","100%");
		if(moduleReviewData == undefined){
			createSlidingPanel([]);
		}else{
			createSlidingPanel(moduleReviewData.moduleReview);	
		}
		
		bindOverPanel(currentColor);
};

var getReviewColorFromUrl = function(){
	var url = window.location.href;

};

var loadModuleInfoSidebar = function(moduleCode){
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
		moduleDataInit($(this).val(),"home");
	});
};
