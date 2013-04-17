var rankingModule = (function(){
	var divRanking, resourceId,resoruceAvg,urlCalification
	compliteImg = "completeImg.png",
	haveImg ="haveImg.png";

	var init = function(config){
		urlCalification = config.url;
		divRanking = config.divR;
		resourceId = config.resourceId;
		resourceAvg = config.resourceAvg;
		initPlugin();
	},initPlugin = function(){
		divRanking.raty({
			score:resourceAvg,
			click:calificate,
			hints: ['Malo', 'Pobre', 'Aceptable', 'Suficiente', 'Muy completo'],
			path:'../public/img',
			cancel:false
		});
	},calificate = function(score, evt){
		
		saveCalification();		

	},saveCalification = function(){		
		var data = {
			resourceId : resourceId,
			scoreResource : divRanking.raty('score'),
			userId : 2
		}		
		$.ajax({
			url : urlCalification,
			data :data,
			type:'post',
			success:successCalificaction,
			error: failureCalificaction
		});
	},successCalificaction = function(){
		divRanking.raty('readOnly', true);
		alert("Gracias por la calificacion");
	}, failureCalificaction = function(){
		alert("No pudimos guardar su calificacion agradecemos su intención, intentelo nuevamente");
	};

	return {
		init:init,
		saveCalification:saveCalification
	}
})();


console.log("ranking");
rankingModule.init({
	url:"ranking/saveCalification",
	divR:$("#star"),
	resourceId:3,
	resourceAvg:3.6
});
