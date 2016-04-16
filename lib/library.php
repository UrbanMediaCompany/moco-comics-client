<?php

	/* Place Your Functions in here */

	$db = new Database("moco_comics", "3+3=Aocho", "mococomics", "mysql.moco-comics.com");

	function getAllPosts(){
		global $db;
		$posts = $db -> query("SELECT * FROM `Post` WHERE `Status` = 'Published' OR `Status` = 'Draft' ORDER BY DATE(`Date`) DESC");
		foreach($posts as $index => $post){
			$posts[$index]["nice_date"] = dateToNiceDate($post["Date"]);
		}

		return $posts;
	}

	function getAllPublishedPosts(){
		global $db;
		return $db -> query("SELECT * FROM `Post` WHERE `Status` = 'Published' ORDER BY Date(`Date`) DESC");
	}

	function countPosts(){
		global $db;
		$count = $db -> query("SELECT COUNT(`ID`) AS `Count` FROM `Post` WHERE `Status` = 'Published'");

		if(!empty($count)){
			return $count[0]["Count"];
		}else{
			return "";
		}
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

	function countComments(){
		global $db;
		$count = $db -> query("SELECT COUNT(`ID`) AS `Count` FROM `Comment` WHERE `Mail` NOT IN (SELECT `Mail` FROM `Admin`)");
		if(!empty($count)){
			return $count[0]["Count"];
		}else{
			return "";
		}
	}

	function getTopCommenter(){

	}

	function getCharacters(){
		global $db;
		return $db -> selectAllFrom("Character");
	}

?>