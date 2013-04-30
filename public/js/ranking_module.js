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
			data :dataR,
			type:'post'
		}).done(function(result){
			if (result.msj){
				divR.raty('readOnly', true);
				alert("Gracias por la calificacion");
			}else{
				alert("No pudimos guardar su calificacion agradecemos su intención, intentelo nuevamente");
			}
		});
	};
	return {
		init:init,
	}
})();



