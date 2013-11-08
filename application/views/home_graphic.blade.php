@layout('master')

@section('searchbar')
	<form action="{{url('resource/getPies')}}" class="grid_4 push_5" id="form_buscador" method="POST">
		<button type ='submit' class="ico"></button>
		<input type="text" class="inputField" required  name="term">
	</form>
@endsection


@section('Content')
<div id="hoverNodes"></div>
<section id="visualArea">
	<div class="container_12">
		<div id="tabs" class="grid_12">
			<ul>
				<li id ="arbolLink">
					<a href="#arbol">Radial graph</a>
				</li>
				<li id="hyperLink">
					<a href="#hyperArbol">Hypertree</a>
				</li>	
				<li id="spaceLink">
					<a href="#space">Space tree</a>
				</li>
			</ul>
			<div id="arbol"class="grid_12 vis"></div>
			<div id="hyperArbol" class="grid_12 vis"></div>
			<div id="space" class="grid_12 vis "></div>
		</div>							
		
			<div class="piesContainer">
			@include('handlebarsTemplate')				
				<div class="pieHolder grid_6 clearfix ">
					<div class="pie" id="Language"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix ">
					<div class="pie" id="Country"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix">
					<div class="pie" id="Type"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix">
					<div class="pie" id="Provider"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix">
					<div class="pie" id="Rights"></div>
					<div class="pieContent">
												
					</div>
				</div>
			</div>
	</div>
</section><!-- Fin de la seccion visual -->
<div class="separator"></div>

<section id="contentPanel">
	<div class="container_12">
		<div class="panelBajo grid_6"></div>
		<div class="panelBajo grid_3"></div>
		<div class="panelBajo grid_3" id="titulo"></div>
	</div>
	<div id="dialogo" title="Mensaje importante !!" style="display: none;"></div>
	<div id="contentResource">
		<span id="numOfResources"></span>
		<span class="closeTag">X</span>
	    <ul id="listResource">
	    	
	    </ul>
	    <span id="prev">prev</span>
	    <span id="next">next</span>
	    @include('handlebarsResource')

	</div>
</section>

<!-- Fin del panel contenido-->	
@endsection

@section('mainScripts')
	{{ HTML::script('js/jquery-ui/js/jquery-ui.js')}}
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