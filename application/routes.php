<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', function()
{
	return View::make('home');
});



/*Route::get('/form', function(){
	return View::make('form');
});*/

Route::get('form', 'formc@getFormFields',function($result){
	
	dd($result);
});

// Route::get('/prueba',function(){
// 	function get_MetadataId($idTerm, $idColumn){
// 		if ($idColumn == "ParentKey"){
// 			$metadatas = DB::table('metadata AS m')
// 						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
// 						->where("m.$idColumn",'=',$idTerm)->get('id_metadata_term');
// 			return $metadatas;
// 		}
// 		else if($idColumn == "term_id"){
// 			$metadatas = DB::table('metadata AS m')
// 						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
// 						->where("e.$idColumn",'=',$idTerm)->get('id_metadata_term');
// 			return $metadatas;
// 		}		
		
// 	}

// 	function getMandatoryResourceList($metadatasId,$criterio,$group){
// 		$resources = array();
// 		foreach ($metadatasId as $metadataId) {
// 			$result = Mandatory::where_id_metadata_mandatory($metadataId->id_metadata_term)
// 				->where($criterio,'=',$group)->first(array('EuropeanaURL','Title','Description','Subject','Type'));	
// 			if ($result){
// 				$resources[] =$result->to_array();
// 			}
// 		}				
// 		return  $resources;
// 	}

// 	$result = getMandatoryResourceList(get_MetadataId(1000015647, 'term_id'),'Language','en');
// 	dd($result);


Route::get('nuevorecurso', 'formc@index');

Route::get('logout', function(){

	
	Auth::logout();
	return Redirect::to('account');
});



// Route::get('/prueba',function(){
// 	function get_MetadataId($idTerm, $idColumn){		
// 		$metadatas = DB::table('metadata AS m')
// 						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
// 						->where("m.$idColumn",'=',$idTerm)->get('id_metadata_term');
// 		return $metadatas;
// 	}

// 	$result = get_MetadataId(300111079, 'ParentKey');
// 	dd($result);

// });


Route::Controller('account');
Route::controller('text');
Route::controller('resource');
Route::controller('formc');

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('account')->with('login_errors','Primero inicie sesión');
});