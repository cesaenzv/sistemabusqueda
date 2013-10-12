var App = {}
var semanticaF;
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
});

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
		this.$el.css('cursor',"pointer !important");
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
		$(this.el).css('cursor',"progress !important");		
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
	template:Handlebars.compile($("#semanticFinder").html()),
	term:'',
	viewState:false,
	events:{
		'click button':'semanticConsult',
		'click a.btnView':'manageView',
		'select select#facets': 'addFacetOptions',
		'select #term':'resetView'
	},
	initialize:function(){
		this.results = new App.collections.recursos();
		this.recursosView = new App.views.recursosView({collection:this.results});
		this.listenTo(Backbone, 'semanticTerm', this.chargueSearchView);
	},
	render:function(){
		this.$el.empty();
		var html = this.template(this.data);
		this.$el.html(html);
		if(this.viewState == false)
			this.manageView();		
	},
	resetView:function(){
		this.term = this.$el.find('#term').val();
		this.data = {term:this.term};
		this.render();
	},
	chargueSearchView:function(data){
		this.term = data.searchQuery;		
		this.data = {term:this.term};		
		this.$el.find('#term').val(this.term);
		this.render();
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
			that.results.reset(data.items);
			var idSelected = that.data.idSelected;
			if(that.data.facetData != undefined && that.data.facetData != null)
				var facetData = that.data.facetData
			that.data = {facetData:facetData,facets:data.facets, idSelected : that.data.idSelected,term:that.term, totalResults:data.totalResults};
			if(that.viewState == true)
				that.data.viewState = that.viewState;
			that.render();
		});
	},
	addFacetOptions: function(){	
		if(this.data.facets == undefined || this.data.facets == null)
			return false;		
		this.data.idSelected = this.$el.find("select#facets").val();
		this.data.facetData = this.data.facets[this.data.idSelected].fields; 
		this.render();
	},
	search: function(){
		var searchQuery = encodeURIComponent(this.term);
		var facet ="";
		if(this.$el.find("select#facets")>-1 && this.$el.find("select#facets") != undefined ){
			facet+='&qf='+this.$el.find("select#facets option:selected").html();
			if(this.$el.find("select#facetData").val()!= -1){
				facet += ':'+encodeURIComponent(this.$el.find("select#facetData").val());
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
	new App.views.SemanticFinder();
})();