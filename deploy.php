<?php

	include_once("lib/aegis.php");
	$session = new Session();

	$receiver = new DataReceiver();

	/**
	* ==============================
	* Login Operations
	* ==============================
	*/

	// Receive Login Data
	if($data = $receiver -> receive("POST", "user,password")){

		$savedPasswords = $db -> query("SELECT `Password` FROM Admin WHERE `Mail` = ?", [$data["user"]]);

		if(!empty($savedPasswords)){
			$savedPassword = $savedPasswords[0]["Password"];

			// TODO: Modificar la clase password para que se pueda hacer el check sin tener la instancia.
			if(password_verify($data["password"], $savedPassword)){
				$session -> set("logged", true);
			}
		}
	}

	/**
	* ==============================
	* Comment Operations
	* ==============================
	*/

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

			if($db -> insert("Comments", $comment)){
				if($data["email"] != "tamalito@gmail.com"){
					$notification = [
						"Content" => $comment["Name"]. " (" . $comment["Mail"] .") comentó en " . $post["Title"],
						"Url" => $post["Url"],
						"Notifies" => $db -> getPdo() -> lastInsertId(),
						"Status" => "New"
					];
					$db -> insert("Notifications", $notification);

					$mail = new Mail();
					$mail -> addRecipient("tamalito@gmail.com");
					$mail -> setSubject($notification["Content"]);
					$mail -> setBody($notification["Content"]."\nPuedes ver su comentario siguiendo este link: http://www.moco-comics.com/".$post["Url"]);
					$mail -> addHeader("From: Moco Comics <noreply@moco-comics.com>");
					$mail -> send();

					if($comment["Parent"] !== 4){
						$email = getEmailFromComment($comment["Parent"]);
						if($email != $data["email"]){
							$mail2 = new Mail();
							$mail2 -> addRecipient($email);
							$mail2 -> setSubject($data["name"] . " respondió a tu comentario en " . $post["Title"]);
							$mail2 -> setBody($notification["Content"]."\nPuedes ver su respuesta siguiendo este link: http://www.moco-comics.com/".$post["Url"]);
							$mail2 -> addHeader("From: Moco Comics <noreply@moco-comics.com>");
							$mail2 -> send();
						}
					}
				}

				$template = new Template("{{each comments comment}}", ["comments" => getCommentsFrom($comment["PostID"])]);
				echo $template -> compile();
			}
		}
	}

	/**
	* ==============================
	* Characters Operations
	* ==============================
	*/

	// Create a new character
	if(($data = $receiver -> receive("POST", "nimage,nname,new-color")) && $session -> get("logged")){

		$data["nname"] = Text::capitalize($data["nname"]);

		$directory = explode(" ", $data["nname"])[0];
		$directory = Text::toFriendlyUrl($directory);

		if(!file_exists("img/comics/$directory")){

            if(mkdir("img/comics/$directory", 0755)){
	            $upload = new Upload("nimage",  "img/");

	            if($image = $upload -> upload()){

		            $category = [
			            "Name" => $data["nname"]
		            ];

		            if($db -> insert("Categories", $category)){
			            $character = [
							"Name" => $data["nname"],
							"Color" => $data["new-color"],
							"Directory" => $directory,
							"Image" => str_replace("img/", "", $image),
							"CategoryID" => $db -> getPdo() -> lastInsertId()
						];

						if($db -> insert("Characters", $character)){
							$template = new Template("{{each characters characterForm}}\r\n{{> newCharacterForm}}", ["characters" => getCharacters()]);
							echo $template -> compile();
						}
		            }

				}
            }
		}

	}

	// Update a character
	if(($data = $receiver -> receive("POST", "image,name,cid,caid,new-color")) && $session -> get("logged")){

		$upload = new Upload("image",  "img/");

		$character = [
			"Name" => $data["name"],
			"Color" => $data["new-color"]
		];

		if(!$upload -> isEmpty()){
			if($image = $upload -> upload()){
				$character["Image"] = str_replace("img/", "", $image);
			}
		}

        if($db -> update("Characters", $character, "ID", $data["cid"])){
			$category = [
	            "Name" => $data["name"]
	        ];

	        if($db -> update("Categories", $category, "ID", $data["caid"])){
		        $template = new Template("{{each characters characterForm}}\r\n{{> newCharacterForm}}", ["characters" => getCharacters()]);
				echo $template -> compile();
		    }
		}

	}

	/**
	* ==============================
	* Posts Operations
	* ==============================
	*/

	// Create or update a post
	if(($data = $receiver -> receive("POST", "post-id,post-category,post-title,post-content,image-input", true, true)) && $session -> get("logged")){

		$directory = getCharacterDirectory($data["post-category"]);

		if($directory != ""){
			$upload = new Upload("image-input",  "img/comics/$directory/");
		}else{
			$upload = new Upload("image-input",  "img/comics/");
		}

		$post = [
			"Title" => $data["post-title"],
			"Description" => "",
			"Keywords" => "",
			"Status" => "Published",
			"Content" => $data["post-content"],
			"CategoryID" => $data["post-category"]
		];

		if(!$upload -> isEmpty()){
			if($image = $upload -> upload()){
				$post["Image"] = str_replace("img/", "", $image);
			}
		}

		if($data["post-id"] == "0" || $data["post-id"] == 0){
			if($directory != ""){
				$post["Url"] = "comic/".Text::toFriendlyUrl($data["post-title"]);
			}else{
				$post["Url"] = Text::toFriendlyUrl($data["post-title"]);
			}

			if($db -> insert("Posts", $post)){
				$template = new Template("{{each posts adminPost}}", ["posts" => getAllPosts()]);
				echo $template -> compile();
			}
		}else{
			if($db -> update("Posts", $post, "ID", $data["post-id"])){
				$template = new Template("{{each posts adminPost}}", ["posts" => getAllPosts()]);
				echo $template -> compile();
			}
		}
	}

	// Upload the multiple images of a post's body
	if(($data = $receiver -> receive("POST", "img-pass")) && $session -> get("logged")){
		$upload = new Upload("img-pass", "img/Posts/");
		print_r($upload -> uploadAll());
	}

	// Delete a post
	if(($data = $receiver -> receive("POST", "DelPost")) && $session -> get("logged")){
		if($db -> update("Posts", ["Status" => "Deleted"], "ID", $data["DelPost"])){
			$template = new Template("{{each posts adminPost}}", ["posts" => getAllPosts()]);
			echo $template -> compile();
		}
	}

	// Return the information of a post when asked.
	if(($data = $receiver -> receive("POST", "postinfo")) && $session -> get("logged")){
		$post = getPostById($data["postinfo"]);
		if(!empty($post)){
			$post[0]["Date"] = dateToNiceDate($post[0]["Date"]);
			$post[0]["Category"] = categoryToName($post[0]["CategoryID"]);
			$post[0]["title_code"] = strtolower(Text::toFriendlyUrl($post[0]["Title"]));
			echo new JSON($post[0]);
		}
	}

	/**
	* ==============================
	* Store Products Operations
	* ==============================
	*/

	// Create a new product
	if(($data = $receiver -> receive("POST", "nsimage,nname,pp,nprice", true)) && $session -> get("logged")){

		$upload = new Upload("nsimage",  "img/store/");

		if($image = $upload -> upload()){
			$product = [
				"Name" => $data["nname"],
				"Price" => $data["nprice"],
				"Image" => str_replace("img/", "", $image),
				"Paypal" => $data["pp"]

			];

			if($db -> insert("Products", $product)){
				$template = new Template("{{each storeItems adminStoreItem}}\r\n{{> newStoreItemForm}}", ["storeItems" => getProducts()]);
				echo $template -> compile();
			}

		}
	}

	// Update a product
	if(($data = $receiver -> receive("POST", "sid,simage,name,pp,price", true)) && $session -> get("logged")){

		$upload = new Upload("simage",  "img/store/");

		$product = [
			"Name" => $data["name"],
			"Price" => $data["price"],
			"Paypal" => $data["pp"]
		];

		if(!$upload -> isEmpty()){
			if($image = $upload -> upload()){
				$product["Image"] = str_replace("img/", "", $image);
			}

		}

		if($db -> update("Products", $product, "ID", $data["sid"])){
			$template = new Template("{{each storeItems adminStoreItem}}\r\n{{> newStoreItemForm}}", ["storeItems" => getProducts()]);
			echo $template -> compile();
		}

	}

	// Delete a product
	if(($data = $receiver -> receive("POST", "DelStore")) && $session -> get("logged")){
		if($db -> delete("Products", "ID", $data["DelStore"])){
			$template = new Template("{{each storeItems adminStoreItem}}\r\n{{> newStoreItemForm}}", ["storeItems" => getProducts()]);
			echo $template -> compile();
		}
	}

	// Add a File to a Product
	if(($data = $receiver -> receive("POST", "belong,pdf")) && $session -> get("logged")){

		$upload = new Upload("pdf",  "lib/uploads/");

		if($pdf = $upload -> upload()){
			if($db -> update("Products", ["File" => str_replace("lib/uploads/", "", $pdf)], "ID", $data["belong"])){
				$template = new Template("{{each fileItems fileOption}}", ["fileItems" => getFileStoreItems()]);
				echo $template -> compile();
			}

		}
	}

	// Send a PDF to a buyer's mail
	if(($data = $receiver -> receive("POST", "sitem,smail,smessage")) && $session -> get("logged")){
		$mail = new PHPMailer();
		$mail -> From = 'noreply@moco-comics.com';
		$mail -> FromName = 'Moco Comics';
		$mail -> addAddress($data["smail"]);
		$mail -> addAttachment("lib/uploads/".$data["sitem"]);
		$mail -> Subject = 'Tu compra en Moco Comics!';
		$mail -> Body    = $data["smessage"];
		if($mail -> send()){
			echo "sent";
		}
	}

	/**
	* ==============================
	* Pages Operations
	* ==============================
	*/

	// Update a page information
	if(($data = $receiver -> receive("POST", "page-content,page-title,page-id", true)) && $session -> get("logged")){
		$page = [
			"Title" => $data["page-title"],
			"Content" => $data["page-content"]
		];

		if($db -> update("Pages", $page, "ID", $data["page-id"])){

			$template = new Template("{{each pages adminPage}}\r\n{{each settings adminSetting}}", ["pages" => getPages(), "settings" => getSettings()]);
			echo $template -> compile();
		}
	}

	/**
	* ==============================
	* Settings Operations
	* ==============================
	*/

	// Update a page information
	if(($data = $receiver -> receive("POST", "setting-value,setting-id", true)) && $session -> get("logged")){
		$setting = [
			"Value" => $data["setting-value"]
		];

		if($db -> update("Settings", $setting, "ID", $data["setting-id"])){

			$template = new Template("{{each pages adminPage}}\r\n{{each settings adminSetting}}", ["pages" => getPages(), "settings" => getSettings()]);
			echo $template -> compile();
		}
	}

	/**
	* ==============================
	* Notification Operations
	* ==============================
	*/

	if(($data = $receiver -> receive("POST", "Notifiying")) && $session -> get("logged")){
		if($db -> update("Notifications", ["Status" => "Read"], "ID", $data["Notifiying"])){
			$template = new Template("{{each notification notification}}", ["notification"  => getNotifications()]);
			echo $template -> compile();
		}
	}

	/**
	* ==============================
	* Various Operations
	* ==============================
	*/

	// Save the main message
	if(($data = $receiver -> receive("POST", "main-message", true, true)) && $session -> get("logged")){
		if($db -> update("Settings", ["Value" => $data["main-message"]], "Name", "Message")){

		}
	}
?>
