<?php

	/* Place Your Functions in here */

	$db = new Database("moco_comics", "3+3=Aocho", "mococomics", "mysql.moco-comics.com");

	function getAllPublishedPosts(){
		global $db;
		return $db -> query("SELECT * FROM `Post` WHERE `Status` = 'Published' ORDER BY Date(`Date`) DESC");
	}

	// TODO: Make this function return the number of published posts
	function countPosts(){

	}

	function getLatestPost(){
		global $db;
		$post = $db -> query("SELECT * FROM `Post` WHERE `Date`IN (SELECT MAX(`Date`) FROM `Post` WHERE `Status` = 'Published')")[0];
		$post["nice_date"] = dateToNiceDate($post["Date"]);
		$post["Category"] = categoryToName($post["CategoryID"]);
		return $post;
	}

	function getPostsForPage($page){
		global $db;
		$query = $db -> query("SELECT * FROM `Post` WHERE `Status` = 'Published' AND `Date` NOT IN (SELECT MAX(`Date`) FROM `Post` WHERE `Status` = 'Published')  ORDER BY Date(`Date`) DESC");

		foreach($query as $index => $post){
			$query[$index]["nice_date"] = dateToNiceDate($post["Date"]);
			$query[$index]["Category"] = categoryToName($post["CategoryID"]);
			$query[$index]["title_code"] = strtolower(Text::toFriendlyUrl($post["Title"]));
		}

		return array_slice($query, $page, 4);
	}

	function categoryToName($id){
		global $db;
		return  $db -> query("SELECT `Name` FROM `Category` WHERE `ID` = ?", [$id])[0]["Name"];
	}

	function dateToNiceDate($date){
		setlocale(LC_TIME, "es_MX.UTF-8","es");
		return ucwords(strftime("%A %e de %B del %Y ",strtotime($date)));
	}

	function getSettingsValue($name){
		global $db;
		return $db -> query("SELECT `Value` FROM `Setting` WHERE `Name` = ?", [$name])[0]["Value"];
	}

	// TODO: Make this function accept a page name and retrieve it's information from the database
	function getPages(){
		global $db;
		return $query = $db -> query("SELECT * FROM `Page`");
	}

?>