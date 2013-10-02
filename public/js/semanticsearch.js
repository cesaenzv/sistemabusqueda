

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
	initialize :  function(config){			
		this.destroy = config.destroy;
		this.results = new App.collections.recursos();
		this.recursosView = new App.views.recursosView({collection:this.results});
	},
	dataNode : function (){			
		$('#containerRes').circleLoading();
		Backbone.trigger('semanticTerm',{searchQuery:$(this.el).text()});
	}
});

App.views.SemanticFinder = Backbone.View.extend({
	el:'#semanticContent',
	buttonControl: '#btnView',
	term:'',
	viewState:false,
	events:{
		'submit':'semanticConsult',
		'click a#openSearcher':'openView',
		'click a#closeSearcher':'closeView',		
	},
	initialize:function(){
		this.listenTo(Backbone, 'semanticTerm', this.chargueSearchView);
	},
	chargueSearchView:function(data){
		this.term = data.searchQuery;
		console.log("chargueSearchView -> "+this.term);
		this.$el.find('#term').val(this.term);
		this.openView();		
	},
	semanticConsult : function(){

	},
	openView:function(){
		console.log("open");	
		if(this.viewState == false){
			this.$el.removeClass('hide-semantic').addClass('show-semantic');
			this.$el.attr('style','');
			this.$el.find("a#openSearcher").css('display','none');
			this.$el.find("a#closeSearcher").css('display','inline-block');
		}
		this.viewState = true;
	},
	closeView:function(){
		console.log("close");			
		if(this.viewState == true){
			this.$el.removeClass('show-semantic').addClass('hide-semantic');
			this.$el.attr('style','');
			this.$el.find("a#openSearcher").css('display','inline-block');
			this.$el.find("a#closeSearcher").css('display','none');		
		}
		this.viewState = false;
	}
});

var semanticModule =(function(){
	var searchTerms  = function(searchQuery){
		searchQuery = encodeURIComponent(searchQuery);
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&start=1&rows=100&profile=standard',
			dataType: "jsonp",
		});
	}/*,
	activeBackbone = function(div, array){
		if(array == null || array == undefined){
			array = new Array();
		}
	  	$(div).find('g.node').each(function(){
		    var flag = true;    
		    for(var i=0; i<array.length;i++){
		      	if(array[i] === this){
		        	flag = false;
		      	}		
		    }
		    if(flag === true){
		      	array.push(this);
		      	new App.views.Node({el:this});
		    }
	 	});
	  	return array;
	}*/;
	return {
		search : searchTerms,
		//activeBackbone:activeBackbone
	}
})();

(function(){
	$("#semanticResult").dialog({autoOpen:false,
		show:{
			effect: "blind",
			duration: 100
		},
		hide:{
			effect: "blind",
			duration: 100
		}
	});
	$("#semanticResult").dialog("option","width",1100);
	$("#semanticResult").dialog("option","height",800);
	new App.views.formView();	
	new App.views.SemanticFinder();
})();