@layout('master')
@section('Content')
	<div id="star"></div>		
	<div id="star1"></div>
	<div id="star2"></div>
	<div id="star3"></div>
@endsection

@section('scriptRanking')

	{{ HTML::script('js/jquery.raty.js')}} 
	{{ HTML::script('js/ranking_module.js')}} 
	
@endsection