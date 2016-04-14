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


    $posts = array_reverse($db -> selectAllByDate("Posts", "Date"));

    $routeParts = explode("/", $router -> getRoute());


    if(@$routeParts[1] == "page" && @$routeParts[2]!=""){
        $page = (intval($routeParts[2]) * 4) - 3;
    }else{
       $page = 0;
    }

    $router -> registerRoute("/", new View([
    "featured" => $posts[0],
    "posts" => array_slice($posts, $page, 4),
    "footer" => ["year" => $meta["year"]],
    "navigation" => ["counter" => 0, "incoming" => 0, "passed" => 0]
    ], $meta));

	$router -> registerRoute("/admin", new View("main", ["main"  => ["title" => "Admin"]], $meta));

	$router -> registerRoute("/archivo-de-comics", new View("main", ["main"  => ["title" => "Archivo de Comics"]], $meta));

	$router -> registerRoute("/el-autor", new View("main", ["main"  => ["title" => "El Autor"]], $meta));

	$router -> registerRoute("/tienda", new View("main", ["main"  => ["title" => "Tienda"]], $meta));





	$router -> listen();
?>
