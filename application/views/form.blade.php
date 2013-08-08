@layout('master')
@section('Content')
	<div class="container_12">
		
		<div id="wrapper">
		@include('handlebarsForm')
	</div>
	{{Form::label('europeana_term', 'selecciona el termino', array('class' => 'niceLabel'))}}
	{{Form::select('europeana_term', $terminos, 'all' , array('class' => 'niceSelect'))}}
	<button id="callFormButton">Agregar Data</button>
	</div>
		
@endsection

@section('scriptForm')



	{{ HTML::script('js/formMetadataJS.js')}} 
	
@endsection
