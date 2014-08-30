var historyIndex = 0;
var history = [];

var numOfCols;

var data;
var id;

var numOfElementsLoaded;

var isEndReached, isBeginningReached;

function slidingPanelInit(database,containerId,prevBtnId, nextBtnId, numOfColumns){
	var prevBtnId = prevBtnId;
	var nextBtnId = nextBtnId;
	initAnimation(containerId, prevBtnId, nextBtnId);
	numOfCols = numOfColumns;
	id = containerId;
	data = database;
	isEndReached = false;
	isBeginningReached = false;
	var slideCount;
	$(function(){
		initTestBox();
		colCount = initHistory();
		slideCount = Math.ceil(colCount/3);
		initColumnContainers(numOfCols);
		loadNextPage();
	});
	return slideCount;
}

function nextPage(){
	setTimeout(function(){
		loadNextPage();
	},400);
}

function prevPage(){
	setTimeout(function(){
		loadPrevPage();
	},400);
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
	} else {
		//$("#"+prevBtnId).addClass("carousel-control");
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
		console.log("Index length: "+history.length);
	console.log("Index Ends At: "+historyIndex+" slideCount"+slideCount);
	console.log(history);
	return slideCount;
}

function initOneSlide(data, startCount){
	var indices = [];
	var indicesLength = 0;
	var totalHeight = 0;
	var windowHeight = $(window).height()*0.8;
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
	var html = "<article class=\"data-box\">";
	html += "<div class=\"over\">"
	html += "<span class=\"glyphicon glyphicon-heart-empty\"></span>"
	html += "<span class=\"glyphicon glyphicon-comment\"></span>"
	html += "<span class=\"glyphicon glyphicon-share-alt\"></span>"
	html += "</div>"
	html += "<p>"+str+"</p>";
	html += "</article>";
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
	var cssString = "-webkit-animation-duration: 0.4s; -webkit-animation-delay: 0s; -webkit-animation-iteration-count: 1;";
	cssString += "-moz-animation-duration: 0.4s; -moz-animation-delay: 0s; -moz-animation-iteration-count: 1;";
	cssString += "-MS-animation-duration: 0.4s; -MS-animation-delay: 0s; -MS-animation-iteration-count: 1;";
	target.css(cssString);
}