<?php
/**
 * ==============================
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
	require_once("class/security-class.php");
	require_once("class/session-class.php");
	require_once("class/mail-class.php");
	require_once("class/password-class.php");
	require_once("class/files-class.php");
	require_once("class/util-class.php");
    require_once("class/text-class.php");
	require_once("class/mail-class.php");
	require_once("class/database-class.php");
    require_once("class/updater-class.php");
	require_once(__DIR__."/../config.php");
	require_once(__DIR__."/../version.php");
	require_once(__DIR__."/../resources/strings.php");
	/**
	 * Aegis main class.
	 */

	class Aegis {

		function __construct(){

			$this -> config = new Configuration();
			$this -> version = new Version();
			$this -> security = new Security();
			if($this->config->db!=""){
				$this -> database = new Database($this->config->db_user,$this->config->db_password,$this->config->db,$this->config->db_host);
			}
			$this -> files = new Files();
			$this -> util = new Util();
			$this -> session = new Session();
			$this -> mail = new Mail();
            $this -> text = new Text();
			$this -> password = new Password();
            $this -> updater = new Updater($this->version->version,$this->version->version_number,$this->version->update_url);

		}


		/**
		 * String Printing Function.
		 *
		 * Takes values from the String Resource.
		 *
		 * @access public
		 * @param mixed $data
		 * @return void
		 */
		public function p($data){
			global $strings;
			if(strpos($data,"@string")>=0){
				$value=explode("/", $data);
				echo ($strings[$_SESSION["lang"]][$value[1]]);
			}else{
				echo htmlentities($data);
			}


		}


		/**
		 * Read Post's Request's.
		 *
		 * Receives a string, with the list of values
		 * Checks if they are checked and validates them.
		 *
		 * @access public
		 * @param mixed $keys
		 * @return void
		 */
		public function readPost($keys){
			$post=explode(",", $keys);
			$array=[];
			foreach($post as $value){
				if(isset($_POST[$value])){

					if(($new=$this->security->secureData($_POST[$value]))){
						$array[$value]=$new;
					}else{

						return false;
					}

				}else{
					return false;
				}
			}
			return $array;
		}

		/**
		 * Read GET Request's.
		 *
		 * Receives a string, with the list of values
		 * Checks if they are checked and validates them.
		 *
		 * @access public
		 * @param mixed $keys
		 * @return void
		 */
		public function readGet($keys){
			$post=explode(",", $keys);
			$array=[];
			foreach($post as $value){
				if(isset($_GET[$value])){
					if(($new=$this->security->secureData($_GET[$value]))){
						$array[$value]=$new;
					}else{
						return false;
					}

				}else{
					return false;
				}
			}
			return $array;
		}

		/**
		 * Get URL Route.
		 *
		 * Decomposes the current URL into an array
		 * to act as a router
		 *
		 * @access public
		 * @return void
		 */
		public function getRoute(){
			$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	    	$url = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	    	if(strstr($url, '?')){
		    	 $url = substr($url, 0, strpos($url, '?'));
			}
	    	$url = '/' . trim($url, '/');
	    	$routes = array();
	    	$routes=explode('/', $url);
	    	return $routes;
		}



	}
	$_=new Aegis();
?>