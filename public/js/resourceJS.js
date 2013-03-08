
	

	var resourceModule = (function(){

		var listR = $('#listResource'),		
		contentR = $('#contentResource'),
		popUp, plantillaResource, urlGetResource, template

		init = function(config){
			plantillaResource = config.plantilla;
			urlGetResource = config.url;
			template = Handlebars.compile(plantillaResource);
			bindEvents();
		},
		loadResource = function(node,idTermino,idColumna){
					
			ajaxRequest = $.ajax({
				url:urlGetResource,
				data:{criterio:node.name,group:node.label,idTerm:idTermino,idColumn:idColumna},
				type:'post',
				dataType:'json'
			}).done(function(data){
				console.log(data);
				setResources(data.resources,function(){					
					activePopup();
					contentR.addClass('contentVisible');
				});
				listR.sweetPages({
					perPage:6
				});
				var controls =  $('.swControls').detach();
				controls.appendTo(contentR);
				contentR.show();				
			}); 
		},

		setResources = function(items,callback){						
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
			popUp.dialog("option","minWidth",750);
			popUp.dialog("option","maxWidth",750);
			popUp.dialog("option","minHeight",300);
			popUp.dialog("option","maxHeight",500);
		},
		loadPopUp = function (dataBox){
			var content = dataBox.find('div.data').html(),
			title = dataBox.find('h4.resourceTitle').text();
			popUp.empty();					
			popUp.append(content);
			popUp.dialog('option','title',title);
			popUp.dialog("open");
		},
		bindEvents= function(){
		$('.closeTag').on('click',function(){
			$(this).parent().removeClass('contentVisible');
			listR.empty();
			$('.swControls').remove();
		})				
			listR.on('click', 'div.resourceBox button',function(){
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

	// var node = {
	// 	name:'EuroLanguage',
	// 	label:'en'
	// };
	
	// resourceModule.init({
	// 	plantilla:$('script#resourceTemplate').html(),
	// 	url:"index.php/resource/getResource",
	// });

	// resourceModule.loadResource(node,1);	






