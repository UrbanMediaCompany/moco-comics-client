<?php

	include_once("custom-class.php");
    $_->session->start();

	if(($data=$_->readPost("cuco,name,email,comment,rep"))){
        if($data["rep"]=="None"){
            $data["rep"]=0;
        }
        $data["web"]=$_->security->secureData(@$_POST["web"]);
		if($custom->newComment($data["cuco"],$data["name"],$data["email"],$data["rep"],$data["comment"],$data["web"])){
             echo "Graciash por tu comentario!";
        }else{
            echo "Tu comentario no ha sido enviado.";
        }
	}

    if($data=$_->readPost("user,password")){
		if($custom->checkPopulation($data["user"],$data["password"])){
			$_SESSION['active']=true;
		}
	}

    if($data=$_->readPost("install")){
        if($custom->updater->install()){
           echo "Installed";
        }
    }

    if($data=$_->readPost("Notifiying")){
		if($custom->notificationSeen($data["Notifiying"])){
            echo  $custom->getUpdateNotification()."".$custom->buildNotifications();
		}else{
            echo  $custom->getUpdateNotification()."".$custom->buildNotifications();
        }
	}

    if($data=$_->readPost("get-updates")){
        echo json_encode($_->updater->checkUpdates());
    }

    if(($data=$_->readPost("DelPost")) && $_SESSION['active']){
		if($custom->deleteItem("Posts",$data["DelPost"])){
            echo $custom->buildAdminPosts();
		}else{
             echo $custom->buildAdminPosts();
        }
	}

    if(($data=$_->readPost("DelStore")) && $_SESSION['active']){
		if($custom->deleteItem("Store",$data["DelStore"])){
            echo $custom->buildAdminStore();
		}else{
            echo $custom->buildAdminStore();
        }
	}

    if(($data=$_->readPost("description")) && $_SESSION['active']){
        if($custom->updateStore($data["description"])){
            echo $custom->getAdditionalData("Store Description");
        }else{
            echo $custom->getAdditionalData("Store Description");
        }
	}

    if(($data=$_->readPost("nname,nprice")) && $_SESSION['active']){
	    $data["pp"] = $_POST["pp"];
        if(($nsiname=$_->files->uploadImage("nsimage","../img/store"))){
            if($custom->newStoreItem($data["nname"],$data["nprice"],$nsiname,$data["pp"])){
                echo $custom->buildAdminStore();
            }else{
                 echo $custom->buildAdminStore();
            }
        }
	}

    if(($data=$_->readPost("name,price,sid")) && $_SESSION['active']){
	    $data["pp"] = $_POST["pp"];
        if($_FILES["simage"]["name"]!=""){
            if(($siname=$_->files->uploadImage("simage","../img/store"))){
                if($custom->updateStoreItem($data["name"],$data["price"],$data["sid"],$data["pp"],$siname)){
                     echo $custom->buildAdminStore();
                }else{
                     echo $custom->buildAdminStore();
                }
            }
        }else{
            if($custom->updateStoreItem($data["name"],$data["price"],$data["sid"],$data["pp"])){
                 echo $custom->buildAdminStore();
            }else{
                   echo $custom->buildAdminStore();
            }
        }
	}

    if(($data=$_->readPost("nname,new-color")) && $_SESSION['active']){
        if(($niname=$_->files->uploadImage("nimage","../img"))){
            if($custom->newCategory($data["nname"],$data["new-color"],$niname)){
                echo $custom->buildCharacterForms();
            }else{
                  echo $custom->buildCharacterForms();
            }
        }
	}

    if(($data=$_->readPost("name,new-color,cid,old-name")) && $_SESSION['active']){
        if($_FILES["image"]["name"]!=""){
            if(($iname=$_->files->uploadImage("image","../img"))){
                if($custom->updateCategory($data["name"],$data["new-color"],$data["cid"],$data["old-name"],$iname)){
                    echo $custom->buildCharacterForms();
                }else{
                }
            }
        }else{
            if($custom->updateCategory($data["name"],$data["new-color"],$data["cid"],$data["old-name"])){
                echo $custom->buildCharacterForms();
            }else{

            }
        }
	}

    if(($data=$_->readPost("title,adescription")) && $_SESSION['active']){
        if($_FILES["aimage"]["name"]!=""){
            if(($ainame=$_->files->uploadImage("aimage","../img"))){
                if($custom->updateAbout($data["title"],$data["adescription"],$ainame)){
                    echo $custom->buildPages();
                }else{
                       echo $custom->buildPages();
                }
            }
        }else{
            if($custom->updateAbout($data["title"],$data["adescription"])){
                echo $custom->buildPages();
            }else{
                  echo $custom->buildPages();
            }
        }
	}

    if($data=$_->readPost("postinfo")){
        echo $custom->getPostInfo($data["postinfo"]);
    }

    if(($data=$_->readPost("post-title,post-category")) && $_SESSION['active']){
        $data["post-content"]=$_POST["post-content"];
		if(@count($_FILES["img-pass"]["name"])>0){
                $_->files->uploadMultipleImages("img-pass","../img/Posts");
        }

        $data["post-id"]=$_POST["post-id"];
        if($data["post-id"]=="0"){
            if($data["post-category"]=="Random"){
                if($_FILES["image-input"]["name"]!=""){
                    if(($ainame=$_->files->uploadImage("image-input","../img/Posts"))){
                        $ainame="img/Posts/".$ainame;
                        if($custom->newPost($data["post-title"],$data["post-content"],$data["post-category"],$ainame)){
                             echo $custom->buildAdminPosts();
                        }else{
                            echo $custom->buildAdminPosts();
                        }
                    }
                }else{
                    if($custom->newPost($data["post-title"],$data["post-content"],$data["post-category"])){
                         echo $custom->buildAdminPosts();
                    }else{
                        echo $custom->buildAdminPosts();
                    }
                }
            }else{
                if($_FILES["image-input"]["name"]!=""){
                    $cat_name=$custom->text->capitalize($category);
                    $dir=explode(" ", $cat_name);
                    $dir_name=$dir[0];
                    if(($ainame=$_->files->uploadImage("image-input","../img/comics/$dir_name"))){
                        $ainame="img/comics/$dir_name/".$ainame;
                        if($custom->newPost($data["post-title"],$data["post-content"],$data["post-category"],$ainame)){
                             echo $custom->buildAdminPosts();
                        }else{
                            echo $custom->buildAdminPosts();
                        }
                    }
                }else{
                    if($custom->newPost($data["post-title"],$data["post-content"],$data["post-category"])){
                         echo $custom->buildAdminPosts();
                    }else{
                        echo $custom->buildAdminPosts();
                    }
                }
            }

        }else{

            if($data["post-category"]=="Random"){
                if($_FILES["image-input"]["name"]!=""){

                    if(($ainame=$_->files->uploadImage("image-input","../img/Posts"))){
                        $ainame="img/Posts/".$ainame;
                        if($custom->updatePost($data["post-id"],$data["post-title"],$data["post-content"],$data["post-category"],$ainame)){
                            echo $custom->buildAdminPosts();
                        }else{
                            echo $custom->buildAdminPosts();
                        }
                    }
                }else{

                    if($custom->updatePost($data["post-id"],$data["post-title"],$data["post-content"],$data["post-category"])){
                        echo $custom->buildAdminPosts();
                    }else{
                        echo "no";
                        echo $custom->buildAdminPosts();
                    }
                }
            }else{
                if($_FILES["image-input"]["name"]!=""){
                    $cat_name=$custom->text->capitalize($category);
                    $dir=explode(" ", $cat_name);
                    $dir_name=$dir[0];
                    if(($ainame=$_->files->uploadImage("image-input","../img/comics/$dir_name"))){
                        $ainame="img/comics/$dir_name/".$ainame;
                        if($custom->updatePost($data["post-id"],$data["post-title"],$data["post-content"],$data["post-category"],$ainame)){
                            echo $custom->buildAdminPosts();
                        }else{
                            echo $custom->buildAdminPosts();
                        }
                    }
                }else{
                    if($custom->updatePost($data["post-id"],$data["post-title"],$data["post-content"],$data["post-category"])){
                        echo $custom->buildAdminPosts();
                    }else{
                        echo $custom->buildAdminPosts();
                    }
                }
            }

        }

	}

	if($data=$_->readPost("belong")){
		$file = $custom -> files -> uploadFile("pdf", "uploads/", 1000000000);
		if($custom -> addFile($file, $data["belong"])){
			echo $custom -> storeSendOptions();
		}else{
			echo "error";
		}
	}

	if($data = $_->readPost("smessage,sitem,smail")){
		if($custom -> sendOrder($data["smail"], "uploads/".$data["sitem"], $data["smessage"])){
			echo $custom -> storeSendOptions();
		}else{
			echo("error");
		}
	}

	if($data=$_->readPost("nombre,mail")){
        $data["web"]=$_POST["web"];
        $data["comments"]=$_POST["comments"];
        if(count($items)>0){
            $items_string="";
            foreach($items as $i){
                $items_string.=$i." ";
            }
            if($custom->newOrder($data["nombre"],$data["mail"],$data["web"],$data["comments"],$items_string)){

            }else{

            }
        }

	}

	if($data=$_->readPost("getSendOptions")){
		echo $custom -> storeSendOptions();
	}
?>