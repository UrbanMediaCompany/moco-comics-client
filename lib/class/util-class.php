<?php   
/**
 * ============================== 
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
	class Util {
                
		function __construct(){
            
        }
		public function getDate(){
			
		}
		
		public function getRandomString($length){
			 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			 $randomString = '';
			 for ($i = 0; $i < $length; $i++) {
				 $randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}
		
		function __destruct() {
           
        }
        
    } 
?>