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
	// Receive the data of a comment
	if($data = $receiver -> receive("POST", "name,email,web,rep,cuco,comment", false, true)){
		$comment = [
			//"ID" => 0,
			"PostID" => $data["cuco"],
			"Parent" => $data["rep"],
			"Name" => $data["name"],
			"Mail" => $data["email"],
			"Web" => $data["web"],
			"Content" => $data["comment"],
			"Gravatar" => "http://www.gravatar.com/avatar/" . md5($data["email"]),
			"Agent" => Visitor::getUserAgent(),
			"IP" => Visitor::getIP(),
			"Status" => "Approved"
		];

		if($data["rep"] == "None" || $data["rep"] == "0"){
			$comment["Parent"] = 4;
		}

		if($db -> insert("Comment", $comment)){
			$template = new Template("{{each comments comment}}", ["comments" => getCommentsFrom($comment["PostID"])]);
			echo $template -> compile();
		}
	}




?>