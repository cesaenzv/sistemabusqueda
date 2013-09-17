<?php
class UserRepository {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Se crea un nuevo usuario con respecto a la IP de la persona que ingresa. 
		-Variables:			
			
		-Retorno:
			$user-> Usuario nuevo o ya creado de la obtenida IP
	*/

	public function create_VisitorUser () {
		$userIp  = $this->get_RealIpAdress();
		$user = User::where_username($userIp)->first();
		if($user == null){
			$user = User::create(array(
				"username"=>$userIp,
				"password"=>$userIp
			));
		}					
		return $user;
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Funcion que obtiene la IP del usuario que usa la aplicación 
		-Variables:			
			
		-Retorno:
			IP del nuevo usuario
	*/
	protected function get_RealIpAdress(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	    	return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	    	return $_SERVER['HTTP_X_FORWARDED_FOR'];
	  	} else {
	    	return $_SERVER['REMOTE_ADDR'];
	  	}
	}

}