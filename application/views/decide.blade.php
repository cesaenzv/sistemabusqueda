@layout('master')


@section('Content')


<section id="landingArea">
	<div class="container_12">
		<div  class="grid_12 selectContainer">
			<h1 class="landHeading">Selecciona motor de búsqueda</h1>
			<a href="{{url('semantic')}}" class="landing">Búsqueda semántica</a>
			<a href="{{url('graphic')}}" class="landing">Busqueda tradicional</a>
		</div>
	</div>
</section>

@endsection

@section('searchbar')
@endsection