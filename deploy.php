<?php

	include_once("lib/aegis.php");
	$session = new Session();

	$receiver = new DataReceiver();


	// Receive Login Data
	if($data = $receiver -> receive("POST", "user,password")){
		global $db;

		$savedPasswords = $db -> query("SELECT `Password` FROM Admin WHERE `Mail` = ?", [$data["user"]]);

		if(!empty($savedPasswords)){
			$savedPassword = $savedPasswords[0]["Password"];

			// TODO: Modificar la clase password para que se pueda hacer el check sin tener la instancia.
			if(password_verify($data["password"], $savedPassword)){
				$session -> set("logged", true);
			}
		}

	}




?>