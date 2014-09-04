var generateModuleShelfHtml = function(moduleData){
	var colorThemeGenerator = new RandomColorGenerator();
	colorThemeGenerator.init();
	var moduleShelfHtml = "<div class=\"module-shelf-inner\">";
	var data;
	for(var i = 0; i < moduleData.length;i++){
		data = moduleData[i].attributes;
		moduleShelfHtml += "<div class=\"modulebook\" id = \"module-book-"+data.moduleCode+"\" style=\"background-color:"+colorThemeGenerator.generate()+";\">";
		moduleShelfHtml += ("<h2>"+data.moduleCode+"</h2>");
		moduleShelfHtml += ("<h1>"+data.moduleTitle+"</h1>");
		var description = data.moduleDescription;
		if(description.length > 400){
		 	description = description.substring(0,400)+" &hellip;";
		}
		moduleShelfHtml += ("<p>"+description+"</p>");
		moduleShelfHtml += "<footer><span class=\"glyphicon glyphicon-eye-open\"></span>ENTER MODULE</footer>";
		moduleShelfHtml += "</div>";
	}

	moduleShelfHtml += "</div>";

	return moduleShelfHtml;
};