$(document).ready(function($){
	var listR = $('#listResource'),		
	contentR = $('#contentResource'),
	popUp, plantillaResource, urlGetResource;

	var resourceModule = (function(){
		var init = function(config){
			plantillaResource = config.plantilla;
			urlGetResource = config.url;
		},
		loadResource = function(node,idTermino){			
			ajaxRequest = $.ajax({
				url:urlGetResource,
				data:{criterio:node.name,group:node.label,idTerm:idTermino},
				type:'post',
				dataType:'json'
			}).done(function(data){														    				
				setResources(data.resources,function(){					
					activePopup();
					bindEvents();
				});
				listR.sweetPages({
					perPage:5
				});
				var controls =  $('.swControls').detach();
				controls.appendTo(contentR);
				contentR.show();				
			}); 
		},
		setResources = function(items,callback){						
			var template = Handlebars.compile(plantillaResource);
			var contenido = template({resources:items});
			listR.append(contenido);
			popUp = $('#popUp');
			callback();
		},
		activePopup = function(){
			popUp.dialog({
				autoOpen:false,
				show:{
					effect: "blind",
        			duration: 100
				},
				hide:{
					effect: "blind",
        			duration: 100
				}
			});
			popUp.dialog("option","minWidth",550);
			popUp.dialog("option","maxWidth",560);
			popUp.dialog("option","minHeight",300);
			popUp.dialog("option","maxHeight",310);
		},
		loadPopUp = function (dataBox){
			var content = dataBox.find('div.data').html(),
			title = dataBox.find('legend').text();
			popUp.empty();					
			popUp.append(content);
			popUp.dialog('option','title',title);
			popUp.dialog("open");
		},
		bindEvents= function(){				
			$('.resourceBox fieldset button').on('click',function(){
				var dataBox = $(this).closest('div.resourceBox');
				loadPopUp(dataBox);					
			});			
		};
		return {
			init:init,
			loadResource:loadResource
		}
	})();

	//Node -> Nodo del pie que se selecciona
	var node = {
		name:'EuroLanguage',
		label:'en'
	};
	
	resourceModule.init({
		plantilla:$('script#resourceTemplate').html(),
		url:"index.php/resource/getResource",
	});

	resourceModule.loadResource(node,1);	
});




