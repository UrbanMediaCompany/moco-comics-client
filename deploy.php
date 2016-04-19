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

            if(mkdir("img/comics/$directory", 0744)){
	            $upload = new Upload("nimage",  "img/");

	            if($image = $upload -> upload()){

		            $category = [
			            "Name" => $data["nname"]
		            ];

		            if($db -> insert("Category", $category)){
			            $character = [
							"Name" => $data["nname"],
							"Color" => $data["new-color"],
							"Directory" => $directory,
							"Image" => str_replace("img/", "", $image),
							"CategoryID" => $db -> getPdo() -> lastInsertId()
						];

						if($db -> insert("Character", $character)){
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

        if($db -> update("Character", $character, "ID", $data["cid"])){
			$category = [
	            "Name" => $data["name"]
	        ];

	        if($db -> update("Category", $category, "ID", $data["caid"])){
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

	// Create a new post
	if(($data = $receiver -> receive("POST", "post-id,post-category,post-title,post-content,image-input", true, true)) && $session -> get("logged")){
		$directory = getCharacterDirectory($data["post-category"]);
		if($directory != ""){
			$upload = new Upload("image-input",  "img/comics/$directory/");
		}else{
			$upload = new Upload("image-input",  "img/comics/");
		}

		$post = [
			"Next" => 188,
			"Previous" => 188,
			"Title" => $data["post-title"],
			"Description" => "",
			"Keywords" => "",
			"Status" => "Published",
			"Content" => $data["post-content"],
			"Url" => Text::toFriendlyUrl($data["post-title"]),
			"CategoryID" => $data["post-category"]
		];

		if(!$upload -> isEmpty()){
			if($image = $upload -> upload()){
				$post["Image"] = str_replace("img/", "", $image);
			}
		}

		if($db -> insert("Post", $post)){
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
	if(($data = $receiver -> receive("POST", "nsimage,nname,pp,nprice")) && $session -> get("logged")){

		$upload = new Upload("nsimage",  "img/store/");

		if($image = $upload -> upload()){
			$product = [
				"Name" => $data["nname"],
				"Price" => $data["nprice"],
				"Image" => str_replace("img/", "", $image),
				"Paypal" => $data["pp"]

			];

			if($db -> insert("Product", $product)){
				$template = new Template("{{each storeItems adminStoreItem}}\r\n{{> newStoreItemForm}}", ["storeItems" => getStoreItems()]);
				echo $template -> compile();
			}

		}
	}

	// Update a product
	if(($data = $receiver -> receive("POST", "sid,simage,name,pp,price")) && $session -> get("logged")){

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

		if($db -> update("Product", $product, "ID", $data["sid"])){
			$template = new Template("{{each storeItems adminStoreItem}}\r\n{{> newStoreItemForm}}", ["storeItems" => getStoreItems()]);
			echo $template -> compile();
		}

	}

	// Delete a product
	if(($data = $receiver -> receive("POST", "DelStore")) && $session -> get("logged")){
		if($db -> delete("Product", "ID", $data["DelStore"])){
			$template = new Template("{{each storeItems adminStoreItem}}\r\n{{> newStoreItemForm}}", ["storeItems" => getStoreItems()]);
			echo $template -> compile();
		}
	}


	/**
	* ==============================
	* Pages Operations
	* ==============================
	*/





?>