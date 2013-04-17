@layout('master')
@section('Content')
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
			<div id="arbol"class="vis"></div>
			<div id="hyperArbol" class="vis"></div>
			<div id="space" class="vis"></div>
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
		<span class="closeTag">X</span>
	    <ul id="listResource">
	    	
	    </ul>
	    @include('handlebarsResource')
	</div>
</section><!-- Fin del panel contenido-->	
@endsection

@section('mainScripts')
	{{ HTML::script('js/jit.js')}}
	{{ HTML::script('js/jquery-ui/js/jquery-ui.js')}}
	{{ HTML::script('js/jquery.mCustomScrollbar.js')}}
	{{ HTML::script('js/jquery.mousewheel.min.js')}}
	{{ HTML::script('js/jquery.raty.js')}}	
	{{ HTML::script('js/handlebars.js')}}
	{{ HTML::script('js/data.js')}}
	{{ HTML::script('js/resourceJS.js')}}
	{{ HTML::script('js/ranking_module.js')}} 
	{{ HTML::script('js/pagginJquery.js')}}	
	{{ HTML::script('js/initScript.js')}}	
@endsection