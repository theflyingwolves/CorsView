var modulesAdded = [];
var numOfModulesAdded = 0;

var addPersonalPageEventListener = function(){
	addNavBarListener();

	$(".module-table li:not(:first-child)").hover(function() {
		if($(this).find("span").length==0){
			$(this).append(removeButtonHtml);
			$(this).css("padding-bottom","5px");
		}
	}, function() {

		$(this).find("span").remove();
		$(this).css("padding-bottom","15px");
	});

	$(".module-table li").on("click","span",function(){
		var li = $(this).parent();
		var ul = li.parent();
		var row = ul.find("li").index(li);
		var col = $(".module-table ul").index(ul);
		deleteModule(col,row);
	});

	$("#sharebutton").click( function() {
		shareTakeModuleStory();
	});


	$(document).keypress(function(e){
		if(e.which == 13){
			var moduleToAdd = $("#reg-search-input").val();
			addModuleToTable(moduleToAdd);
			var moduleToAdd = $("#reg-search-input").val("");
		}
	});
}





var addModuleToTable = function(moduleToAdd){
	if(moduleToAdd.length > 6){
		var moduleCode = moduleToAdd.substring(0,moduleToAdd.indexOf(" "));
		if($.inArray(moduleCode,modulesAdded) >= 0){
			$("#add-feedback").html("<div class=\"alert alert-warning\">Module Already Exists: "+moduleToAdd+"</div>");
		}else{
			modulesAdded[numOfModulesAdded] = moduleCode;
			numOfModulesAdded ++;
			var c = moduleToAdd.substring(2,3);
			addToColumn(parseInt(c)-1,moduleCode);
			$("#add-feedback").html("<div class=\"alert alert-success\">Successfully Added: "+moduleToAdd+"</div>");
		}
	}
};

var addToColumn = function(col, moduleCode){
	$(".module-table ul:eq("+col+")").append("<li><p>"+moduleCode+"</p></li>");
}

var deleteModule = function(col,row){
	var ul = $(".module-table ul")[col];
	var e = $(ul).find("p");
	var li = $(ul).children("li:eq("+row+")");
	li.remove();
}

var initAutoCompleteData = function(){
	var available_tags = [
	  "CS2020 Data Structure and Algorithms",
	  "MA3238 Stochastic Process",
	  "MA2101 Linear Algebra",
	  "CS2102 Database System",
	  "CS1101S Programming Methodology",
	  "IS1103FC Information Security",
	  "ST2132 Mathematical Statistics",
	  "MA3110 Mathematical Analysis II"
	];

	$("#reg-search-input").autocomplete({
	  source:available_tags
	});

	// $("#reg-search-input").autocomplete("option","position",{z-index:})
};
