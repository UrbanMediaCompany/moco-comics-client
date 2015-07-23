<?php 
/**
 * ============================== 
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
class Security {

	function __construct(){
    			$this->Agent=$this->getUserAgent();
    	}
    		
    function getUserBrowser(){ 
    	$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$ub = ''; 
		if(preg_match('/MSIE/i',$u_agent)){ 
        	$ub = "ie"; 
        } 
		elseif(preg_match('/Firefox/i',$u_agent)){ 
        	$ub = "firefox"; 
		} 
		elseif(preg_match('/Safari/i',$u_agent)){ 
        	$ub = "safari"; 
		} 
		elseif(preg_match('/Chrome/i',$u_agent)){ 
       		$ub = "chrome"; 
	   	} 
	   	elseif(preg_match('/Flock/i',$u_agent)){ 
        	$ub = "flock";
        } 
		elseif(preg_match('/Opera/i',$u_agent)){ 
       		$ub = "opera"; 
	   	} 
	   	elseif(preg_match('/Maxthon/i',$u_agent)){ 
        	$ub = "maxthon"; 
		} 
    
		return $ub; 
	} 
	
	public function validateType($item,$type){
		switch($type){
			case "int":
				if(is_int($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "float":
				if(is_int($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "double":
				if(is_int($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "numeric":
				if(is_numeric($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "array":
				if(is_array($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "boolean":
				if(is_bool($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "string":
				if(is_string($item)){
					return true;
				}else{
					return false;
				}
			break;
			case "null":
				if (is_null($item)){
					return true;
				}
				
			break;
			case "empty":
				if (empty($item)){
					return true;
				}
				
			break;
			default:
				return false;
			break;
		}
		
	}
	
		
	public function secureData($data){
		$flag=0;
        
		//if(trim($data)!=""){
			//$data_final=
			$original_data=$data;
			$data=strtolower($data);
			
			$injections=array("content-type:","mime-version:","content-transfer-encoding:","return-path:","subject:","from:",
							"envelope-to:","to:","bbc:","cc:","gzinflate(","eval(","base64_decode(","../","..\\",";--",
							"select ","update ","insert into ","gzinflate","eval ","base64_decode","<?php","<script",
							"<?","<%","?>", "union select","a%","[url=]","[link=]","truncate ","drop from ");//Block injection codes
							
			$spam=array("downloadlump","downloadcalm","downloadgive","downloadanti","webpaulo","downloaddry",
											"crabshare","downloadhurt","downloadlazy","peopleofthebook","vtwfoiauon","rursuasia"); //Block common Spam URLS and words
											
			$warnings = array_merge($spam, $injections);
			
			
			foreach ($warnings as $i){
					
				if (strpos($data,$i)!==false){
						$flag+=1;
				}
			}
			
			

		/*}else{ 
			
			$flag+=1;
		}*/
		if ($flag!=0){
			return false;
		}else{
			
				return trim($original_data);
			
		}
		
	}	
		 
	/**
	 * Get User's real IP even if it's using a Proxy.
	 * 
	 * @access public
	 * @return string | boolean - returns Ip if it's valid or false if it's invalid.
	 */
	public function getUserIp(){
		if (!empty($_SERVER["HTTP_CLIENT_IP"])){
			//check for ip from share internet
			$ip = $_SERVER["HTTP_CLIENT_IP"];
			
		}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			// Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}else{
            $ip = $_SERVER["REMOTE_ADDR"];
		}
		if (filter_var($ip,FILTER_VALIDATE_IP)){
			return $ip;
		}else{
			return false;
		}
	}
	
	public function getUserAgent(){
		return strtolower($_SERVER['HTTP_USER_AGENT']); 
	}
	
}
?>