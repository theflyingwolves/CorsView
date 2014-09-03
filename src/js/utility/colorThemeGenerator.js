function RandomColorGenerator(){
	return {
	colorLibrary: [
		["#be505a","#5b8e99","#32847c","#be7672","#3c64a0","#a0643c"]
	],

	colorArray: undefined,

	prevIndex:undefined,

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
			while(this.prevIndex == index){
				index = Math.floor(Math.random()*len);
			}
			this.prevIndex = index;
			return this.colorArray[index];
		}
	}
	};
}