<?php 

/**
 * Password class, handles everything related to passwords.
 */
class Password {
	
	
	/**
	 * Generates a Random Secure Password.
	 * 
	 * @access public
	 * @param int $length (default: 8)
	 * @return string
	 */
	public function generate($length = 8){
		$chars = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?1234567890";
		$password = substr(str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	/**
	 * Check Passowrd Strenght.
	 * 
	 * @access public
	 * @param mixed $password
	 * @return integer | boolean 
	 */
	public function strenght($password){
		$strenght=0;
		if(strlen($password>5)){
			$strenght+=1;
		}
		if(preg_match('/[A-Z]/', $password)){
			$strenght+=1;
		}
		if(preg_match('/[a-z]/', $password)){
			$strenght+=1;
		}
		if(preg_match('/[0-9]/', $password)){
			$strenght+=1;
		}
		
		if(!$strenght>0){
			return false;
		}
		return $strenght;
	}
	
	/**
	 * Hash given password with the Default Algorithm.
	 *
	 * The Data Base store should be at least of a 255 lenght
	 * 
	 * @access public
	 * @param mixed $password
	 * @return string
	 */
	public function hash($password){
        	$cost=$this->getCost();
			$hashed_password=password_hash($password, PASSWORD_DEFAULT, $cost);
			return $hashed_password;
		 }
    
	/**
	 * Check if given password matches the hash.
	 * 
	 * @access public
	 * @param mixed $password
	 * @param mixed $hash
	 * @return boolean
	 */
	public function compare($password,$hash){
			 if (password_verify($password, $hash)) {
				 return true;
			 }else{
				return false;
			 }
		 }    
          
    /**
     * Get Computational Cost for hashing Passwords.
     * 
     * A 10 is a Standard
     *
     * @access private
     * @return array - Associative array with the cost.
     */
    private function getCost(){
        $timeTarget = 0.2; 

		$cost = 9;
		do {
			$cost++;
			$start = microtime(true);
			password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
			$end = microtime(true);
			} while (($end - $start) < $timeTarget);
			 
       return ["cost" => $cost];
    }
}
?>