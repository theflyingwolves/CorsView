var courseInfoView = Backbone.View.extend({
	render:function(moduleCode){
		// var moduleData = this.collection.where({
		// 	moduleCode:moduleCode
		// })[0];
		
		// var pageParams = {
		// 	moduleCode:moduleData.get("moduleCode"),
		// 	moduleTitle:moduleData.get("moduleTitle"),
		// 	moduleDescription:moduleData.get("moduleDescription"),
		// 	modulePrerequisite:moduleData.get("modulePrerequisite"),
		// 	modulePreclusion:moduleData.get("modulePreclusion"),
		// 	moduleCredit:moduleData.get("moduleCredit")
		// };

		// console.log(pageParams);

		var moduleData = JSON.parse(this.collection);	
		var pageParams = {
			moduleCode:moduleData['moduleCode'],
			moduleTitle:moduleData.moduleTitle,
			moduleDescription:moduleData.moduleDescription,
			modulePrerequisite:moduleData.modulePrerequisite,
			modulePreclusion:moduleData.modulePreclusion,
			moduleCredit:moduleData.moduleCredit
		};
		var template = _.template(courseInfoViewHtml,pageParams);
		this.$el.html(template);
	}
});

var courseReviewView = Backbone.View.extend({
	render:function(moduleCode){
		var reviewData = this.collection.where({
			moduleCode:moduleCode
		})[0];

		var reviewContentHtml = generateReviewContentHtml(reviewData.get("moduleReview"));
		var template = _.template(reviewContentHtml,{});
		this.$el.html(template);
	}
});

var courseResourceView = Backbone.View.extend({
	render:function(moduleCode){
		var resourceData = this.collection.where({
			moduleCode:moduleCode
		})[0];
		// alert(JSON.stringify(resourceData));
		var resourceContentHtml = generateResourceContentHtml(resourceData.get("moduleResource"));
		var template = _.template(resourceContentHtml,{});
		this.$el.html(template);
	}
});

var navBarView = Backbone.View.extend({
	render:function(moduleCode){
		var navBarHtml = generateNavBarHtml();
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