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
				<li>
					<a href="#icicle">vis2</a>
				</li>
			</ul>
			<div id="arbol"class="vis"></div>
			<div id="hyperArbol" class="vis"></div>
			<div id="icicle" class="vis"></div>
		</div>							
		
			<div class="piesContainer">
			@include('handlebarsTemplate')				
				<div class="pieHolder grid_6 clearfix ">
					<div class="pie" id="EuroLanguage"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix ">
					<div class="pie" id="Country"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix">
					<div class="pie" id="EuroType"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix">
					<div class="pie" id="Provider"></div>
					<div class="pieContent">
						
					</div>
				</div>
				<div class="pieHolder grid_6 clearfix">
					<div class="pie" id="EuroRights"></div>
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
</section><!-- Fin del panel contenido-->	
@endsection