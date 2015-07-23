<?php
/**
 * ==============================
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */

	//include("lib/deploy.php");
    error_reporting(0);
	include("lib/custom-class.php");
	if (!isset($_GET["lang"])) {
        $_SESSION["lang"] = "en";
    }else{
	    $_SESSION["lang"] = $_GET["lang"];
    }

	$routes = $_->getRoute();
	$url=explode("/",$_SERVER['REQUEST_URI']);

    if(@$routes[1]!=""){
        $special = array("#",":","ñ",".","í","ó","ú","á","é","Í","Ó","Ú","Á","É");
        $common   = array("","","n","","i","o","u","a","e","I","O","U","A","E");
        if($routes[1]=="comic"){
            @$url=str_replace($special,$common,"comic/".$routes[2]);
        }else{
            $url=str_replace($special,$common,$routes[1]);
        }

    	$post=$custom->getPost($url);
	}

	if(@$routes[1]!=""){

		/*
			Route files to only name URL.
		*/

		if($routes[1]=="index.php"){
			header("location:/");
		}elseif($routes[1]=="admin.php"){
			header("location:/admin");
		}elseif($routes[1]=="login.php"){
			header("location:/login");
		}elseif($routes[1]=="comics.php"){
			header("location:/comics");
		}elseif($routes[1]=="about.php"){
			header("location:/about");
		}elseif($routes[1]=="store.php"){
			header("location:/store");
		}elseif($routes[1]=="feed.php"){
			header("location:/feed");
		}

		/*
			Route names to files.
		*/
		if($routes[1]=="index.php"){
			header("location:/");
		}elseif($routes[1]=="admin"){
			include_once("admin.php");
		}elseif($routes[1]=="login"){
			include_once("login.php");
		}elseif($routes[1]=="feed"){
			include_once("feed.php");
		}elseif($routes[1]=="comics" || $routes[1]=="archivo-de-comics"){
			include_once("comics.php");
		}elseif($routes[1]=="page"){
			include_once("main.php");
		}elseif($routes[1]=="el-autor" || $routes[1]=="about"){
			include_once("about.php");
		}elseif($routes[1]=="tienda" || $routes[1]=="store"){
			include_once("store.php");
		}elseif($routes[1]=="gracias"){
			include_once("thanks.php");
		}elseif($routes[1]=="comic"){
            if(count($post)>1){
                include_once("post.php");
            }else{
                include_once("404.html");
            }
		}else{
            if(count($post)>1){
                include_once("post.php");
            }else{
                include_once("404.html");
            }

		}



	}else{
		include_once("main.php");
	}


?>
