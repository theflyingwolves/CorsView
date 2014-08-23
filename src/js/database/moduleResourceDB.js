var moduleResourceData = [
{
	moduleCode:"CS2102",
	moduleResource:[{
		"resTitle":"CS2102 Resource 1",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"CS2102 Resource 2",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"CS2102 Resource 3",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"CS2102 Resource 4",
		"resLink":"http://www.google.com"
	}]
},

{
	moduleCode:"CS2020",
	moduleResource:[{
		"resTitle":"CS2020 Resource 1",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"CS2020 Resource 2",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"CS2020 Resource 3",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"CS2020 Resource 4",
		"resLink":"http://www.google.com"
	}]
},

{
	moduleCode:"MA1100",
	moduleResource:[{
		"resTitle":"MA1100 Resource 1",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"MA1100 Resource 2",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"MA1100 Resource 3",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"MA1100 Resource 4",
		"resLink":"http://www.google.com"
	}]
},

{
	moduleCode:"MA3238",
	moduleResource:[{
		"resTitle":"MA3238 Resource 1",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"MA3238 Resource 2",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"MA3238 Resource 3",
		"resLink":"http://www.google.com"
	},
	{
		"resTitle":"MA3238 Resource 4",
		"resLink":"http://www.google.com"
	}]
}];

var ResourceDB = Backbone.Collection.extend({});

var moduleResourceDB = new ResourceDB({});
moduleResourceDB.reset(moduleResourceData);