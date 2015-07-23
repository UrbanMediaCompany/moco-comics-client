<?php 


/**
 * Session class. - Controlls User Session
 * 
 * @extends Security
 */
class Session extends Security{
	

	/**
	 * Start the session, regenerate it's id for security and get user meta-data.
	 * 
	 * @access public
	 * @return void
	 */
	public function start(){
		
		session_start();
		
		//$this->regenerate();
		
		/**
		 * Array with user's meta-data.
		 * 
		 * @var mixed
		 * @access private
		 */
		$_SESSION["meta"]=["ip"=>$this->getUserIp(),"agent"=>$this->Agent];
	}

	
	/**
	 * Regenerate session's id.
	 * 
	 * @access public
	 * @return void
	 */
	public function regenerate(){
		session_regenerate_id(true); 
	}
	

	/**
	 * End and destroy the session, it's variables and cookie.
	 * 
	 * @access public
	 * @return void
	 */
	public function end(){
		unset($_SESSION); 
		session_unset();
		if(ini_get("session.use_cookies")){
			$params= session_get_cookie_params();
			setcookie(session_name(),"",time()-36000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
		}
		session_destroy();
		
	}
	
	/**
	 * Check if User meta-data is still the same.
	 * 
	 * @access public
	 * @param mixed $meta - Associative array with Ip and User Agent
	 * @return boolean
	 */
	public function check($meta){
		if($this->getUserIp()== $_SESSION["ip"] && $this->getUserAgent()== $_SESSION["agent"]){
			return true;
		}else{
			$this->close();
		}
		return false;
	}
}
?>