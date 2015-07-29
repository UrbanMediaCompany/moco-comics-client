<?php

/**
 * ==============================
 * Aegis Framework | MIT License1
 * http://www.aegisframework.com/
 * ==============================
 */

class Configuration {

	function __construct(){
	   /**/

		$this -> web_name = "Moco Comics";

        $this -> web_domain = "http://localhost/MocoComics/";
        $this->admin_mail="hyuchia@gmail.com";
        $this -> db = "Moco";
        $this -> db_host="localhost";
		$this -> db_user = "root";
        $this -> db_password = "7+7=Atriangulo";

        //$this -> db_password = "xampp123$";

        /*
        if(explode('.',$_SERVER['HTTP_HOST'])[0] == 'www'){
            $this -> web_domain = "http://www.moco-comics.com/";
        }else{
            $this -> web_domain = "http://moco-comics.com/";
        }
        $this -> admin_mail="tamalito@gmail.com";
        $this -> db = "mococomicsdb";
        $this -> db_host="mysql.moco-comics.com";
        $this -> db_user = "moco_comics";
        $this -> db_password = "3+3=Aocho";*/

	}

}

?>
