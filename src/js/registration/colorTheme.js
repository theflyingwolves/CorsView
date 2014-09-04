function RandomColorGenerator(){
	return {
	colorLibrary: [
		["#D0FFAA","#E8D1A0","#FF8785","#A387E8","#9AFEFF"],
		["#C59EFF","#B7E89B","#FF8785","#87E8E2","#FFDA9A"],
		["#EFFFA3","#E8D0AE","#FF7BA2","#7565E8","#80FFF2"]
	],

	colorArray: undefined,

	init: function(){
		var length = this.colorLibrary.length;
		var libIndex = Math.floor(Math.random()*length);
		this.colorArray = this.colorLibrary[libIndex];
	},

	generate: function(){
		if(this.colorArray == undefined){
			console.log("Generator Undefined Yet!")
			return "";
		}else{
			var len = this.colorArray.length;
			var index = Math.floor(Math.random()*len);
			return this.colorArray[index];
		}
	}
	};
}

