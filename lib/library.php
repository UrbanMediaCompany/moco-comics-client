<?php

	/* Place Your Functions in here */

	$db = new Database("moco_comics", "M0c0C0m1c2D4t4323", "MocoComics");

	function getAllPosts(){
		global $db;
		$posts = $db -> query("SELECT * FROM `Posts` WHERE `Status` = 'Published' OR `Status` = 'Draft' ORDER BY DATE(`Date`) DESC");
		foreach($posts as $index => $post){
			$posts[$index]["nice_date"] = dateToNiceDate($post["Date"]);
		}

		return $posts;
	}

	function getAllPublishedPosts(){
		global $db;
		return $db -> query("SELECT * FROM `Posts` WHERE `Status` = 'Published' ORDER BY Date(`Date`) DESC");
	}

	function countPosts(){
		global $db;
		$count = $db -> query("SELECT COUNT(`ID`) AS `Count` FROM `Posts` WHERE `Status` = 'Published'");

		if(!empty($count)){
			return $count[0]["Count"];
		}else{
			return "";
		}
	}

	function getLatestPost(){
		global $db;
		$post = $db -> query("SELECT * FROM `Posts` WHERE `Date`IN (SELECT MAX(`Date`) FROM `Posts` WHERE `Status` = 'Published')")[0];
		$post["nice_date"] = dateToNiceDate($post["Date"]);
		$post["Category"] = categoryToName($post["CategoryID"]);
		return $post;
	}

	function getPostsForPage($page){
		global $db;
		$query = $db -> query("SELECT * FROM `Posts` WHERE `Status` = 'Published' AND `Date` NOT IN (SELECT MAX(`Date`) FROM `Posts` WHERE `Status` = 'Published')  ORDER BY Date(`Date`) DESC");

		foreach($query as $index => $post){
			$query[$index]["nice_date"] = dateToNiceDate($post["Date"]);
			$query[$index]["Category"] = categoryToName($post["CategoryID"]);
			$query[$index]["title_code"] = strtolower(Text::toFriendlyUrl($post["Title"]));
		}

		return array_slice($query, $page, 4);
	}

	function categoryToName($id){
		global $db;
		return  $db -> query("SELECT `Name` FROM `Categories` WHERE `ID` = ?", [$id])[0]["Name"];
	}

	function getCharacterDirectory($id){
		global $db;
		$character = $db -> query("SELECT `Directory` FROM `Characters` WHERE `CategoryID` = ?", [$id]);
		if(!empty($character)){
			$character = $character[0]["Directory"];
		}else{
			$character = "";
		}
		return  $character;
	}

	function dateToNiceDate($date){
		setlocale(LC_TIME, "es_MX.UTF-8","es");
		return ucwords(strftime("%A %e de %B del %Y ",strtotime($date)));
	}

	function getSettingsValue($name){
		global $db;
		return $db -> query("SELECT `Value` FROM `Settings` WHERE `Name` = ?", [$name])[0]["Value"];
	}

	function getPages(){
		global $db;
		return $query = $db -> query("SELECT * FROM `Pages`");
	}

	function getSettings(){
		global $db;
		return $query = $db -> query("SELECT * FROM `Settings`");
	}

	function countComments(){
		global $db;
		$count = $db -> query("SELECT COUNT(`ID`) AS `Count` FROM `Comments` WHERE `Mail` NOT IN (SELECT `Mail` FROM `Admin`)");
		if(!empty($count)){
			return $count[0]["Count"];
		}else{
			return "";
		}
	}

	function getTopCommenter(){
		global $db;
		$count = $db -> query("SELECT `Name`, COUNT(`Name`) AS `Ocurrence` FROM `Comments` WHERE MONTH(`Date`) = ? AND YEAR(`Date`)= ? AND `Mail` != 'tamalito@gmail.com' GROUP BY `Name` ORDER BY `Ocurrence` DESC LIMIT 1", [date("m"), date("Y")]);
		if(!empty($count)){
			$count = $count[0];
			if($count["Ocurrence"] > 0){
				return $count["Name"];
			}else{
				return "¡Nuevo Mes!";
			}
		}else{
			return "¡Nuevo Mes!";
		}
	}

	function getCharacters(){
		global $db;
		return $db -> selectAllFrom("Characters");
	}

	function getProducts(){
		global $db;
		return $db -> query("SELECT * FROM `Products` ORDER BY `ID` DESC");
	}

	function getFileStoreItems(){
		global $db;
		return $db -> query("SELECT * FROM `Products` WHERE `File` IS NOT NULL AND `FILE` != ''");
	}

	function getNotifications(){
		global $db;
		return $db -> query("SELECT * FROM `Notifications` WHERE `Status` = 'New' ORDER BY DATE(`Date`) DESC LIMIT 25");
	}

	function getCategories(){
		global $db;
		return $db -> query("SELECT * FROM `Categories`");
	}

	function getPost($url){
		global $db;
		$post = $db -> query("SELECT * FROM `Posts` WHERE `Url` = ?", [$url]);
		if(!empty($post)){
			$post = $post[0];
			$post["nice_date"] = dateToNiceDate($post["Date"]);
			$post["Category"] = categoryToName($post["CategoryID"]);
			$post["title_code"] = strtolower(Text::toFriendlyUrl($post["Title"]));
			$length = strlen($post["Content"]);
			if($length > 150){
                $post["Description"]= strip_tags (substr($post["Content"], 0, 150));
            }else{
                $post["Description"] = strip_tags ($post["Content"]);
            }
		}

		return $post;
	}

	function getCommentsFrom($id){
		global $db;
		$comments = $db -> query("SELECT * FROM `Comments` WHERE `PostID` = ? AND (`PARENT` IS NULL OR `Parent` = 4)", [$id]);
		$temp = [];
		foreach($comments as $comment){
			$comment["level"] = "main";
			array_push($temp, $comment);
			$replies = getRepliesTo($comment["ID"]);
			if(!empty($replies)){
				foreach($replies as $reply){
					$reply["level"] = "second";
					$reply["ID"] = $reply["Parent"];
					array_push($temp, $reply);
				}
			}
		}
		return $temp;
	}

	function getRepliesTo($id){
		global $db;
		return $db -> query("SELECT * FROM `Comments` WHERE `Parent` = ? ORDER BY DATE(`Date`) DESC", [$id]);
	}

	function getComicsFromCategory($category){
		global $db;
		//$comics = $db -> query("SELECT * FROM `Posts` WHERE `CategoryID` = ? ORDER BY DATE(`Date`) DESC", [$category]);
		$comics = $db -> query("SELECT * FROM `Posts` WHERE `Status` = 'Published' ORDER BY DATE(`Date`) DESC");
		foreach($comics as $index => $comic){
			$comics[$index]["nice_date"] = dateToNiceDate($comic["Date"]);
			$comics[$index]["Category"] = explode(" ", categoryToName($comic["CategoryID"]))[0];
		}
		return $comics;
	}

	function getFeed(){
		global $db;
		$posts = $db -> query("SELECT * FROM `Posts` WHERE `Status` = 'Published' ORDER BY Date(`Date`) DESC");
		$posts = array_slice($posts, 0, 5);
		foreach($posts as $index => $post){
			$posts[$index]["nice_date"] = dateToNiceDate($post["Date"]);
			$posts[$index]["Category"] = categoryToName($post["CategoryID"]);
			$posts[$index]["title_code"] = strtolower(Text::toFriendlyUrl($post["Title"]));
			$length = strlen($post["Content"]);
            if($length > 200){
                $posts[$index]["Description"]= substr($post["Content"], 0, $length/2);
            }else{
                $posts[$index]["Description"] = $post["Content"];
            }

		}
		return $posts;
	}

	function getPostById($id){
		global $db;
		return $db -> selectAllWhere("Posts", "ID", $id);
	}

	function getMostCommentedPost(){
		global $db;
		$count = $db -> query("SELECT `PostID` , COUNT(`PostID`) AS `Ocurrence` FROM `Comments`  WHERE MONTH(`Date`) = ? AND YEAR(`Date`)=? GROUP BY `PostID` ORDER BY `Ocurrence` DESC LIMIT 1;", [date("m"), date("Y")]);
		if(!empty($count)){
			$count = $count[0];
			$post = $db -> query("SELECT `Title` FROM `Posts` WHERE ID = ?", [$count["PostID"]]);
			if(!empty($post)){
				$post = $post[0];
				return $post["Title"];
			}else{
				return "¡Nuevo Mes!";
			}
		}else{
			return "¡Nuevo Mes!";
		}
	}

	function getEmailFromComment($id){
		global $db;
		$result = $db -> query("SELECT `Mail` FROM `Comments` WHERE `ID` = ?", [$id]);
		if(!empty($result)){
			return $result[0]["Mail"];
		}else{
			return "";
		}

	}
?>