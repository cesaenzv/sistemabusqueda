<!-- @layout('master')

@section('searchbar')

<form action="{{url('semantic/searchTerm')}}" class="grid_4 push_5" id="form_buscador" method="POST">
				<button type ='submit' class="ico"></button>
				<input type="text" class="inputField" required  name="term" id="term"  placeholder="busqueda semantica">
			</form>

@endsection

@section('Content')
<section id="visualArea">
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
			
	</div>
</section><!-- Fin de la seccion visual -->
<!-- <div class="separator"></div>
 --><!-- Fin del panel contenido-->
 <section id="semanticContent" class="show">
 	<a class="btnView"></a>
	<form action="{{url('semantic/searchTerm')}}" method="POST">
		<input type="text" class="inputField" required  name="term" id="term"  placeholder="busqueda semantica">
		<button type ='submit' class="ico"></button>
	</form>
 </section>