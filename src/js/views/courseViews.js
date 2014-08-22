var courseView = Backbone.View.extend({
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

var navBarView = Backbone.View.extend({
	render:function(){
		var template = _.template(navBarHtml,{});
		this.$el.html(template);	
	}
});