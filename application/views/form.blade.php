@layout('master')
@section('Content')
	<div id="wrapper">
		@include('handlebarsForm')
	</div>	
	<button id="callFormButton">Agregar Data</button>	
@endsection

@section('scriptForm')

	{{ HTML::script('js/formMetadataJS.js')}} 
	
@endsection
