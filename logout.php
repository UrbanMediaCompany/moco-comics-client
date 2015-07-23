<?php
/**
 * ============================== 
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
 	include("lib/class/security-class.php");
    include("lib/class/session-class.php");
	
	$session = new Session();
	$session->start();
	$session->end();
	
	header("location:index.php");
?>