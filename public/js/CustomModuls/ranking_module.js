var rankingModule = (function(){
	var urlCalification = "index.php/ranking/saveCalification";
	

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
			click:calificate,
			cancel:false
		});
	},calificate = function(score, evt){		
		saveCalification(this);		
	},saveCalification = function(div){		
		var data = {
			resourceId : $(div).attr("data-resId"),
			scoreResource : $(div).raty('score')
		}
		$.ajax({
			url : urlCalification,
			data :data,
			type:'post'
		}).done(function(result){
			if (result.msj === "Exito"){
				$(div).raty('readOnly', true);
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



