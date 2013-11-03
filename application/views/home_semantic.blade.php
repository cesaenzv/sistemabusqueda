@layout('master')



@section('Content')
 <style type="text/css">
	path.arc {
	  cursor: move;
	  fill: #fff;
	}

	.node circle {
	  cursor: pointer;
	  fill: #fff;
	  stroke: steelblue;
	  stroke-width: 1.5px;
	}

	.node text {
	  font-size: 11px;
	}

	path.link {
	  fill: none;
	  stroke: #ccc;
	  stroke-width: 1.5px;
	}


	.node rect {
	  cursor: pointer;
	  fill: #fff;
	  fill-opacity: .5;
	  stroke: #3182bd;
	  stroke-width: 1.5px;
	}

	.node text {
	  font: 10px sans-serif;
	  pointer-events: none;
	}

	path.link {
	  fill: none;
	  stroke: #9ecae1;
	  stroke-width: 1.5px;
	}
</style>

<div id="hoverNodes"></div>

@section('searchbar')
	<section id="semanticContent" class="hide-semantic" style="display:none;">

	</section>			
@endsection

<section id="visualArea">
	<div class="container_12">
		<div id="tabs" class="grid_12">
			<ul>
				<li id ="arbolLayoutLink">
					<a id="arbolLayoutBtn" href="#arbolLayout">Layout tree</a>
				</li>				
				<li id="partitionLink">
					<a id="partitionBtn" href="#partition">Partition</a>
				</li>
				<li id="circlesLink">
					<a id="circlesBtn" href="#circles">Circles</a>
				</li>
			</ul>
			<div id="arbolLayout" class="grid_12 vis white"></div>
			<div id="partition" class="grid_12 vis white"></div>
			<div id="circles" class="grid_12 vis white"></div>
		</div>							
	</div>
</section><!-- Fin de la seccion visual -->
<div class="separator"></div>

<section id="semanticResult">
	<div class="container_12">
		<h1 class="semanticMain">Busqueda semantica</h1>					
		
		<br>
		
		<div class="grid_12">
			<div class="resultados">
				<h3>resultados de la busqueda</h3>

				<div id="containerRes" class="clearfix">
				</div>
			</div>
		</div>
	@include('semantichandlebars')
	</div>
</section><!-- Fin de la seccion visual -->

<!-- Fin del panel contenido-->	
@endsection

@section('mainScripts')
	{{ HTML::script('js/jquery-ui/js/jquery-ui.js')}}

	<script type="text/javascript">
		$('#tabs').tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" ).find('li').removeClass( "ui-corner-top" )
                          .end()
                          .children('ul')
                          .removeClass('ui-corner-all')
                          .removeClass('ui-widget-header');
	</script>
	
    {{ HTML::script('js/data.js')}}
	{{ HTML::script('js/jit.js')}}
	{{ HTML::script('js/jquery.mCustomScrollbar.js')}}
	{{ HTML::script('js/jquery.mousewheel.min.js')}}
	{{ HTML::script('js/jquery.raty.js')}}	
	{{ HTML::script('js/handlebars.js')}}
	{{ HTML::script('js/underscore.js')}}
	{{ HTML::script('js/backbone.js')}}
	<script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://mbostock.github.io/d3/talk/20111018/d3/d3.layout.js"></script>
	{{ HTML::script('js/CustomModuls/resource_module.js')}}
	{{ HTML::script('js/CustomModuls/ranking_module.js')}} 
	{{ HTML::script('js/pagginJquery.js')}}	
	{{ HTML::script('js/initScript.js')}}


	{{ HTML::script('js/circleloading.js')}}
	{{ HTML::script('js/semanticsearch.js')}}
	{{ HTML::script('js/layoutTree.js')}}
	{{ HTML::script('js/circles.js')}}
	{{ HTML::script('js/partition.js')}}	

@endsection