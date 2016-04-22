<?php

	/**
	 * ==============================
	 * Aegis Framework | MIT License
	 * http://www.aegisframework.com/
	 * ==============================
	 */

 	// Uncomment on Production
    //error_reporting(0);

	include("lib/aegis.php");
	$session = new Session();

	$router = new Router("www.moco-comics.com");

	$meta = [
		"title" => "Moco-Comics - Monitos de Juanele",
		"description" => "Moco-Comics, Monitos de Juanele",
		"keywords" => "moco, comics, juanele, patote, tilinia, chonito, abuela, karateka, cuco, pepo",
		"author" => "Moco Comics",
		"twitter" => "@juanele_tamal",
		"google" => "105828506087143336483",
		"domain" => $router -> getBaseUrl(),
		"route" => 	$router -> getFullUrl(),
		"year" => date("Y"),
		"shareimage" => ""
	];

	$routeParts = explode("/", $router -> getRoute());

	$totalPosts = countPosts() - 1;

    if(@$routeParts[1] == "page" && @$routeParts[2] != ""){
        $page = (intval($routeParts[2]) * 4) - 3;

		$passed = (intval($routeParts[2]) * 4) - 4;

        // TODO: Poner un if para solo registrar el route si getPostsForPage regresa algo.

        $posts = getPostsForPage($page);

        if(!empty($posts)){
	       $router -> registerRoute("/page/" . $routeParts[2], new View("main", [
				"header" => ["message" => getSettingsValue("Anuncio")],
				"featured" => getLatestPost(),
				"posts" => $posts,
				"footer" => ["year" => $meta["year"]],
				// TODO: Cambiar el counter, el incoming y el passed.
				"navigation" => ["counter" => $totalPosts, "incoming" => ceil($totalPosts - 4) - $passed , "passed" => $passed]
			], $meta));
        }else{
	        $router -> registerRoute("/page/" . $routeParts[2], "error/404.html");
        }

    }else{
       $page = 0;
    }


	$router -> registerRoute("/", new View("main", [
		"header" => ["message" => getSettingsValue("Anuncio")],
		"featured" => getLatestPost(),
		"posts" => getPostsForPage($page),
		"footer" => ["year" => $meta["year"]],
		"navigation" => ["counter" => $totalPosts, "incoming" => $totalPosts - 4, "passed" => 0]
	], $meta));



	if($session -> get("logged")){
		$router -> registerRoute("/admin", new View("dashboard",
			[
				"dashboard" => [
					"mostCommentedPost" => getMostCommentedPost(),
					"numberOfPosts" => countPosts(),
					"numberOfComments" => countComments(),
					"topCommenter" => getTopCommenter(),
					"message" => getSettingsValue("Anuncio")

				],
				"notification"  => getNotifications(),
				"characters" => getCharacters(),
				"posts" => getAllPosts(),
				"storeItems" => getProducts(),
				"pages" => getPages(),
				"settings" => getSettings(),
				"fileItems" => getFileStoreItems(),
				"categories" => getCategories()

			],
			$meta, "admin.php"));
	}else{
		$router -> registerRoute("/admin", new View("login", ["main"  => ["title" => "Admin"]], $meta, "login.php"));
	}

	$router -> registerRoute("/logout", "logout.php");


	$router -> registerRoute("/archivo-de-comics", new View("comics",
		[
			"header"  => ["message" => getSettingsValue("Anuncio")],
			"items" => getCharacters(),
			"comic" => getComicsFromCategory(2),
			"footer" => ["year" => $meta["year"]]

		], $meta, "archive.php"));

	$router -> registerRoute("/tienda", new View("store", [
		"store"  => [
			"title" => "Tienda",
			"storeMessage" => getSettingsValue("Tienda")
		],
		"header" => ["message" => getSettingsValue("Anuncio")],
		"products" => getProducts(),
		"footer" => ["year" => $meta["year"]]
	], $meta));

	$pages = getPages();

	foreach($pages as $page){
		$meta["title"] = $page["Title"];
		$router -> registerRoute("/".$page["Url"], new View("page", ["page"  => $page,
			"extendedFooter" => ["year" => date("Y")],
			"header" => ["message" => getSettingsValue("Anuncio")],
			], $meta));
	}

	if(@$routeParts[1] != "" && @$routeParts[1] != "page"){
		$post = getPost(trim($router -> getRoute(), "/"));


		if(!empty($post)){
			$meta["title"] = $post["Title"];
			$meta["shareimage"] = $post["Image"];
			$meta["description"] = $post["Description"];
			$router -> registerRoute($router -> getRoute(), new View("fullPost",
				[
					"fullPost"  => $post,
					"header" => ["message" => getSettingsValue("Anuncio")],
					"comments" => getCommentsFrom($post["ID"]),
					"extendedFooter" => ["year" => date("Y")]
				], $meta, "post.php"));
		}else{

		}

	}

	if($router -> getRoute() == "/feed"){
		header('Content-Type: application/xml; charset=utf-8');
		$router -> registerRoute("/feed", new View(null, ["item" => getFeed()], $meta, "feed.php"));
	}
	$router -> listen();
?>