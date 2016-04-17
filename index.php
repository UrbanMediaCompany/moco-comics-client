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


	$router = new Router("localhost/MocoComics");

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


    if(@$routeParts[1] == "page" && @$routeParts[2]!=""){
        $page = (intval($routeParts[2]) * 4) - 3;

        // TODO: Poner un if para solo registrar el route si getPostsForPage regresa algo.

        $router -> registerRoute("/page/" . $routeParts[2], new View("main", [
			"main" => ["message" => getSettingsValue("Message")],
			"featured" => getLatestPost(),
			"posts" => getPostsForPage($page),
			"footer" => ["year" => $meta["year"]],
			// TODO: Cambiar el counter, el incoming y el passed.
			"navigation" => ["counter" => 0, "incoming" => 0, "passed" => 0]
		], $meta));
    }else{
       $page = 0;
    }

	$router -> registerRoute("/", new View("main", [
		"main" => ["message" => getSettingsValue("Message")],
		"featured" => getLatestPost(),
		"posts" => getPostsForPage($page),
		"footer" => ["year" => $meta["year"]],
		"navigation" => ["counter" => countPosts(), "incoming" => 0, "passed" => 0]
	], $meta));



	if($session -> get("logged")){
		$router -> registerRoute("/admin", new View("dashboard",
			[
				"dashboard" => [
					"mostCommentedPost" => "",
					"numberOfPosts" => countPosts(),
					"numberOfComments" => countComments(),
					"topCommenter" => ""

				],
				"notification"  => [],
				"characters" => getCharacters(),
				"posts" => getAllPosts()

			]
			, $meta, "admin.php"));
	}else{
		$router -> registerRoute("/admin", new View("login", ["main"  => ["title" => "Admin"]], $meta, "login.php"));
	}

	$router -> registerRoute("/logout", "logout.php");


	$router -> registerRoute("/archivo-de-comics", new View("comics", ["main"  => ["title" => "Archivo de Comics"]], $meta));


	// TODO: Quitar esta y remplazarla por la dínamica de Page (Issue #1)
	$router -> registerRoute("/el-autor", new View("main", ["main"  => ["title" => "El Autor"]], $meta));

	$router -> registerRoute("/tienda", new View("store", ["store"  => [
		"title" => "Tienda",
		"message" => getSettingsValue("Message"),
		"products" => getProducts(),
		"footer" => ["year" => $meta["year"]]
	]], $meta));


	// TODO: Registrar las rutas de la tabla Page de la base de datos
	// Y mandar su información, para lograr

	$pages = getPages();

	foreach($pages as $page){

	}



	$router -> listen();
?>
