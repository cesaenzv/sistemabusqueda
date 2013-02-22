$(document).ready(function($){
	var buttonCreate, formUser,
	urlGetFields, plantillaForms;
	var formModule = (function(){
		var init = function(config){
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
		},
		loadForm = function(){
			ajaxRequest = $.ajax({
				url:urlGetFields,
				type:'post',
				dataType:'json'
			}).done(function(data){
				configForm(data);
			});
		};
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
});