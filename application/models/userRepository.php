<?php
class UserRepository {

	public function create_VisitorUser () {
		$userIp  = $this->get_RealIpAddr();
		$newUser = User::create(array(
				"username"=>$userIp,
				"password"=>$userIp
			));
		return $newUser;
	}

	public function get_RealIpAddr(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	    	return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	    	return $_SERVER['HTTP_X_FORWARDED_FOR'];
	  	} else {
	    	return $_SERVER['REMOTE_ADDR'];
	  	}
	}

}