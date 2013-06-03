
	
	var formModule = (function(){
		var buttonCreate, formUser,
		urlGetFields, plantillaForms,
		init = function(config){
			buttonCreate = config.buttonForm;
			urlGetFields = config.url;
			plantillaForms=config.plantilla;
			formUser = config.contentF;	
			bindEvents();
		},
		bindEvents = function(){
			buttonCreate.on('click',loadForm);

		},
		configForm =function(formsUser){
			var template = Handlebars.compile(plantillaForms);
			var contenido = template({formM:formsUser});
			console.log(formUser);
			formUser.append(contenido);
			//slideForm();			
		},
		loadForm = function(){
			$(this).remove();
			var valorMetadata = $('#europeana_term').remove().val();
			
			
			ajaxRequest = $.ajax({
				url:urlGetFields,
				type:'post',
				dataType:'json'
			}).done(function(data){
				console.log(data);
				configForm(data);
				$("#id_europeana_term").val(valorMetadata);
			});
		}	
		return{
			init:init
		}
	})();

	formModule.init({
		plantilla:$('script#formTemplate').html(),
		contentF:$('#wrapper'),
		buttonForm:$('#callFormButton'),
		url:"index.php/formc/getFormFields"
	});



	
	

