var creatorID = "";
var accessToken = "";

$('.modulebook').mouseenter(function(){
	$('.modulebook').not(this).animate({
		opacity:'0.4'
	},300);
	$(this).css("opacity","1.0");
});

$('.modulebook').click(function(){
	// slideModuleOut($(this));

	var moduleCode = $(this).find("h2").text().toUpperCase();

	var currentUrl = window.location.href;
	window.location.href = (currentUrl.substring(0,currentUrl.indexOf("#"))) + ("#"+moduleCode);

})

// $('.moduleshelf').mouseout(function(){
// 	$('.modulebook').css("opacity","1.0");
// });

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
		$(".module-shelf-inner").remove();
		$("#page-content-wrapper").append("<div id=\"sidebar-module\" class=\"col-md-1\"></div>");
		$("#page-content-wrapper").css("background-color",alphaColor1);
		$("#page-content-wrapper").append(slidingPanelViewHtml);
		$("#page-content-wrapper").css("height","100%");
		$("#sidebar-module, #sidebar-wrapper").css("background-color",currentColor);
		$("#sidebar-module").append("<span class=\"glyphicon glyphicon-chevron-right\"></span>"+"<h1>"+title+"</h1>");
		verticalAlign($("#sidebar-module").find("h1"));
		
		createSidebar();
		var moduleCode = moduleBook.find("h2").text();
		createSlidingPanel(moduleCode);
		bindOverPanel(currentColor);
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


var createSlidingPanel = function(moduleCode) {
	//console.log("retrieve "+moduleCode);
	  $.ajax({
	  //url: "../../api/modules/"+moduleCode+"/documents",
	    url: "../../api/modules/"+moduleCode+"/reviews",
	    type : 'GET',
	    dataType: "json",
	    //contentType: "appliction/json; charset=utf-8",
	    success : function(data) {
			var reviewArrayFromDB = [];
	      $.each(data['reviewList'],function(index,value){
	      	reviewArrayFromDB.push(data['reviewList'][index]['reviewContent']);
	        // console.log(data['reviewList'][index]['reviewContent']);
	     	});
	        renderSlidingPanel(reviewArrayFromDB);

	    },
	    error : function(err, req) {
	                 console.log(err);
	                 console.log(req);
	    }
	  });
              
              $.ajax({
                url: "../../api/modules/"+moduleCode+"/documents",
                type : 'GET',
                dataType: "json",
                //contentType: "appliction/json; charset=utf-8",
                success : function(data) {
                    var documentArrayFromDB = [];
                  $.each(data['documentList'],function(index,value){
                    documentArrayFromDB.push('<strong>'+data['documentList'][index]['documentTitle']+"</strong>"+"<br>"+data['documentList'][index]['documentLink']);
                    });
                    renderSlidingPanel(documentArrayFromDB);

                },
                error : function(err, req) {
                             console.log(err);
                             console.log(req);
                }
              });
};

var renderSlidingPanel = function(reviewArrayFromDB) {

	var slideCount = slidingPanelInit(reviewArrayFromDB,"box-container","prev-btn","next-btn", 3);
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
    alert(document.URL);
    var pathname = window.location.pathname;
      FB.ui({
        method: 'share',
        //href: 'http://www.douban.com',
        //href: 'http://ec2-54-179-139-143.ap-southeast-1.compute.amazonaws.com//src/html/test.html',
        href: 'http://ec2-54-179-139-143.ap-southeast-1.compute.amazonaws.com/src/html/index2.html#CS2102',
        //href: 'http://news.163.com/14/0904/09/A59QD57O00014SEH.html',
        //href:document.URL,
      }, function(response){});
}

function bindOverPanel(currentColor) {
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



	$("#review-submit-btn").click(function() {
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
}



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
      console.log("sidebar hovered");
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


