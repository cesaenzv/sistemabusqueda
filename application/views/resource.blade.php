@layout('master')
@section('Content')
	<div id="contentResource">
		<span id="numOfResources"></span>
	    <ul id="listResource">
	    	@include('handlebarsResource')
	    </ul>
	</div>	
@endsection