$(document).ready(function($){
	var listR = $('#listResource');		
	var contentR = $('#contentResource');
	var resourceModule = (function(){
		var loadResource = function(node,idTermino){			
			ajaxRequest = $.ajax({
				url:"index.php/resource/getResource",
				data:{criterio:node.name,group:node.label,idTerm:idTermino},
				type:'post',
				dataType:'json'
			}).done(function(data){											    
				data.resources.forEach(function(item){
					addResource(item);					
				});
				listR.sweetPages({
					perPage:10
				});
				var controls =  $('.swControls').detach();
				controls.appendTo(contentR);
				contentR.show();				
			}); 
		};

		var addResource = function(item){
			listR.append("<li><div><h4>"+item.title+"</h4></div></li>");			
		};

		return {
			loadResource:loadResource
		}
	})();
	//Node -> Nodo del pie que se selecciona
	var node = {
		name:'EuroLanguage',
		label:'en'
	};	
	loadResource(node,1);	
});




