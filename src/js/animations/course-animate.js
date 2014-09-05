String.prototype.hashCode = function(){
    var hash = 0;
    if (this.length == 0) return hash;
    for (i = 0; i < this.length; i++) {
        char = this.charCodeAt(i);
        hash = ((hash<<5)-hash)+char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;0
}


var slideModuleOut = function(moduleBook) {
	var offsetLeft = moduleBook.offset().left;
	var currentColor = moduleBook.css("background-color");
	var alphaColor1 = getAlphacolor(currentColor,0.3);
	var title = moduleBook.find("h1").text();
	moduleBook.prevAll().animate({
		left: -offsetLeft
	},300);
	verticalAlign(moduleBook.find("h1"));
	moduleBook.find("p,h2,footer").animate({
		opacity:0
	},150);
	moduleBook.animate({
		width:'20px',
		left: -offsetLeft
	},300,	function(){
		var moduleCode = moduleBook.find("h2").text();
		loadModuleReviewPanel(moduleCode,currentColor);
	});

	moduleBook.nextAll().animate({
		right:-$(window).width()-offsetLeft
	},200);
};

var slideModuleIn = function(index){
	console.log("slide module in");
	$("#page-content-wrapper").animate({
		bottom: -$(window).height()
	},300, function() {
		var currentUrl = window.location.href;
		moduleDataInit($("#reg-search-input").val());
		var bookWidth = $(window).width() * 0.19;
		var offsetLeft = (parseInt(index)+1) * bookWidth;
		var modulebook = $(".moduleShelf .modulebook:eq("+index+")");
		modulebook.prevAll().css("left",-offsetLeft);
		modulebook.css("left",-offsetLeft);
		modulebook.nextAll().css("right",-$(window).width()-offsetLeft);
		console.log("redirect");
		currentUrl = window.location.href;
		directingUrl = currentUrl.substring(0,currentUrl.indexOf("#"));
		if($("#reg-search-input").val() !== ""){
			directingUrl += "?search="+$("#reg-search-input").val();
		}
		window.location.href = directingUrl;
		modulebook.prevAll().animate({
			left: 0
		},300,function(){
		// setTimeout(function(){

		// },200);	
		});
		modulebook.animate({
			left: 0
		},300);
		modulebook.nextAll().animate({
			right:0
		});

	});

};


var createSlidingPanelUsingModuleCode = function(moduleCode){

};

var createSlidingPanel = function(moduleReviews) {
	//console.log("retrieve "+moduleCode);
	// console.log("Creating module review using "+JSON.stringify(moduleReview));
	// var moduleReviewArray = [];
	// if(moduleReview != undefined){
	// 	$.each(data['reviewList'],function(index,value){
	// 		moduleReviewArray.push(data['reviewList'][index]['reviewContent']);
	// 	});
	// }

	renderSlidingPanel(moduleReviews);

    // $.ajax({
    //   url: "../../api/modules/"+moduleCode+"/documents",
    //   type : 'GET',
    //   dataType: "json",
    //   //contentType: "appliction/json; charset=utf-8",
    //   success : function(data) {
    //     var documentArrayFromDB = [];
    //     console.log("Document Data: "+JSON.stringify(data));
    //     if(data.message != "documents are not found."){
	   //      $.each(data['documentList'],function(index,value){
	   //        documentArrayFromDB.push('<strong>'+data['documentList'][index]['documentTitle']+"</strong>"+"<br>"+data['documentList'][index]['documentLink']);
	   //      });
	   //      renderSlidingPanel(documentArrayFromDB);
	   //    }
    //   },
    //   error : function(err, req) {
    //    console.log(err);
    //    console.log(req);
    //   }
    // });
};

var loadFriendsPictures = function(){
	$("#sidebar-friends").append("<div><table></table></div>");
    FB.api('/me/friends', function(response) {
        var friendDataList = response.data;
        var frienndsNum = friendDataList.length;
        console.log("get friends num "+frienndsNum);
        var listNum = Math.min(frienndsNum,10);
        for(var i = 0; i < listNum; i++){
        	var friendData = friendDataList[i];
        	var friendId = friendData.id;
        	if(i%2 == 0){
        		$("#sidebar-friends table").append("<tr><td><img id=\""+friendId+"\"></img></td>");
        	} else {
        		$("#sidebar-friends table").append("<td></td><img id=\""+friendId+"\"></img></tr>");
        	}
        	FB.api("/"+friendId+"/picture?width=50&height=50",function(fbPictureResponse){
        		$("#"+friendId).attr("src",fbPictureResponse.data.url);
        	});
        };
    });
}

var renderSlidingPanel = function(reviewArrayFromDB) {
	var slideCount;
	if(reviewArrayFromDB.length > 0){
		slideCount = slidingPanelInit(reviewArrayFromDB,"box-container","prev-btn","next-btn", 3);	
	}else{
		slideCount = 0;
	}
	
	$("#main-container").append(carouselIndicators(slideCount));
	$(".carousel-control.right").click(function(){
		var activeIndicator = $(".carousel-indicators .active:first");
		if(activeIndicator.next().length>0) {
			activeIndicator.removeClass("active");
			activeIndicator.next().addClass("active");
		} 
		if((activeIndicator.next().index()+1) == $(".carousel-indicators li").length) {
			$(".carousel-control.right").addClass("disabled");
		} 
		$(".carousel-control.left").removeClass("disabled");
	});
	
	$(".carousel-control.left").click(function(){
		var activeIndicator = $(".carousel-indicators .active:first");
		if(activeIndicator.prev().length>0) {
			activeIndicator.removeClass("active");
			activeIndicator.prev().addClass("active");
		}
		if(activeIndicator.prev().index()==0) {
			$(".carousel-control.left").addClass("disabled");
		} 
		$(".carousel-control.right").removeClass("disabled");
	});
          //  share button
          $(".data-box").on("click",".glyphicon.glyphicon-share-alt",function(){
            //$(this).find(p).share();
           share();
    });


};

function share(){
    var pathname = window.location.pathname;
      FB.ui({
        method: 'share',
        //href: 'http://www.douban.com',
        //href: 'http://ec2-54-179-139-143.ap-southeast-1.compute.amazonaws.com//src/html/test.html',
        href: 'http://54.179.139.143/',
        // href: 'http://ec2-54-179-139-143.ap-southeast-1.compute.amazonaws.com/src/html/index2.html#CS2102',
        //href: 'http://news.163.com/14/0904/09/A59QD57O00014SEH.html',
        //href:document.URL,
      }, function(response){});
}

function bindOverPanel(currentColor) {

	//database over block handler
	$("#page-content-wrapper").on("mouseenter",".data-box", function() {
		$(this).find(".over").css("width",$(this).css("width"));
		$(this).find(".over").css("height", $(this).css("height"));
		var alphaColor2 = getAlphacolor(currentColor,0.9);
		$(this).find(".over").css("background-color",alphaColor2);
		$(this).find(".over").animate({
			opacity:1
		}, 100);
		}
	);

	$("#page-content-wrapper").on("mouseleave",".data-box", function() {
			$(this).find(".over").animate({
				opacity:0
			}, 100);
		}
	);


	//review submit button handler
	$("#review-submit-btn").click(function() {
                    console.log(FB.getAuthResponse()['accessToken']);
		var moduleCode = $("#module-info-container").find("h2").text();
		var moduleID, moduleTitle;

			var data = moduledb.where({
				moduleCode:moduleCode
			})[0];
			var str = JSON.stringify(data);
			var json = JSON.parse(str);
			moduleID = json.moduleID;
			moduleTitle = json.moduleTitle;
			console.log("module id "+moduleID);
					FB.api('/me', function(response) {
					   	creatorID = response.email.hashCode();
					   	accessToken =   FB.getAuthResponse()['accessToken'];

				var review = $("#review-area").val();
				content = {
			    		moduleID: moduleID,
			    		moduleCode: moduleCode,
			    		moduleTitle: moduleTitle,
			    		creatorID: creatorID,
			    		accessToken: accessToken,
	                                                    reviewContent: review,
					};
					console.log(content);

					$.ajax({
					url: '../../api/modules/'+moduleCode+'/reviews',
					  type : 'POST',
					  dataType: "json",
					  contentType: "application/json; charset=utf-8",
					  data: JSON.stringify(content),
					  success : function(response) {
					  	console.log(response['message']);
					   },
					        error : function(err, req) {
					               console.log(err);
					               console.log(req);
					  }
					});

					 });
	});

	//resource submit button handler
	$("#resource-submit-btn").click(function() {
	    console.log(FB.getAuthResponse()['accessToken']);
		var moduleCode = $("#module-info-container").find("h2").text();
		var moduleID, moduleTitle;

		for(var i = 0; i < moduleData.length; i++){
			var data = moduleData[i];
			if(data.moduleCode ==  moduleCode){
			    moduleID = data.moduleID;
			    moduleTitle = data.moduleTitle;

			    FB.api('/me', function(response) {
			        creatorID = response.id;
			        accessToken =   FB.getAuthResponse()['accessToken'];

			        var resourceTitle = $("#resourceTitle-area").val();
			        var resourceLink = $("#resourceLink-area").val();
			        content = {  
			            moduleID: moduleID,
			            moduleCode: moduleCode,
			            moduleTitle: moduleTitle,
			            creatorID: creatorID,
			            accessToken: accessToken,
			            documentTitle: resourceTitle,
			            documentLink:resourceLink
			        };
			        console.log(content);

			        $.ajax({
			        url: '../../api/modules/'+moduleCode+'/documents',
			          type : 'POST',
			          dataType: "json",
			          contentType: "application/json; charset=utf-8",
			          data: JSON.stringify(content),
			          success : function(response) {
			            console.log(response['message']);
			              alert(response['message']);
			           },
			                error : function(err, req) {
			                       console.log(err);
			                       console.log(req);
			          }
			        });

			     });
			                                break;
			}
		}
	});

	$("#sidebar-friends").hover(function(){
  		$("#sidebar-friends div").show();
	}, 
	function(){
		$("#sidebar-friends div").hide();
	});
};



function createSidebar(){
	var showSidebar = function(e){
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    };

    $("#sidebar-wrapper").hover(function(e) {
      showSidebar(e);
    });

    $("#sidebar-toggle-area").hover(function(e){
      showSidebar(e);
    });
}

function getAlphacolor(currentColor, alpha){

	//color the background with the module book color and make the color deeper
  var lastComma = currentColor.lastIndexOf(')');
  var newColor = "rgba"+currentColor.slice(3, lastComma) + ","+alpha+" )";
	$(".moduleShelf").css("background-color", newColor);
	return newColor;
}

function verticalAlign(moduleBook) {
	moduleBook.css("-ms-writing-mode", "tb-rl");
	moduleBook.css("-webkit-writing-mode","vertical-rl"); 
	moduleBook.css("-moz-writing-mode","vertical-rl");
	moduleBook.css("-ms-writing-mode","vertical-rl");
	moduleBook.css("writing-mode","vertical-lr");
}


