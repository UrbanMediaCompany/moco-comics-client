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


	$router -> registerRoute("/", new View("main", ["main"  => ["title" => "Página Principal"]], $meta));

	$router -> registerRoute("/admin", new View("main", ["main"  => ["title" => "Admin"]], $meta));

	$router -> registerRoute("/archivo-de-comics", new View("main", ["main"  => ["title" => "Archivo de Comics"]], $meta));

	$router -> registerRoute("/el-autor", new View("main", ["main"  => ["title" => "El Autor"]], $meta));

	$router -> registerRoute("/tienda", new View("main", ["main"  => ["title" => "Tienda"]], $meta));





	$router -> listen();
?>
