<?php
/**
 * ==============================
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */

include_once("aegis.php");

include_once 'class/mailer.php';


class Custom extends Aegis{

    public function getPosts(){
        $posts=$this->database->selectAllByDate("Posts","Date");
        return $posts;
	}

    public function getAdditionalData($data){
        $additional=$this->database->select($data,"Additional","Name");
        return $additional["Content"];
    }

    public function getAdditionals(){
        if($sth=$this->database->getPdo()->prepare("SELECT * FROM `Additional`")){
		   if (!$sth->execute()) {
               return false;
			}else{
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
        }
    }

    public function getCommentById($id){
        if($sth=$this->database->getPdo()->prepare("SELECT * FROM `Comments` WHERE ID = ?")){
		   if (!$sth->execute(array($id))) {
               return false;
			}else{
				return $sth->fetch(PDO::FETCH_ASSOC);
			}
			$sth=null;
		}
    }

    public function getStoreItems(){
        $items = $this -> database -> selectAllFrom("Store");
	 	return $items;
    }

    public function getCategories(){
	 	$categories=$this->database->selectAllFrom("Categories");
	 	return $categories;
	}

    public function getCharacters(){
	 	if($sth=$this->database->getPdo()->prepare("SELECT * FROM `Categories` WHERE Comic ='true'")){
		   if (!$sth->execute()) {
               return false;
			}else{
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			$sth=null;
		}
	}

    public function buildArchiveMenu(){
        $categories=$this->getCategories();
        $archive_menu="";
        foreach($categories as $i){
            if($i["Comic"]=="true"){
                $color = $i["Color"];
                $image = $i["Image"];
                $name = $i["Name"];
                $code_name=str_replace(" ", "-", $i["Name"]);
                if($image!=""){
                    $image_html="<img class='character-img' src='img/$image' />";
                }else{
                    $image_html="";
                }
                $archive_menu.="<a class='character-link' href='archivo-de-comics/#comics-wrapper' data-color='$color' data-character-link='$code_name'>$image_html<span>$name</span></a>";
            }

        }
        return $archive_menu;
    }

	public function buildArchive(){
	 	$posts=$this->getPosts();
	 	$categories=$this->getCategories();
	 	$archive="";
	 	setlocale(LC_TIME, "es_MX.UTF-8","es");
	 	foreach($categories as $i){
		 	foreach(array_reverse($posts) as $j){
			 	if($i["Name"]===$j["Category"] && $i["Comic"]=="true"){

				 	$image=$j["Image"];
                    $date=$j["Date"];
                    $cat=str_replace(" ", "-", $j["Category"]);
                    $title=$j["Title"];
                    $url=$j["Url"];
				 	$archive.="<div class='comic' data-character='$cat'><a href='$url/'><img class='lazy' data-original='$image'><noscript><img src='$image' /></noscript></a><span class='title'>$title</span><time datetime='$date'>".ucwords(strftime("%A %e de %B del %Y ",strtotime($j["Date"])))."</time></div>";

			 	}
		 	}
	 	}
	 	return $archive;
	}

    public function printPosts($init,$end){
		$posts=$this->getLatestPosts($init,$end);
		$result="";
		setlocale(LC_TIME, "es_MX.UTF-8","es");
		foreach(array_reverse($posts) as $i){
            $image=$i["Image"];
            $date=$i["Date"];
			$title=$i["Title"];
            $title_code=str_replace(" ", "-", $i["Title"]);
            $special = array("#",":","ñ",".","í","ó","ú","á","é","Í","Ó","Ú","Á","É","¡","¿","!","?",",");
            $common   = array("","","n","","i","o","u","a","e","I","O","U","A","E","","","","","");
            $title_code = str_replace($special, $common, $title_code);
            $nice_date=ucwords(strftime("%A %e de %B del %Y ",strtotime($i["Date"])));
            $category=$i["Category"];
            $content=$i["Content"];
            $link=$i["Url"];
            if(trim($image)!=""){
                if($this->files->getImageSize($image)){
                    $image_html="<img data-post='img' class='medium' src='$image' alt='$title'/>";
                }else{
                    $image_html="<img data-post='img' class='small' src='$image' alt='$title'/>";
                }
            }else{
                 $image_html="";
            }
            $description = trim(substr(strip_tags($content),0,150))."...";

            $result.="<article class='clearfix column sd-l7' id='$title_code'>$image_html<time datetime='$date'>$nice_date</time><span data-post='category'>$category</span><h5 data-post='title'>$title</h5>$content<footer data-post='footer'><div class='social-wrapper'><div class='facebook-buttons'><div class='fb-like' data-href='http://www.moco-comics.com/$link/' data-layout='button_count' data-action='like'data-show-faces='false' data-share='true'></div></div><div class='twitter-button'><a href='https://twitter.com/share' class='twitter-share-button' data-url='http://www.moco-comics.com/$link/'>Tweet</a></div><div class='google-button'><div class='g-plusone'  data-size='medium'  data-href='http://www.moco-comics.com/$link/'></div></div><div class='tumblr-button'><a class='tumblr-share-button' data-color='blue' data-notes='right' href='https://embed.tumblr.com/share' data-content='http://www.moco-comics.com/$image' data-posttype='photo'></a></div><div class='comments-button'><a href='$link/' class='link-to-post'><span class='fa fa-comment'></span>Comentarios</a></div></div></footer></article>";




		}

		return $result;
	}

    public function getLatest(){
        $posts=array_reverse($this->getPosts());
        $i=$posts[0];
        $image=$i["Image"];
        $date=$i["Date"];
        $category=$i["Category"];
        $content=$i["Content"];
        $title=$i["Title"];
        $link=$i["Url"];
        setlocale(LC_TIME, "es_MX.UTF-8","es");
        if($this->files->getImageSize($image)){
            $image_html="<img data-post='img' class='medium' src='$image' alt='$title'/>";
        }else{
            $image_html="<img data-post='img' class='small' src='$image' alt='$title'/>";
        }

        $description = trim(substr(strip_tags($content),0,150))."...";

        $nice_date=ucwords(strftime("%A %e de %B del %Y ",strtotime($i["Date"])));
        $html="<article class='clearfix'>$image_html<time datetime='$date'>$nice_date</time><span data-post='category'>$category</span><h5 data-post='title'>$title</h5>$content<footer data-post='footer'><div class='social-wrapper'><div class='facebook-buttons'><div class='fb-like' data-href='http://www.moco-comics.com/$link/' data-layout='button_count' data-action='like'data-show-faces='false' data-share='true'></div></div><div class='twitter-button'><a href='https://twitter.com/share' class='twitter-share-button' data-url='http://www.moco-comics.com/$link/'>Tweet</a></div><div class='google-button'><div class='g-plusone'  data-size='medium'  data-href='http://www.moco-comics.com/$link/'></div></div><div class='tumblr-button'><a class='tumblr-share-button' data-color='blue' data-notes='right' href='https://embed.tumblr.com/share' data-content='http://www.moco-comics.com/$image' data-posttype='photo'></a></div><div class='comments-button' ><a href='$link' class='link-to-post'><span class='fa fa-comment'></span>Comentarios</a></div></div></footer></article>";
        return $html;

    }

   public function getLatestPosts($init,$end){
        if($init==0){
            $init=1;
        }
        $posts=array_reverse($this->getPosts());
	 	$posts=array_slice($posts, $init, $end);
	 	return array_reverse($posts);
	}

    public function buildNonscriptNavigation(){
        $count = ceil(count($this->getPosts())/4);
        $htnav="";
        for($i=1;$i<=$count;$i++){
            $htnav.="<a class='provitional' href='page/$i/'>$i</a>";
        }
        return $htnav;
    }

    public function buildNavigation($from,$page=1){
        $posts=$this->getLatestPosts($from,4);
        $count = count($this->getPosts());
        $passed=($page*4)-4;
        $incoming=ceil($count-4) - $passed;
        $removed="<option>Los viejos primero</option>";
		$result="<div class='tools'><div class='container clearfix'><div class='select'><select><option>Los nuevos primero</option></select></div><span class='post-counter'>$count</span></div></div><div class='scrollSpy'><div class='container clearfix'><ul class='visible-posts'>";
		foreach(array_reverse($posts) as $i){
            $title_code=str_replace(" ", "-", $i["Title"]);
            $special = array("#",":","ñ",".","í","ó","ú","á","é","Í","Ó","Ú","Á","É","¡","¿","!","?",",");
            $common   = array("","","n","","i","o","u","a","e","I","O","U","A","E","","","","","");
            $title_code = str_replace($special, $common, $title_code);
            if($page==1){
                $result.="<li class='spy current'><a href='#$title_code'>".$i["Title"]."</a></li>";
            }else{
                $result.="<li class='spy current'><a href='page/$page/#$title_code'>".$i["Title"]."</a></li>";
            }



        }

        $result.="</ul><!--<button class='load-more xsd-invisible sd-l-visible'><span class='fa fa-plus'></span><span data-counter='incoming'>3</span></button>--><button class='prev'><span class='fa fa-arrow-left'></span><span data-counter='previous'>$passed</span></button><button class='next'><span data-counter='next'>$incoming</span><span class='fa fa-arrow-right'></span></button></div></div>";

        return $result;

    }

    public function getPost($url){
		$post=$this->database->select($url,"Posts","Url");
	 	return $post;
	}

    public function buildAbout(){
        $additional=$this->database->select("About","Additional","Name");
        $image= $additional["Image"];
        $title = $additional["Title"];
        $content= $additional["Content"];
        return "<img src='$image' /><h5 data-post='title'>$title</h5><p>$content</p>";
    }

	public function getImages(){
		$directory = "img/*/";
		$directory2 = "img/*/*/";
		$images = array_merge(glob("" . $directory . "*.*"),glob("" . $directory2 . "*.*"));
		$imgs = '';
		// create array
		foreach($images as $image){
			$imgs[] = "$image";
		}
		return $imgs;
	}

    public function buildComments($id){
        $comments=$this->database->query("SELECT * FROM `Comments` WHERE `Post_ID`=".$id." ORDER BY DATE(`Date`) ASC");
        $comment="";
        foreach($comments->fetchAll(PDO::FETCH_ASSOC) as $i){
            $name=$i["Name"];
            $content=$i["Content"];
            $gravatar=$i["Gravatar"];
            $ids=$i["ID"];
            $web=$i["Web"];

            if($web!=""){
                $stu="<a href='$web' target='_BLANK'><span class='user-name'>$name</span></a>";
            }else{
                $stu="<span class='user-name'>$name</span>";
            }
            if($i["Parent"]==0 || $i["Parent"]=="None"){
                $comment.="<div class='comment-wrapper'>
                            <div class='comment clearfix' data-comment-level='main' data-commenter='$name'><img class='user-avatar' src='$gravatar'>
                            <div data-comment='content'>$stu$content</div>
                            <button class='respond' data-parent='$ids'>Responder</button></div><div class='replies'>".$this->getCommentResponses($id,$ids)."</div></div>";
            }

        }

        return $comment;


    }

    public function getCommentResponses($id,$cid){
        $comments=$this->database->query("SELECT * FROM `Comments` WHERE `Post_ID`=".$id." ORDER BY DATE(`Date`) DESC");
        $comment="";
        foreach($comments->fetchAll(PDO::FETCH_ASSOC) as $j){
                $rname=$j["Name"];
                $rcontent=$j["Content"];
                $rgravatar=$j["Gravatar"];
                $id=$j["Parent"];
                $web=$j["Web"];
                if($web!=""){
                    $stu="<a href='$web' target='_BLANK'><span class='user-name'>$rname</span></a>";
                }else{
                    $stu="<span class='user-name'>$rname</span>";
                }
                if($j["Parent"]==$cid){
                    $comment.="<div class='comment clearfix' data-comment-level='second' data-commenter='$rname'>
                                <img class='user-avatar' src='$rgravatar'>
                                <div data-comment='content'>$stu$rcontent</div>
                                <button class='respond' data-parent='$id'>Responder</button></div>";
                }
        }
        return $comment;
    }

    public function buildStore(){
        $items = $this -> getStoreItems();
        $html="";
        foreach(array_reverse($items) as $i){
            $name=str_replace(" ", "-", $i["Name"]);
            $image= $i["Image"];
            $title = $i["Name"];
            $price= $i["Price"];
            $pp = $i["PayPal"];
            $html.="<input type='checkbox' class='selected-item' name='store-items[]' value='$name' id='$name' /><label class='item' for='$name'><img src='$image'/><span class='title'>$title</span><span>$$price</span>$pp</label>";
        }
        return $html;
    }

    public function newComment($post_id,$name,$mail,$parent,$content,$web){
        $raw_content=$content;
        $content="<p>$content</p>";
        date_default_timezone_set('America/Mexico_City');
        $ip=$this->security->getUserIp();
        $agent=$this->security->getUserAgent();
        $status="Unapproved";
        $id=0;
        $date = date("Y-m-d H:i:s");
        $gravatar="http://www.gravatar.com/avatar/".md5($mail);
        if($sth=$this->database->getPdo()->prepare("INSERT INTO `Comments`(`ID`, `Post_ID`, `Name`, `Mail`,`Parent`, `Content`, `Date`, `Gravatar`, `Web`, `Status`, `IP`, `Agent`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
		   if (!$sth->execute(array($id,$post_id,$name,$mail,$parent,$content,$date,$gravatar,$web,$status,$ip,$agent))) {
               return false;
			}else{
               if($mail==$this->config->admin_mail){
                   if($parent!=0 && $parent!="0"){
                        $parent_info=$this->getCommentById($parent);
                        if($parent_info["Mail"]!=$mail){
                            $response_header="$name comentó tu comentario en ".$post_info["Title"];
                            $rmail_message=$response_header." : $raw_content\n"."Puedes ver su respuesta siguiendo este link:  ".$url;
                            $this->mail->send($parent_info["Mail"],$response_header,$rmail_message,"From: Moco Comics <noreply@moco-comics.com>");
                        }
                   }
               }
               if($mail!=$this->config->admin_mail){
                    $post_info=$this->getPostById($post_id);
                    $message="$name comentó en ".$post_info["Title"];
                    $notification_message="$name ($mail) comentó en ".$post_info["Title"];
                    $url=$this->config->web_domain."".$post_info["Url"];
                    $mail_message=$message." : $raw_content\n"."Puedes ver su comentario siguiendo este link:  ".$url;
                    $this->mail->send($this->config->admin_mail,$message,$mail_message,"From: Moco Comics <noreply@moco-comics.com>");
                if($parent!=0 && $parent!="0"){
                    $parent_info=$this->getCommentById($parent);
                    if($parent_info["Mail"]!=$mail){
                        $response_header="$name comentó tu comentario en ".$post_info["Title"];
                        $rmail_message=$response_header." : $raw_content\n"."Puedes ver su respuesta siguiendo este link:  ".$url;
                        $this->mail->send($parent_info["Mail"],$response_header,$rmail_message,"From: Moco Comics <noreply@moco-comics.com>");
                    }

                }

                    if($dth=$this->database->getPdo()->prepare("INSERT INTO `Notifications`(`ID`, `Content`, `Date`, `Url`) VALUES (?, ?, ?, ?)")){
                        if (!$dth->execute(array($id, $notification_message,$date,$url))) {
                            //return false;
                        }else{
                            $dth=null;
                            $sth=null;
                            return true;
                        }
                    }
               }

                $sth=null;
				return true;
			}

		}
    }

    public function newPost($title,$content,$category,$image="",$description="",$keywords=""){
        $comments=$this->database->query("SELECT `Comic` FROM `Categories` WHERE `Name`='$category'");
        $id=0;
        $status = "Published";
        date_default_timezone_set('America/Mexico_City');
        $date = date("Y-m-d H:i:s");
        $special = array("#",":","ñ",".","í","ó","ú","á","é","Í","Ó","Ú","Á","É"," ","_");
        $common   = array("","","n","","i","o","u","a","e","I","O","U","A","E","-","-");
        $url = str_replace($special, $common, strtolower($title));
        if($comments->fetch(PDO::FETCH_ASSOC)["Comic"]=="true"){
            $url="comic/".$url;
        }
        if($sth=$this->database->getPdo()->prepare("INSERT INTO `Posts`(`ID`, `Title`, `Description`, `Keywords`, `Status`, `Date`, `Content`, `Url`, `Image`, `Category`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
		   if (!$sth->execute(array($id,$title,$description,$keywords,$status,$date,$content,$url,$image,$category))) {
               return false;
			}else{
				return true;
			}
			$sth=null;
		}
    }


    public function updatePost($id,$title,$content,$category,$image="",$description="",$keywords=""){
        $comments= $this->database->query("SELECT `Comic` FROM `Categories` WHERE `Name`='$category'");
        $special = array("#",":","ñ",".","í","ó","ú","á","é","Í","Ó","Ú","Á","É"," ","_");
        $common   = array("","","n","","i","o","u","a","e","I","O","U","A","E","-","-");
        $url = str_replace($special, $common, strtolower($title));

        if($comments->fetch(PDO::FETCH_ASSOC)["Comic"]=="true"){
            $url="comic/".$url;
        }
        if($image!=""){
            if($sth=$this->database->getPdo()->prepare("UPDATE `Posts` SET `Title`=?, `Description`=?, `Keywords`= ?, `Content`=?, `Url`=?, `Image`=?, `Category`=? WHERE ID=?")){
		   if (!$sth->execute(array($title,$description,$keywords,$content,$url,$image,$category,$id))) {
               return false;
			}else{
				return true;
			}
			$sth=null;
		}
        }else{
            if($sth=$this->database->getPdo()->prepare("UPDATE `Posts` SET `Title`=?, `Description`=?, `Keywords`= ?, `Content`=?, `Url`=?, `Category`=? WHERE ID=?")){

		   if (!$sth->execute(array($title,$description,$keywords,$content,$url,$category,$id))) {
               return false;
			}else{
				return true;
			}
			$sth=null;
		}
        }

    }

    public function newCategory($name,$color,$img){
        $cat_name=$this->text->capitalize($name);
        $dir=explode(" ", $cat_name);
        $dir_name=$dir[0];
        $id = 0;
        $comic = "true";
        if(!file_exists("img/comics/$dir_name")){
             mkdir("../img/comics/$dir_name", 0744);
        }
        if($sth=$this->database->getPdo()->prepare("INSERT INTO `Categories`(`ID`, `Name`, `Color`, `Image`, `Comic`) VALUES (?, ?, ?, ?, ?)")){
		   if (!$sth->execute(array($id,$cat_name,$color,$img,$comic))) {
               return false;
			}else{
				return true;
			}
			$sth=null;
		}
    }

    public function updateCategory($name,$color,$id,$old,$img=""){
        $cat_name=$this->text->capitalize($name);
        $dir=explode(" ", $cat_name);
        $dir_name=$dir[0];
        if($img!=""){
            if($sth=$this->database->getPdo()->prepare("UPDATE `Categories` SET `Name`=?, `Color`=?, `Image`=? WHERE ID=?")){
		   if (!$sth->execute(array($cat_name,$color,$img,$id))) {
                $sth=null;
               return false;
			}else{
                if($sth=$this->database->getPdo()->prepare("UPDATE `Posts` SET `Category`=? WHERE Category=?")){
                   if (!$sth->execute(array($cat_name,$old))) {
                        $sth=null;
                       return false;
                    }else{
                        $sth=null;
                        return true;
                    }

		      }
                $sth=null;
				return true;
			}

		  }
        }else{
            if($sth=$this->database->getPdo()->prepare("UPDATE `Categories` SET `Name`=?, `Color`=? WHERE ID=?")){
		   if (!$sth->execute(array($cat_name,$color,$id))) {
                $sth=null;
               return false;
			}else{
               if($sth=$this->database->getPdo()->prepare("UPDATE `Posts` SET `Category`=? WHERE Category=?")){
                   if (!$sth->execute(array($cat_name,$old))) {
                        $sth=null;
                       return false;
                    }else{
                        $sth=null;
                        return true;
                    }

		      }
                $sth=null;
				return true;
			}

		  }
        }

    }

    public function newImage(){


    }

    public function checkPopulation($mail,$password){
		$data=$this->database->select($mail,'Admin','Mail');

		if ($this->password->compare($password,$data["ADN"])){
			return true;
		}else{
			return false;
		}
	}

    public function getBestPost($month,$year){
           if($sth=$this->database->getPdo()->prepare("SELECT `Post_ID` , COUNT(`Post_ID`) AS `Ocurrence` FROM `Comments`  WHERE MONTH(Date) = ? AND YEAR(`Date`)=? GROUP BY `Post_ID` ORDER BY `Ocurrence` DESC LIMIT    1;")){
		   if (!$sth->execute(array($month,$year))) {
               return false;
			}else{
                $post=$sth->fetch(PDO::FETCH_ASSOC);
                if(!count($post)>0){
                    return "¡Nuevo Mes!";
                }
                if($dth=$this->database->getPdo()->prepare("SELECT `Title` FROM Posts WHERE ID = ?")){
                    if (!$dth->execute(array($post["Post_ID"]))) {
                       return false;
                    }else{
                        return $dth->fetch(PDO::FETCH_ASSOC)["Title"];
                    }
                }
			}
			$sth=null;
            $dth=null;
		}
    }

    public function getBestUser($month,$year){
        if($sth=$this->database->getPdo()->prepare("SELECT `Name`, COUNT(`Name`) AS `Ocurrence` FROM `Comments` WHERE MONTH(`Date`) = ? AND YEAR(`Date`)=?  GROUP BY `Name` ORDER BY `Ocurrence` DESC LIMIT 2;")){
		   if (!$sth->execute(array($month,$year))) {
               return false;
			}else{
                $post=$sth->fetchAll(PDO::FETCH_ASSOC);
                if(!count($post)>0){
                    return "¡Nuevo Mes!";
                }
                if($post[0]["Name"]!="Juanele"){
                    return $post[0]["Name"];
                }else{
                    return $post[1]["Name"];
                }
			}
			$sth=null;
            $dth=null;
		}
    }

    public function getTotalPosts(){
        if($sth=$this->database->getPdo()->prepare("SELECT COUNT(*) AS `Total` FROM `Posts`")){
		   if (!$sth->execute()) {
               return false;
			}else{
				return $sth->fetch(PDO::FETCH_ASSOC)["Total"];
			}
			$sth=null;
		}

    }

    public function getTotalComments(){
        if($sth=$this->database->getPdo()->prepare("SELECT COUNT(*) AS `Total` FROM `Comments`")){
		   if (!$sth->execute()) {
               return false;
			}else{
				return $sth->fetch(PDO::FETCH_ASSOC)["Total"];
			}
			$sth=null;
		}
    }

    public function getUpdateNotification(){
        if(($data=$this->updater->checkUpdates())){
            return "<div class='notification xsd12 column sd-l6' data-type='update' data-status='new'><p>La actualización ".$data["Version"]." ya esta disponible!</p></div>";
        }else{
            return "";
        }
    }

    public function getPostById($id){
        if($sth=$this->database->getPdo()->prepare("SELECT * FROM `Posts` WHERE ID = ?")){
		   if (!$sth->execute(array($id))) {
               return false;
			}else{
				return $sth->fetch(PDO::FETCH_ASSOC);
			}
			$sth=null;
		}
    }

    public function notificationSeen($id){
        if($sth=$this->database->getPdo()->prepare("UPDATE `Notifications` SET `Status`='read' WHERE ID = ?")){
		   if (!$sth->execute(array($id))) {
               $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		}
    }

    public function getNotifications(){
       if($sth=$this->database->getPdo()->prepare("SELECT * FROM `Notifications`")){
		   if (!$sth->execute()) {
               return false;
			}else{
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			$sth=null;
		}
    }

    public function buildNotifications(){
        $notifications=$this->getNotifications();
        $not="";

        foreach(array_reverse($notifications) as $i){
            $not.="<div class='notification xsd12 column sd-l6' data-status='".$i["Status"]."' data-id='".$i["ID"]."' data-url='".$i["Url"]."'<p>".$i["Content"]."</p><time datetime='".$i["Date"]."'>".$i["Date"]."</time></div>";
        }
        return $not;


    }


    public function buildCharacterForms(){
        $ch=$this->getCharacters();
        $text="";
        foreach($ch as $i){
            $name=strtolower(explode(" ", $i["Name"])[0]);
            $text.="<div class='character'>
							<form class='char' method='post'  data-character='$name' data-color='".$i["Color"]."' enctype='multipart/form-data' >
                                <input type='hidden'  name='cid' value='".$i["ID"]."'>
                                <input type='hidden'  name='old-name' value='".$i["Name"]."'>
								<div class='main-wrapper clearfix'>
									<div class='image-input'>
										<img src='img/".$i["Image"]."' />
										<div class='img-uploader'>
											<button>
												<input name='image' type='file' class='upload-img' />
											</button>
										</div>
									</div>
									<input type='text' data-char='name' name='name' value='".$i["Name"]."'>

								</div>
								<div class='form-footer'>
									<input type='hidden' name='new-color' value='".$i["Color"]."'>
									<div class='color-select'>
										<div class='absolute-select'>
											<div class='color'>
												<button class='new-color' data-color='rgb(121,188,50)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='#D5573B'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(218,98,125)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(54,133,181)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(230,175,46)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(135,80,83)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(57,169,219)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(91,140,90)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(244,116,59)'></button>
											</div>
										</div>
									</div>
									<input type='submit' value='Actualizar'>
								</div>
							</form>
						</div>";
        }
        $text.="<div class='character'>
							<form id='newchar' method='post' data-character='new' data-color='#ccc' enctype='multipart/form-data'>
								<div class='main-wrapper clearfix'>
									<div class='image-input'>
										<img src='img/image.svg' />
										<div class='img-uploader'>
											<button>
												<input name='nimage' type='file' class='upload-img' required/>
											</button>
										</div>
									</div>
									<input type='text' name='nname' data-char='name' value='Nuevo'>
								</div>
								<div class='form-footer'>
                                    <input type='hidden' name='new-color' value=''>
									<div class='color-select'>
										<div class='absolute-select'>
											<div class='color'>
												<button class='new-color' data-color='rgb(121,188,50)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='#D5573B'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(218,98,125)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(54,133,181)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(230,175,46)'></button>
											</div>
											<div class='color active'>
												<button class='new-color' data-color='rgb(135,80,83)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(57,169,219)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(91,140,90)'></button>
											</div>
											<div class='color'>
												<button class='new-color' data-color='rgb(244,116,59)'></button>
											</div>
										</div>
									</div>
									<input type='submit' value='Crear'>
								</div>
							</form>
						</div>";
        return $text;
    }

    public function buildAdminStore(){
        $html="";
        $store=$this->getStoreItems();
        foreach($store as $i){
            $html.="<div class='store-item'>
							<form class='stor' method='post' enctype='multipart/form-data'>
                                <input type='hidden'  name='sid' value='".$i["ID"]."'>

								<div class='image-input'>
									<img class='item-img' src='".$i["Image"]."'/>
									<div class='img-uploader'>
										<button>
											<input name='simage' type='file' class='upload-img' />
										</button>
									</div>
								</div>
								<div class='form-footer'>
									<input type='text' name='name' value='".$i["Name"]."'>
									<label>$
										<input type='number' name='price' value='".$i["Price"]."'>
									</label>

									<input type='text' name='pp' placeholder='Paypal Button...' value='".$i["PayPal"]."'>
									<input type='submit' value='Actualizar'>
									<button data-id='".$i["ID"]."' data-action='deletes'>Eliminar</button>
								</div>
							</form>
						</div>";
        }
        $html.="<div class='store-item' data-item='new'>
							<form id='newstor' method='post' enctype='multipart/form-data' >
								<div class='image-input'>
									<img class='item-img' src='img/image.svg'/>
									<div class='img-uploader'>
										<button>
											<input name='nsimage' type='file' class='upload-img' required/>
										</button>
									</div>
								</div>
								<div class='form-footer'>
									<input type='text' name='nname' value='Nuevo item'>
									<label>$
										<input type='number' name='nprice' value='000'>
									</label>
									<input type='text' name='pp' placeholder='Paypal Button...'>
									<input type='submit' value='Crear'>
								</div>
							</form>
						</div>
					</div>";
        return $html;

    }

    public function newStoreItem($name,$price,$img="",$pp=""){
        $cat_name=$this->text->capitalize($name);
        $id = 0;
        $img="img/store/".$img;
        if($sth=$this->database->getPdo()->prepare("INSERT INTO `Store`(`ID`,`Image`,`Price`,`Name`,`PayPal`) VALUES (?, ?, ?, ?,?)")){
		   if (!$sth->execute(array($id,$img,$price,$cat_name,$pp))) {
               return false;
			}else{
				return true;
			}
			$sth=null;
		}
    }

    public function updateStoreItem($name,$price,$iid,$pp="",$img=""){
        $cat_name=$this->text->capitalize($name);
        if($img!=""){
            $img="img/store/".$img;
            if($sth=$this->database->getPdo()->prepare("UPDATE `Store` SET `Name`=?, `Price`=?, `Image`=?, `PayPal`=? WHERE ID=?")){
		   if (!$sth->execute(array($cat_name,$price,$img,$pp,$iid))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
        }else{
            if($sth=$this->database->getPdo()->prepare("UPDATE `Store` SET `Name`=?, `Price`=?, `PayPal`=? WHERE ID=?")){
		   if (!$sth->execute(array($cat_name,$price,$pp,$iid))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
        }
    }

    public function deleteItem($table,$id){
        if($sth=$this->database->getPdo()->prepare("DELETE FROM `$table` WHERE ID=?")){
		   if (!$sth->execute(array($id))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
    }



    public function buildAdminPosts(){
        $html="";
        $posts=$this->getPosts();
        setlocale(LC_TIME, "es_MX.UTF-8","es");
        foreach(array_reverse($posts) as $i){
            $html.="<div class='post'>
							<div class='post-img'>
                            <img class='lazy' data-original='".$i["Image"]."'>
                            <noscript><img src='".$i["Image"]."' /></noscript>
							</div>
							<h5>".$i["Title"]."</h5>
							<time datetime='".$i["Date"]."'>".ucwords(strftime("%A %e de %B del %Y ",strtotime($i["Date"])))."</time>
							<div>
								<button class='post-action' data-action='edit' data-id='".$i["ID"]."'><span class='fa fa-pencil'></span></button>
								<button class='post-action' data-action='deletep' data-id='".$i["ID"]."'><span class='fa fa-trash'></span></button>
							</div>
						</div>";
        }
        return $html;
    }


    public function buildPages(){
        $html="";
        $additionals=$this->getAdditionals();
        foreach(array_reverse($additionals) as $i){
            if($i["Image"]!=""){
                $html.="<div class='page clearfix'>
							<form id='aboutform' method='post' enctype='multipart/form-data'>
								<div class='title xsd12 sd-l3' data-color='".$i["Color"]."'>
									<h5>".$i["Nombre"]."</h5>
								</div>
								<div class='content column xsd12 sd-l9 sd-loffset3'>
									<div class='image-input'>
										<img class='item-img' src='".$i["Image"]."'/>
										<div class='img-uploader'>
											<button>
												<input name='aimage' type='file' class='upload-img' />
											</button>
										</div>
									</div>
									<input type='text' name='title' value='".$i["Title"]."'/>
									<textarea name='adescription'>".$i["Content"]."</textarea>
									<input type='submit' class='about-button' data-color='".$i["Color"]."' value='Guardar'>
								</div>
							</form>
						</div>";
            }else{
               $html.="<div class='page clearfix'>
							<form class='additional-page' method='post' data-id='".$i["id"]."'>
								<div class='title xsd12 sd-l3' data-color='".$i["Color"]."'>
									<h5>".$i["Nombre"]."</h5>
								</div>
								<div class='content column xsd12 sd-l9 sd-loffset3'>
									<textarea name='description' class='store-content'>".$i["Content"]."</textarea>
                                    <input type='hidden' value='".$i["Name"]."' name='aid'>
									<input type='submit' class='store-button' data-color='".$i["Color"]."' value='Guardar' data-id='".$i["id"]."'>
								</div>
							</form>
						</div>";
            }

        }
        return $html;
    }

    public function updateAbout($title,$content,$img=""){
        $cat_name=$this->text->capitalize($title);
        if($img!=""){
            $img="img/".$img;
            if($sth=$this->database->getPdo()->prepare("UPDATE `Additional` SET `Content`=?, `Title`=?, `Image`=? WHERE id=1")){
		   if (!$sth->execute(array($content,$cat_name,$img))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
        }else{
            if($sth=$this->database->getPdo()->prepare("UPDATE `Additional` SET `Content`=?, `Title`=? WHERE id=1")){
		   if (!$sth->execute(array($content,$cat_name))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
        }
    }

    public function updateStore($content){
        $id=0;
        if($sth=$this->database->getPdo()->prepare("UPDATE `Additional` SET `Content`=? WHERE id=?")){
		   if (!$sth->execute(array($content,$id))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
    }

    public function updateAdditional($id, $content){
        if($sth=$this->database->getPdo()->prepare("UPDATE `Additional` SET `Content`=? WHERE Name=?")){
		   if (!$sth->execute(array($content, $id))) {
                $sth=null;
               return false;
			}else{
                $sth=null;
				return true;
			}

		  }
    }

    public function getPostInfo($id){
        $post= $this->getPostById($id);
        setlocale(LC_TIME, "es_MX.UTF-8","es");
        $post["Date"]=ucwords(strftime("%A %e de %B del %Y ",strtotime($post["Date"])));
        return json_encode($post);
    }

    public function cleanPost($content){
        preg_match_all('/<input[^>]/', $content, $matches);
        foreach($matches as $i){
            foreach($i as $j){
                 $content = str_replace("<input ".$j.">","",$content);
            }

        }
        return $content;
    }
	public function storeOptions(){
		$html="";
		foreach($this -> getStoreItems() as $i ){
				$html.="<option value='".$i["ID"]."'>".$i["Name"]."</option>";
		}
		return $html;
	}

	public function storeSendOptions(){
		$html="";
		foreach($this -> getStoreItems() as $i ){
			if($i["File"]!=""){
				$html.="<option value='".$i["File"]."'>".$i["Name"]."</option>";
			}
		}
		return $html;
	}

	public function sendOrder($to, $file, $message){
		$mail = new PHPMailer();
		$mail->From = 'noreply@moco-comics.com';
		$mail->FromName = 'Moco Comics';
		$mail->addAddress($to);
		$mail->addAttachment($file);
		$mail->Subject = 'Tu compra en Moco Comics!';
		$mail->Body    = $message;
		if(!$mail->send()) {
		    return false;
		} else {
		    return true;
		}

	}

    public function newOrder($name,$mail,$web,$comments){
        $id=0;
        $date = date("Y-m-d H:i:s");
        $url = "mailto:$mail";
        if($web!=""){
             $message= $name." ($web) esta interesado en comprar comics!";
        }else{
             $message= $name." esta interesado en comprar comics!";
        }
        if($comments!=""){
            $message=$message." Y dejo el siguiente mensaje: ".$comments;
        }
        $this->mail->send($this->config->admin_mail,"$name quiere Comicsh!",$message,"From: Moco Comics <noreply@moco-comics.com>");
        if($dth=$this->database->getPdo()->prepare("INSERT INTO `Notifications`(`ID`, `Content`, `Date`, `Url`) VALUES (?, ?, ?, ?)")){
                   if (!$dth->execute(array($id,$message,$date,$url))) {
                       //return false;
                    }else{
                        $dth=null;
                        $sth=null;
                        return true;
                    }

                }
    }

	function addFile($file, $in){
		if($sth=$this->database->getPdo()->prepare("UPDATE `Store` SET `File`= ? WHERE ID= ?")){
			if (!$sth->execute(array($file,$in))) {
				$sth=null;
				return false;
			}else{
				$sth=null;
				return true;
			}
		}
	}

    public function getCategoryOption(){
        $html="";
        $categories=$this->getCategories();
        foreach($categories as $i){

                $name=$i["Name"];
                $html.="<option value ='$name'>$name</option>";

        }
        return $html;
    }
    public function getFeedPosts(){
        $posts=array_reverse($this->getPosts());
	 	$posts=array_slice($posts, 0,4);
	 	return $posts;
	}
    public function buildRssFeed(){
        $feed="";
        $posts=$this->getFeedPosts();
        setlocale(LC_TIME, "es_MX.UTF-8","es");
        foreach($posts as $i){
            $i["Content"]=str_replace('<img src="','<img src="'.$this->config->web_domain,$i["Content"]);
            $len=strlen($i["Content"]);
            if($len>200){
                 $description= substr($i["Content"],0, $len/2);
            }else{
                 $description= substr($i["Content"],0, $len);
            }
            $image="<img src='".$this->config->web_domain.$i["Image"]."' alt='".$i["Title"]."'>";
            $feed.="<item>
                        <title>".$i["Title"]."</title>
                        <link>".$this->config->web_domain.$i["Url"]."</link>
                        <category>".$i["Category"]."</category>
                        <dc:creator><![CDATA[ Juanele ]]></dc:creator>
                        <pubDate>".ucwords(strftime("%A %e de %B del %Y ",strtotime($i["Date"])))."</pubDate>
                        <description><![CDATA[ ".$image.$description."... Continúa Leyendo ... ]]></description>
                        <content:encoded>
                            <![CDATA[ ".$image.$i["Content"]." ]]>
                        </content:encoded>

                    </item>";
        }
        return $feed;
    }
}

$custom=new Custom();
?>