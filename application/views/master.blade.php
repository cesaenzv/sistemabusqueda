<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">	
	{{ HTML::style('css/styles.css')}}
	{{ HTML::style('css/style_pagging.css')}}
	{{ HTML::style('css/styleForm.css')}}

	<title>Sistema integrado de búsqueda</title>
</head>
	<body>
		<div class="searchTag">Arriba!!!</div>
		<header>
			<div class="container_12">
				<h1 class="logo grid_3">
					Sistema <br>
					Integrado <br>
					de búsqueda</h1>

			@section('searchbar')

				<form action="{{url('resource/getPies')}}" class="grid_4 push_5" id="form_buscador" method="POST">
					<button type ='submit' class="ico"></button>
					<input type="text" class="inputField" required  name="term">
				</form>

			@yield_section
			</div>		
		</header><!-- Fin del Header -->
		<div class="separator"></div>
		
		@yield('Content')

		<div class="separator"></div>
		<footer>
			<div class="container_12">
				<div id="creditos" class="grid_4">
					<h5>Créditos:</h5>
					<p>Todos los derechos reservados <br>
					Diego Armando Castaño Castiblanco</p>
				</div>
				<h1 class="logo grid_3 push_5">Sistema <br>Integrado <br>de búsqueda</h1>
			</div>
		</footer><!-- Fin del footer-->	

		{{ HTML::script('js/jquery.js')}}
		{{ HTML::script('js/handlebars.js')}}
		{{ HTML::script('js/circleloading.js')}}
		{{ HTML::script('js/ranking_module.js')}}
		@yield('mainScripts')   
		@yield('scriptForm')
	</body>
</html>