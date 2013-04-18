var rankingModule = (function(){
	urlCalification = "ranking/saveCalification",
	compliteImg = "completeImg.png",
	haveImg ="haveImg.png";

	var init = function(config){		
		var divRanking = config.divR;
		divRanking.attr("data-resId",config.resourceId);
		divRanking.attr("data-resAvg",config.resourceAvg);
		initPlugin(divRanking);
	},initPlugin = function(divRanking){
		$(divRanking).raty({
			score:divRanking.attr("data-resAvg"),
			click:calificate,
			hints: ['Malo', 'Pobre', 'Aceptable', 'Suficiente', 'Muy completo'],
			path:'../public/img',
			cancel:false
		});
	},calificate = function(){
		saveCalification($(this));
	},saveCalification = function(divR){
		var data = {
			resourceId : divR.attr("data-resId"),
			scoreResource : divR.raty('score'),
			userId : 2
		}
		console.log(divR);
		console.log(data);
		$.ajax({
			url : urlCalification,
			data :data,
			type:'post',
			success:successCalificaction(divR),
			error: failureCalificaction
		});
	},successCalificaction = function(divR){
		divR.raty('readOnly', true);
		alert("Gracias por la calificacion");
	}, failureCalificaction = function(){
		alert("No pudimos guardar su calificacion agradecemos su intención, intentelo nuevamente");
	},getDivData = function(div){
		return {
			resourceId : resourceId,
			scoreResource : divRanking.raty('score'),
			userId : 2
		}
	};

	return {
		init:init,
		saveCalification:saveCalification
	}
})();


console.log("ranking");
rankingModule.init({
	divR:$("#star"),
	resourceId:1,
	resourceAvg:3.6
});
rankingModule.init({
	divR:$("#star1"),
	resourceId:2,
	resourceAvg:2
});
rankingModule.init({
	divR:$("#star2"),
	resourceId:3,
	resourceAvg:4.2
});
rankingModule.init({
	divR:$("#star3"),
	resourceId:4,
	resourceAvg:3.8
});
