var navBarView = Backbone.View.extend({
	render:function(){
		var navBarHtml = generateNavBarHtml();
		var template = _.template(navBarHtml,{});
		this.$el.html(template);
	}
});

var modulesShelfView = Backbone.View.extend({
	render:function(){
		var moduleDataDB = this.collection.models;
		var template = generateModuleShelfHtml(moduleDataDB);
		this.$el.html(template);
	}
});

var moduleInfoSideBarView = Backbone.View.extend({
	render:function(moduleCode){
		var data = this.collection.where({
			moduleCode:moduleCode
		})[0];

		var template = _.template(sideBarInfoTemplate,data.attributes);
		this.$el.html(template);
	}
});

var moduleReviewPanelView = Backbone.View.extend({
	render:function(moduleCode){
		var data = this.collection.where({
			moduleCode:moduleCode
		})[0];

		var template;
		if(data == undefined){
			template = _.template(moduleReviewPanelViewTemplate,{});
		}else{
			template = _.template(moduleReviewPanelViewTemplate,data.attributes);
		}

		this.$el.html(template);

	}
});