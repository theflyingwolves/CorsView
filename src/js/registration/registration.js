var modulesAdded = [];
var numOfModulesAdded = 0;
var rowFrontierIndices = [2,2,2,2,2,2];
var randomColorGenerator;
var cellWidth = 0, cellHeight = 0;

var addDisplayTable = function(){
		var feedbackHtml = "<div id=\"add-feedback\"></div>";
		var tableHtml = generateModuleTable(regTableNumOfRows,regTableNumOfCols);
		$("#display-container").html(feedbackHtml+tableHtml);
		initHighlight();
};

var generateModuleTable = function(rows,cols){
	randomColorGenerator = new RandomColorGenerator();
	randomColorGenerator.init();
	var table = "<div class=\"reg-display-table-outer\">";
	table += "<div class=\"reg-display-table-inner\">";
	table += "<table>";

	for(var row = 0; row < rows; row++){
		table += generateRow(row,100);
	}

	table += "</table>"+"</div>"+"</div>";

	return table;
};

var generateRow = function(rowId, cellWidth){
	var row = "<tr>";
	var numOfCols = 20;
	for(var i=0; i<numOfCols;i++){
		if(i==0){
			row += ("<th class=\"cell row-header\" id=\"cell-"+rowId+"-"+i+"\" style=\"background-color:#2A2A2A; color:#AAAAAA;\">"+
									"<p>"+(rowId+1)+"000</p>"+
							"</th>");
		}else{
			row += ("<td class=\"cell\" id=\"cell-"+rowId+"-"+i+"\"></td>");
		}
	}

	row += "</tr>";
	return row;
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
			addToColumn(parseInt(c)-1,moduleToAdd);
			$("#add-feedback").html("<div class=\"alert alert-success\">Successfully Added: "+moduleToAdd+"</div>");
		}
	}
};

var addToColumn = function(rowNum,moduleToAdd){
	var moduleDiv = regGenerateModuleTableDiv(moduleToAdd,rowNum);
	console.log("#cell-"+rowNum+"-"+rowFrontierIndices[rowNum]);
	$("#cell-"+rowNum+"-"+rowFrontierIndices[rowNum]).html(moduleDiv);
	rowFrontierIndices[rowNum] ++;
	if(rowFrontierIndices[rowNum] >= 8){
		$(".reg-display-table-inner").css({"overflow-x":"scroll"});
	}

	updateHighlight(rowNum);
};

var regGenerateModuleTableDiv = function(moduleToAdd,rowNum){
	var randomColor = randomColorGenerator.generate();
	var divHtml = "<div style=\"background-color:"+randomColor+";\" class=\"module-content-div\" id=\"module-content-div-"+rowNum+"-"+rowFrontierIndices[rowNum]+"\">";
	divHtml += "<p>"+moduleToAdd.substring(0,moduleToAdd.indexOf(" "))+"</p>";
	divHtml += "<br><span class=\"glyphicon glyphicon-remove\"></span>";
	divHtml += "</div>";
	return divHtml;
};

var updateHighlight = function(rowNum){
	$("#cell-"+rowNum+"-"+rowFrontierIndices[rowNum]).animate({
		backgroundColor:"#BBBBBB"
	}, 1000, function(){});

	$("#cell-"+rowNum+"-"+(rowFrontierIndices[rowNum]+1)).animate({
		backgroundColor:"#888888"
	}, 1000, function(){});

	$("#cell-"+rowNum+"-"+(rowFrontierIndices[rowNum]+2)).animate({
		backgroundColor:"#333333"
	}, 1000, function(){});
};

var initHighlight = function(){
	for(var i=0;i<6;i++){
		updateHighlight(i);
	}
};

var downgradeHighlight = function(rowNum){
	$("#cell-"+rowNum+"-"+rowFrontierIndices[rowNum]).animate({
		backgroundColor:"#888888"
	}, 1000, function(){});

	$("#cell-"+rowNum+"-"+(rowFrontierIndices[rowNum]+1)).animate({
		backgroundColor:"#333333"
	}, 1000, function(){});

	$("#cell-"+rowNum+"-"+(rowFrontierIndices[rowNum]+2)).animate({
		backgroundColor:"#2A2A2A"
	}, 1000, function(){});
};

var deleteModule = function(row, col){
	var moduleCode =$("#cell-"+row+"-"+col+" div").text();
	var index = modulesAdded.indexOf(moduleCode);
	if(index > -1){
		modulesAdded.splice(index,1);
	}
	console.log("delete module: "+moduleCode+" "+index);
	var frontier = rowFrontierIndices[row];
	if(frontier > 2){
		for(var c = col; c <= frontier-1; c++){
			c = parseInt(c);
			var updatedHtml = $("#cell-"+row+"-"+(c+1)).html();
			var divToMove = $("#cell-"+row+"-"+c);
			// console.log("#cell-"+row+"-"+(c+1));
			divToMove.html(updatedHtml);
			divToMove.hide()
			.html(updatedHtml)
			.fadeIn('slow')
			;
		}
		$("#cell-"+row+"-"+(frontier-1)).html("");
		downgradeHighlight(row);
		rowFrontierIndices[row]--;
	}
};


var initEventListeners = function(){
	$("#add-module-btn").click(function(){
		var moduleToAdd = $("#reg-search-input").val();
		addModuleToTable(moduleToAdd);
		var moduleToAdd = $("#reg-search-input").val("");
	});

	$(document).keypress(function(e){
		if(e.which == 13){
			var moduleToAdd = $("#reg-search-input").val();
			addModuleToTable(moduleToAdd);
			var moduleToAdd = $("#reg-search-input").val("");
		}
	});

	$("#display-container").on("mouseenter",".module-content-div",function() {
		console.log("enter div");
		$(this).find("span").css("opacity","1");
	});
	$("#display-container").on("mouseleave",".module-content-div",function() {
		$(this).find("span").css("opacity","0");
	});
	$("#display-container").on("click",".module-content-div span",function() {
		var idInfo = $(this).parent().parent().attr("id");
		var row = idInfo.split("-")[1];
		var col = idInfo.split("-")[2];

		deleteModule(row, col);
	});
};

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


