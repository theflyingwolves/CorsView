var moduleReviewData = [
{
	moduleCode:"CS2102",
	moduleReview:["Just some randome review for CS2102","Some random review for CS2102","Random review for CS2102"]
},

{
	moduleCode:"CS2020",
	moduleReview:["Just some randome review for CS2020","Some random review for CS2020","Random review for CS2020"]
},

{
	moduleCode:"MA3238",
	moduleReview:["Just some randome review for MA3238","Some random review for MA3238","Random review for MA3238"]
},

{
	moduleCode:"MA1010",
	moduleReview:["Just some randome review for MA1010","Some random review for MA1010","Random review for MA1010"]
}];

var ReviewDB = Backbone.Collection.extend({});

var moduleReviewDB = new ReviewDB({});
moduleReviewDB.reset(moduleReviewData);