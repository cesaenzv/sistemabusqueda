@layout('master')
@section('Content')
	<div class="container_12">
		
		<div id="wrapper">
		@include('handlebarsForm')
	</div>
	{{Form::label('europeana_term', 'selecciona el termino')}}
	{{Form::select('europeana_term', $terminos)}}
	<button id="callFormButton">Agregar Data</button>
	</div>
		
@endsection

@section('scriptForm')



	{{ HTML::script('js/formMetadataJS.js')}} 
	
@endsection
