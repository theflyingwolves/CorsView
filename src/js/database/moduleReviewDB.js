var moduleReviewData = [
{
	moduleCode:"CS2102",
	moduleReview:["Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102, Just some randome review for CS2102.",
								"Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102, Some random review for CS2102.",
								"Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102, Random review for CS2102."]
},

{
	moduleCode:"CS2020",
	moduleReview:["Just some randome review for CS2020",
								"Some random review for CS2020",
								"Random review for CS2020"]
},

{
	moduleCode:"MA3238",
	moduleReview:["Just some randome review for MA3238",
								"Some random review for MA3238",
								"Random review for MA3238"]
},

{
	moduleCode:"MA1100",
	moduleReview:["Just some randome review for MA1100",
								"Some random review for MA1100",
								"Random review for MA1100"]
}];


var ReviewDB = Backbone.Collection.extend({});

var moduleReviewDB = new ReviewDB({});
moduleReviewDB.reset(moduleReviewData);