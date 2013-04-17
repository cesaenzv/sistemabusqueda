@layout('master')
@section('Content')
	<div id="star" style="height:50px;"></div>		
@endsection

@section('scriptRanking')

	{{ HTML::script('js/jquery.raty.js')}} 
	{{ HTML::script('js/ranking_module.js')}} 
	
@endsection