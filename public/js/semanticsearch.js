

var App = {}

App.models = {};
App.views = {};
App.collections = {};

App.models.recurso = Backbone.Model.extend({
});

App.collections.recursos = Backbone.Collection.extend({
	model : App.models.recurso,
	parse: function(data){
		return this.items;
	}
});

App.views.recursoView = Backbone.View.extend({
	model : App.models.recurso,
	template : Handlebars.compile($('#resourceTemplate').html()),
	tagName: 'div',
	className :'recurso',
	initialize : function(){
		this.render();
	},
	render: function(){
		var html = this.template(this.model.toJSON());
		this.$el.html(html);
		return this;
	}	
}) ;


App.views.recursosView = Backbone.View.extend({
	el: '#containerRes',
	initialize: function(){
		this.collection.on('reset' , this.render, this);
	},
	render: function(){		
		this.$el.empty();
		this.collection.each( function(result, el){
			var vista = new App.views.recursoView({model:result});
			this.$el.append(vista.$el);
		}, this);
	}		
}) ;


App.views.formView = Backbone.View.extend({	
	el:"#form_buscador",
	searchBox : $('#term'),
	events:{
		'submit' : 'newSearch'
	},
	initialize:function(){
		this.results = new App.collections.recursos();
		this.recursosView = new App.views.recursosView({collection:this.results});
	},
	newSearch : function(e, ev){
		e.preventDefault();
		var that = this;
		$('#containerRes').circleLoading();
		this.search(this.searchBox.val()).done(function(data){
			that.results.reset(data.items);
		});
	},
	search: function(searchQuery){
		searchQuery = encodeURIComponent(searchQuery);
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&start=1&rows=100&profile=standard',
			dataType: "jsonp",
		});
	}
});

App.views.Node = Backbone.View.extend({
	events:{
		'click':'dataNode'
	},
	initialize :  function(){
		this.results = new App.collections.recursos();
		this.recursosView = new App.views.recursosView({collection:this.results});
	},
	dataNode : function (){				
		$('#containerRes').circleLoading();
		console
		var that = this;
		this.search($(this.el).text()).done(function(data){
			that.results.reset(data.items);
		});
	},
	search: function(searchQuery){
		var searchQuery = encodeURIComponent(searchQuery);
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&start=1&rows=100&profile=standard',
			dataType: "jsonp",
		});
	}
});

var semanticModule =(function(){
	var searchTerms  = function(searchQuery){
		searchQuery = encodeURIComponent(searchQuery);
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&start=1&rows=100&profile=standard',
			dataType: "jsonp",
		});
	};
	return {
		search : searchTerms
	}
})();

(function(){
	// $('#form_buscador').on('submit' , function(e){
	// 	e.preventDefault();
	// 	var search = $('#term').val();
	// 	semanticModule.search(encodeURIComponent(search)).done(function(data){console.log(data)});
	// });
	new App.views.formView();	
})();