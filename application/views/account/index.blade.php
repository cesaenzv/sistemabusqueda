@layout('../master')

@section('Content')

	<div class="container_12">

		{{Form::open('account/login', 'POST',  array('class' => 'registerForm'))}}

		{{Form::label('username', 'Nombre de usuario')}}
		{{Form::text('username')}}
		{{Form::label('password', 'Contraseña')}}
		{{Form::password('password')}}
		<input type="submit" value="iniciar"/>
		{{Form::close();}}

		@if(Session::get('login_errors'))
		{{Session::get('login_errors')}}
		@endif

	</div>

@endsection