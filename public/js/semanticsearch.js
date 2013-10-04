

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
		$("#semanticResult").dialog("open");
	}		
}) ;


/*App.views.formView = Backbone.View.extend({	
	el:"#form_buscador",
	searchBox : $('#term'),
	events:{
		'submit' : 'newSearch'
	},
	initialize:function(){
		this.results = new App.collections.recursos();
		this.recursosView = new App.views.recursosView({collection:this.results});
		this.tipoRecurso = this.$el.find("#facet");
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
			//url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&qf='+this.tipoRecurso.val()+'&start=1&rows=100&profile=standard',
			dataType: "jsonp",
		});
	}
});*/


App.views.Node = Backbone.View.extend({
	hoverNode :("#hoverNodes"),
	ajaxCall : null,
	events:{
		'click':'dataNode',
		'mouseenter':'showNumResources',
		'mouseleave':'hideNumResources'
	},
	dataNode : function (){			
		$('#containerRes').circleLoading();
		Backbone.trigger('semanticTerm',{searchQuery:$(this.el).text()});
	},
	hideNumResources: function(){
		$("#hoverNodes").css('display','none');
		if(this.ajaxCall !== null){
			this.ajaxCall.abort();
			this.ajaxCall =  null;						
		}	
	},
	showNumResources : function(evt){		
		if(this.ajaxCall !== null)
			return false;
		this.ajaxCall = this.search();
		this.ajaxCall.done(function(data){
			$("#hoverNodes").css('top',evt.pageY);
			$("#hoverNodes").css('left',evt.pageX+15);		
			$("#hoverNodes").css('display','block');	
			$("#hoverNodes").html(data.totalResults);		
		});
	},
	search :function(){
		var searchQuery = encodeURIComponent($(this.el).text());
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery,
			dataType: "jsonp",
			error: function(jqXHR,status,error){
        		if (status != "abort") {
                    get_data_from_server();  // Try request again.
                }
    		},
			async:false
		});
	}
});

App.views.SemanticFinder = Backbone.View.extend({
	el:'#semanticContent',
	buttonControl: '#btnView',
	term:'',
	viewState:false,
	events:{
		'click button':'semanticConsult',
		'click a.btnView':'manageView',
		'change select#facet': 'appendFacetsOptions',
		'change #term':'resetView'
	},
	initialize:function(){
		this.selectFacet = this.$el.find("select#facet");
		this.facetOptions = this.$el.find("select#facetOptions");
		this.totalRecords = this.$el.find("span#totalRecords");
		this.results = new App.collections.recursos();
		this.recursosView = new App.views.recursosView({collection:this.results});
		this.listenTo(Backbone, 'semanticTerm', this.chargueSearchView);
		this.resetView();
	},
	resetView:function(){
		this.selectFacet.html('').append($('<option value="-1">Todos</option>')).parent('label').css('display','none');
		this.facetOptions.html('').append($('<option value="-1">Todos</option>')).parent('label').css('display','none');
		this.totalRecords.text('').parent('label').css('display','none');
	},
	chargueSearchView:function(data){
		this.resetView();
		this.term = data.searchQuery;		
		this.$el.find('#term').val(this.term);
		if(this.viewState == false)
			this.manageView();		
	},
	semanticConsult : function(e){
		e.preventDefault();		
		if(this.$el.find('#term').val() != this.term)
			this.term = this.$el.find('#term').val();		
		var that = this;
		$('#containerRes').circleLoading();		
		this.search().done(function(data){
			that.totalRecords.text(data.totalResults).parent('label').css('display','block');
			that.appendFacets(data.facets);
			that.results.reset(data.items);
		});
	},
	appendFacets: function(facets){
		this.facets = facets;		
		this.selectFacet.parent('label').css('display','block');		
		for(var i=0; i<facets.length; i++)
			$('<option value="'+i+'"">'+facets[i].name+'</option>').appendTo(this.selectFacet);		
	},
	appendFacetsOptions: function(){
		if(this.facets == undefined || this.facets == null)
			return false;		
		var selectedId = this.selectFacet.val();
		if(selectedId > -1){
			this.facetOptions.parent('label').css('display','block');
			var facet = this.facets[selectedId];						
			for(var i=0; i<facet.fields.length; i++)
				$('<option value="'+facet.fields[i].label+'"">'+facet.fields[i].label+'</option>').appendTo(this.facetOptions);	
		}
	},
	search: function(){
		var searchQuery = encodeURIComponent(this.term);
		var facet ="";
		if(this.selectFacet.val()>-1 && this.selectFacet.val() != undefined ){
			facet+='&qf='+this.selectFacet.find('option:selected').html();
			if(this.facetOptions.val()!= -1){
				facet += ':'+encodeURIComponent(this.facetOptions.val());
			}
		}		
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&start=1&rows=100&profile=facets'+facet,
			dataType: "jsonp",
		});	
	},
	manageView:function(){
		this.$el.removeClass(this.viewState==true?'show-semantic':'hide-semantic')
			.addClass(this.viewState==true?'hide-semantic':'show-semantic');
		this.$el.attr('style','');
		this.$el.find("a#openSearcher").css('display',this.viewState==true?'inline-block':'none');
		this.$el.find("a#closeSearcher").css('display',this.viewState==true?'none':'inline-block');		
		this.viewState = !this.viewState;
	}
});

var semanticModule =(function(){
	var searchTerms  = function(searchQuery){
		searchQuery = encodeURIComponent(searchQuery);		
		return $.ajax({
			url:'http://europeana.eu/api//v2/search.json?wskey=PQuiDaucA&query='+searchQuery+'&start=1&rows=100&profile=facets',
			dataType: "jsonp",
		});
	};
	return {
		search : searchTerms
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
	//new App.views.formView();	
	new App.views.SemanticFinder();
})();