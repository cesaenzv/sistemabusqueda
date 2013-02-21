$(document).ready(function($){
	var formDiv, buttonCreate;

	var formModule = (function(){
		var init = function(config){
			formDiv = config.formDiv;
			buttonCreate = config.buttonForm;
			configForm();			
			bindEvents();
		},
		bindEvents = function(){
			buttonCreate.onclick(loadForm)
		},
		configForm =function(){

		},
		loadForm = function(){

		};
		return{
			init:init;
		}
	})();

	formModule.init({
		formDiv:$('#steps'),
		buttonForm = $('#callFormButton');
	});
});