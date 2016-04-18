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

		$post = getPostById($comment["PostID"]);
		if(!empty($post)){
			$post = $post[0];

			if($db -> insert("Comment", $comment)){
				$notification = [
					"Content" => $comment["Name"]. " (" . $comment["Mail"] .") comentó en " . $post["Title"],
					"Url" => $post["Url"],
					"Notifies" => $db -> getPdo() -> lastInsertId(),
					"Status" => "New"
				];
				$db -> insert("Notification", $notification);
				$template = new Template("{{each comments comment}}", ["comments" => getCommentsFrom($comment["PostID"])]);
				echo $template -> compile();
			}
		}
	}

	// Receive the Get Post Info command
	if(($data = $receiver -> receive("POST", "postinfo")) && $session -> get("logged")){
		$post = getPostById($data["postinfo"]);
		if(!empty($post)){
			$post[0]["Date"] = dateToNiceDate($post[0]["Date"]);
			$post[0]["Category"] = categoryToName($post[0]["CategoryID"]);
			$post[0]["title_code"] = strtolower(Text::toFriendlyUrl($post[0]["Title"]));
			echo new JSON($post[0]);
		}
	}




?>