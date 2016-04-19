<?php

	/* Place Your Functions in here */

	//$db = new Database("moco_comics", "3+3=Aocho", "mococomics", "mysql.moco-comics.com");
	$db = new Database("root", "xampp123$", "MocoComics");

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
		global $db;
		$count = $db -> query("SELECT `Name`, COUNT(`Name`) AS `Ocurrence` FROM `Comment` WHERE MONTH(`Date`) = ? AND YEAR(`Date`)= ? AND `Mail` != 'tamalito@gmail.com' GROUP BY `Name` ORDER BY `Ocurrence` DESC LIMIT 1", [date("m"), date("Y")]);
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
		return $db -> selectAllFrom("Character");
	}

	function getProducts(){
		global $db;
		return $query = $db -> query("SELECT * FROM `Product`");
	}

	function getStoreItems(){
		global $db;
		return $db -> selectAllFrom("Product");
	}

	function getFileStoreItems(){
		global $db;
		return $db -> query("SELECT * FROM `Product` WHERE `File` IS NOT NULL AND `FILE` != ''");
	}

	function getNotifications(){
		global $db;
		return $db -> query("SELECT * FROM `Notification` WHERE `Status` = 'New' ORDER BY DATE(`Date`) DESC LIMIT 25");
	}

	function getCategories(){
		global $db;
		return $db -> query("SELECT * FROM `Category`");
	}

	function getPost($url){
		global $db;
		$post = $db -> query("SELECT * FROM `Post` WHERE `Url` = ?", [$url]);
		if(!empty($post)){
			$post = $post[0];
			$post["nice_date"] = dateToNiceDate($post["Date"]);
			$post["Category"] = categoryToName($post["CategoryID"]);
			$post["title_code"] = strtolower(Text::toFriendlyUrl($post["Title"]));
		}

		return $post;
	}

	function getCommentsFrom($id){
		global $db;
		$comments = $db -> query("SELECT * FROM `Comment` WHERE `PostID` = ? AND (`PARENT` IS NULL OR `Parent` = 4)", [$id]);
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
		return $db -> query("SELECT * FROM `Comment` WHERE `Parent` = ? ORDER BY DATE(`Date`) DESC", [$id]);
	}

	function getComicsFromCategory($category){
		global $db;
		//$comics = $db -> query("SELECT * FROM `Post` WHERE `CategoryID` = ? ORDER BY DATE(`Date`) DESC", [$category]);
		$comics = $db -> query("SELECT * FROM `Post`ORDER BY DATE(`Date`) DESC");
		foreach($comics as $index => $comic){
			$comics[$index]["nice_date"] = dateToNiceDate($comic["Date"]);
			$comics[$index]["Category"] = explode(" ", categoryToName($comic["CategoryID"]))[0];
		}
		return $comics;
	}

	function getFeed(){
		global $db;
		$posts = getPostsForPage(0);
		foreach($posts as $index => $post){
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
		return $db -> selectAllWhere("Post", "ID", $id);
	}

	function getMostCommentedPost(){
		global $db;
		$count = $db -> query("SELECT `PostID` , COUNT(`PostID`) AS `Ocurrence` FROM `Comment`  WHERE MONTH(`Date`) = ? AND YEAR(`Date`)=? GROUP BY `PostID` ORDER BY `Ocurrence` DESC LIMIT 1;", [date("m"), date("Y")]);
		if(!empty($count)){
			$count = $count[0];
			$post = $db -> query("SELECT `Title` FROM Post WHERE ID = ?", [$count["PostID"]]);
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
?>
