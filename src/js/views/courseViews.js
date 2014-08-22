var courseInfoView = Backbone.View.extend({
	render:function(moduleCode){
		var moduleData = this.collection.where({
			moduleCode:moduleCode
		})[0];
		var pageParams = {
			moduleCode:moduleData.get("moduleCode"),
			moduleTitle:moduleData.get("moduleTitle"),
			moduleDescription:moduleData.get("moduleDescription"),
			modulePrerequisite:moduleData.get("modulePrerequisite"),
			modulePreclusion:moduleData.get("modulePreclusion"),
			moduleCredit:moduleData.get("moduleCredit")
		};
		var template = _.template(courseInfoViewHtml,pageParams);
		this.$el.html(template);
	}
});

var courseReviewView = Backbone.View.extend({
	render:function(moduleCode){
		this.$el.html("");
	}
});

var navBarView = Backbone.View.extend({
	render:function(){
		var template = _.template(navBarHtml,{});
		this.$el.html(template);	
	}
});

var sideBarView = Backbone.View.extend({
	render:function(moduleCode){
		var template = _.template(sidebarHtml, {moduleCode:moduleCode});
		this.$el.html(template);
	}
});