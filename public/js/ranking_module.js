var rankingModule = (function(){
	urlCalification = "index.php/ranking/saveCalification",
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
<<<<<<< HEAD
	},calificate = function(score, evt){		
		saveCalification();		
	},saveCalification = function(){		
		var data = {
			resourceId : resourceId,
			scoreResource : divRanking.raty('score'),
=======
	},calificate = function(){
		saveCalification($(this));
	},saveCalification = function(divR){
		var dataR = {
			resourceId : divR.attr("data-resId"),
			scoreResource : divR.raty('score'),
>>>>>>> d217854ce13c9ffb07226c0121f3b9c37975e709
			userId : 2
		}
		$.ajax({
			url : urlCalification,
			data :dataR,
			type:'post'
		}).done(function(result){
			console.log(result);
			if (result.msj){
				console.log(result.msj);
				divR.raty('readOnly', true);
				alert("Gracias por la calificacion");
			}else{
				console.log(result.msj);
				alert("No pudimos guardar su calificacion agradecemos su intención, intentelo nuevamente");
			}
		});
	};
	return {
		init:init,
	}
})();


console.log("ranking");
rankingModule.init({
	divR:$("#star"),
	resourceId:1,
	resourceAvg:3.6
<<<<<<< HEAD
});
=======
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
>>>>>>> d217854ce13c9ffb07226c0121f3b9c37975e709
