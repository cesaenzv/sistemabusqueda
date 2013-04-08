@layout('master')
@section('Content')
	<div class="container_12">
		
		<div id="wrapper">
		@include('handlebarsForm')
	</div>	
	<button id="callFormButton">Agregar Data</button>
	</div>
		
@endsection

@section('scriptForm')

	{{ HTML::script('js/formMetadataJS.js')}} 
	
@endsection
