<?php 
/**
 * ============================== 
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
class Mail {

	function __construct(){
			
    }
    
    public function validate($mail){
	    $mail=filter_var($mail, FILTER_SANITIZE_EMAIL);
	    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
	    	return true;
	    }else{
	    	return false;
	    }
    }	 
    		
	public function send($to,$subject,$message,$header){
		if(mail($to,$subject,$message,$header)){
			return true;
		}else{
			return false;
		}
    		
  	}
  		
}	
?>