var historyIndex = 0;
var history = [];

var numOfCols;

var data;
var id;

var numOfElementsLoaded;

var isEndReached, isBeginningReached;

function slidingPanelInit(database,containerId,prevBtnId, nextBtnId, numOfColumns){
	initAnimation(containerId, prevBtnId, nextBtnId);
	numOfCols = numOfColumns;
	id = containerId;
	data = database;
	isEndReached = false;
	isBeginningReached = false;

	$(function(){
		initTestBox();
		initHistory();
		initColumnContainers(numOfCols);
		loadNextPage();
	});
}

function nextPage(){
	setTimeout(function(){
		loadNextPage();
	},1000);
}

function prevPage(){
	setTimeout(function(){
		loadPrevPage();
	},1000);
}

function loadNextPage(){
	if(isEndReached){
		return ;
	}

	if(isBeginningReached){
		isBeginningReached = false;
	}

	var i,j;
	for(i=0;i<numOfCols;i++){
		if(history[historyIndex] == undefined){
			if(i != 0){
				for(j=i; j<numOfCols;j++){
					$("#col-"+j).html("");
				}
			}

			console.log("Reaches the end");
			isEndReached = true;
			break ;
		}
		
		var html = generateColHtml(data,history[historyIndex]);
		$("#col-"+i).html(html);
		historyIndex++;
	}

	if(i != 0){
		numOfElementsLoaded = i;
	}

	console.log("Index Ends At: "+historyIndex);
}

function loadPrevPage(){
	if(isBeginningReached){
		return ;
	}

	if(isEndReached){
		isEndReached = false;
	}

	if(historyIndex == numOfCols){
		console.log("Reaches the Beginning");
		isBeginningReached = true;
		return ;
	}

	historyIndex -= numOfElementsLoaded;
	var histcounter = historyIndex - numOfCols;

	var i;
	for(i=0;i<numOfCols;i++){
		var html = generateColHtml(data,history[histcounter]);
		$("#col-"+i).html(html);
		histcounter ++;
	}

	numOfElementsLoaded = i;

	console.log("Index Ends At: "+historyIndex);
}

function initColumnContainers(numOfColumns){
	var html = "";
	var columnWidth = 12 / numOfCols;
	for(var i=0;i<numOfColumns;i++){
		html += "<div class=\"col-md-"+columnWidth+"\" id=\"col-"+i+"\"></div>";
	}
	$("#"+id).html(html);
}

function initTestBox(){
	var colWidth = 12 / numOfCols;
	$("#"+id).append("<div class=\"row\" id=\"test-div\"> <div class=\"col-md-"+colWidth+"\" id=\"test-box\"></div></div>");
	$("#test-box").hide();
}

function initHistory(){
	var counter = 0;
	var slideCount = 0;

	while(counter < data.length){
		var indices = initOneSlide(data,counter);
		console.log("Starting History Init: "+data.length);
		history[slideCount] = indices;
		slideCount++;
		counter = (indices[indices.length-1]+1);
	}

	console.log("Finishing History Init");

	$("#test-div").remove();
}

function initOneSlide(data, startCount){
	var indices = [];
	var indicesLength = 0;
	var totalHeight = 0;
	var windowHeight = $(window).height();
	var temp = "";
	var counter = startCount;

	while(totalHeight <= windowHeight){
		temp = temp + generateBoxHtml(data[counter]);
		$("#test-box").html(temp);
		totalHeight = $("#test-box").height();
		if(totalHeight <= windowHeight){
			indices[indicesLength] = counter;
			indicesLength++;
			counter++;
		}
	}

	return indices;
}

// Generate the HTML string for a column using data from database of the given indices in indexArray
function generateColHtml(database, indexArray){
	var data;
	var html = "";
	for(var i=0;i<indexArray.length;i++){
		var index = indexArray[i];
		if(index >= database.length || index < 0){
			break;
		}else{
			data = database[index];
			html += generateBoxHtml(data);
		}
	}

	return html;
}

function generateBoxHtml(str){
	var html = "<div class=\"data-box\">";
	html += str;
	html += "</div>";
	return html;
}

function initAnimation(containerId, prevBtnId, nextBtnId){
	var target = $("#"+containerId);

	initAnimationDuration(target);

	$("#"+prevBtnId).click(function(){
		prevPage();
		if(!(isBeginningReached || historyIndex == numOfCols)){
			target.addClass("animated bounceOutRight");
		}
	});

	$("#"+nextBtnId).click(function(){
		nextPage();
		if(!(isEndReached || history[historyIndex]==undefined)){
			target.addClass("animated bounceOutLeft");
		}
	});
	
	target.on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(e){
		if(target.hasClass("bounceOutLeft")){
			target.removeClass("animated bounceOutLeft");
			target.addClass("animated bounceInRight");
		}else if(target.hasClass("bounceOutRight")){
			target.removeClass("animted bounceOutRight");
			target.addClass("animated bounceInLeft");
		}else if(target.hasClass("bounceInRight")){
			target.removeClass("animated bounceInRight");
		}else if(target.hasClass("bounceInLeft")){
			target.removeClass("animated bounceInLeft");
		}
	});
}

function initAnimationDuration(target){
	var cssString = "-webkit-animation-duration: 1s; -webkit-animation-delay: 0s; -webkit-animation-iteration-count: 1;";
	cssString += "-moz-animation-duration: 1s; -moz-animation-delay: 0s; -moz-animation-iteration-count: 1;";
	cssString += "-MS-animation-duration: 1s; -MS-animation-delay: 0s; -MS-animation-iteration-count: 1;";
	target.css(cssString);
}