
	

	var resourceModule = (function(){

		var listR,		
		contentR = $('#contentResource'),
		popUp, plantillaResource, urlGetResource, template, currentIndex,
		prevBtn = $('#prev'), nextBtn = $('#next'),
		nodeCache, idTermCache, idColumnaCache, resources;

		init = function(config){
			listR = $('#listResource') ;
			plantillaResource = config.plantilla;
			urlGetResource = config.url;
			template = Handlebars.compile(plantillaResource);
			bindEvents();
		},
		loadResource = function(node,idTermino,idColumna, resultIndex){
			nodeCache = node;
			idTermCache = idTermino;
			idColumnaCache = idColumna;
			currentIndex = resultIndex;
			ajaxRequest = $.ajax({
				url:urlGetResource,
				data:{criterio:node.name,group:node.label,idTerm:idTermino,idColumn:idColumna,numConsult:resultIndex},
				type:'post',
				dataType:'json'
			}).done(function(data){
				console.log(data.resources);
				 setResources(data.resources,function(){
				 	activePopup();				 	
				 	contentR.addClass('contentVisible');

				 	if(data.resources.length < 200){
				 		nextBtn.fadeOut();
				 		console.log(data.resources.length);
				 	}else{
				 		nextBtn.fadeIn();
				 	}

				 	if(currentIndex <= 0){
				 		prevBtn.fadeOut();
				 	}else {
				 		prevBtn.fadeIn();
				 	}	
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
			listR.html(contenido);
			activeRankings(items);
			popUp = $('#popUp');						
			callback();
		},
		activeRankings = function(resources){
			$.each(resources,function(index, resource){
				rankingModule.init({
					divR:$("#"+resource.id_metadata_mandatory),
					resourceId:resource.id_metadata_mandatory,
					resourceAvg:resource.ranking
				});
			});		
		},

		setCurrentIndex = function(index){
			currentIndex = index;
		},
		getCurrentIndex = function(index){
			return currentIndex;
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

			prevNextResource();			
		},
		prevNextResource = function(){

			nextBtn.on('click' , function(){
				$('.swControls').remove();
				loadResource(nodeCache, idTermCache, idColumnaCache, ++currentIndex);


			});

			prevBtn.on('click' , function(){
				
				if(!currentIndex <= 0){
					$('.swControls').remove();
					loadResource(nodeCache, idTermCache, idColumnaCache, --currentIndex);
				}
			});

		};
		return {
			init:init,
			loadResource:loadResource,
			setCurrentIndex:setCurrentIndex,
			getCurrentIndex:getCurrentIndex
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






