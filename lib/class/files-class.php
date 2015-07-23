<?php
/**
 * ==============================
 * Aegis Framework | MIT License
 * http://www.aegisframework.com/
 * ==============================
 */
class Files {

		function __construct(){
            $this->allowed_extensions=[
	        	"images"=>["gif", "jpeg", "jpg", "png"],
	        	"files"=>[""]
	        ];
        }

        public function rename(){

        }

        public function getImageSize($file){
           list($width, $height, $type, $attr) = getimagesize($file);

            if($height>400){
                   return true;
            }
            return false;
        }

        public function uploadMultipleImages($file,$location,$size=2000000,$rename="",$width="",$height=""){
            for($i=0; $i<count($_FILES[$file]["name"]);$i++){
	 	    $special = array("#",":","ñ","í","ó","ú","á","é","Í","Ó","Ú","Á","É"," ");
		    $common   = array("","","n","i","o","u","a","e","I","O","U","A","E","-");
		    $_FILES[$file]["name"][$i]=str_replace($special, $common, $_FILES[$file]["name"][$i]);
		    $rename = str_replace($special, $common, $_FILES[$file]["name"][$i]);
		    //if($this->validateImage($file,$size)){
		        if ($_FILES[$file]["error"][$i] > 0){
		            //return False;
		        }else{
		            move_uploaded_file($_FILES[$file]["tmp_name"][$i], $location."/" . $_FILES[$file]["name"][$i]);
		            $shd= $_FILES[$file]["name"][$i];
		             $temp = explode(".", $_FILES[$file]["name"][$i]);
		                $extension = end($temp);
		            if ($width!="" && $height!="" ){

		                $images =  $location."/" . $_FILES[$file]["name"][$i];
		                $new_images = $_FILES[$file]["name"][$i];
		                $size=GetimageSize($images);


		                //$height=round($width*$size[1]/$size[0]);

		                if ($_FILES[$file]["type"][$i] == "image/jpeg"){
		                    $images_orig = ImageCreateFromJPEG($images);
		                }
		                if ($_FILES[$file]["type"][$i] == "image/jpg"){
		                    $images_orig = ImageCreateFromJPG($images);
		                }
		                if ($_FILES[$file]["type"][$i] == "image/png"){
		                    $images_orig = ImageCreateFromJPG($images);
		                }
		                if ($_FILES[$file]["type"][$i] == "image/gif"){
		                    $images_orig = ImageCreateFromGIF($images);
		                }

		                $photoX = ImagesX($images_orig);
		                $photoY = ImagesY($images_orig);

		                $images_fin = ImageCreateTrueColor($width, $height);
		                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
		                if ($_FILES[$file]["type"][$i] == "image/jpeg"){
		                    ImageJPEG($images_fin, $location."/".$new_images);
		                }
		                if ($_FILES[$file]["type"][$i] == "image/jpg"){
		                    ImageJPG($images_fin, $location."/".$new_images);
		                }
		                if ($_FILES[$file]["type"][$i] == "image/png"){
		                    ImagePNG($images_fin, $location."/".$new_images);
		                }
		                if ($_FILES[$file]["type"][$i] == "image/png"){
		                    ImageGIF($images_fin, $location."/".$new_images);
		                }
		                ImageDestroy($images_orig);
		                ImageDestroy($images_fin);


		                }
		        if ($rename!="" && is_null($rename)==false){
		            if ($rename!=""){
		                $fsd = basename($rename);
		                rename ($location."/".$shd , $location."/".$fsd);
		                $shd=$fsd;
		            }else{
		                rename ($location."/".$shd , $location."/".$rename.".".$extension);
		                $shd=$rename.".".$extension;
		            }
		        }

		         //return $shd;
		        }
		    //}
		}
        }

        /**
         * Check image format and size for validation.
         *
         * @access private
         * @param mixed $file
         * @param mixed $size
         * @return void
         */
        private function validateImage($file,$size){
            $temp = explode(".", $_FILES[$file]["name"]);
            $extension = end($temp);
            $shd=$_FILES[$file]["name"];
            if ((($_FILES[$file]["type"] == "image/gif")
                 || ($_FILES[$file]["type"] == "image/jpeg")
                 || ($_FILES[$file]["type"] == "image/jpg")
                 || ($_FILES[$file]["type"] == "image/pjpeg")
                 || ($_FILES[$file]["type"] == "image/x-png")
                 || ($_FILES[$file]["type"] == "image/png"))
                && ($_FILES[$file]["size"] < $size)
                && in_array($extension,  $this->allowed_extensions["images"])){

                    return true;
                }else{
                    return false;
                }
        }
		public function uploadImage($file,$location,$size=2000000,$rename="",$width="",$height=""){
            $special = array("#",":","ñ","í","ó","ú","á","é","Í","Ó","Ú","Á","É"," ");
            $common   = array("","","n","i","o","u","a","e","I","O","U","A","E","-");
            $_FILES[$file]["name"]=str_replace($special, $common, $_FILES[$file]["name"]);
            $rename = str_replace($special, $common, $_FILES[$file]["name"]);
            if($this->validateImage($file,$size)){
                if ($_FILES[$file]["error"] > 0){
                    return False;
                }else{
                    move_uploaded_file($_FILES[$file]["tmp_name"], $location."/" . $_FILES[$file]["name"]);
                    $shd= $_FILES[$file]["name"];
                     $temp = explode(".", $_FILES[$file]["name"]);
                        $extension = end($temp);
                    if ($width!="" && $height!="" ){

                        $images =  $location."/" . $_FILES[$file]["name"];
                        $new_images = $_FILES[$file]["name"];
                        $size=GetimageSize($images);


                        //$height=round($width*$size[1]/$size[0]);

                        if ($_FILES[$file]["type"] == "image/jpeg"){
                            $images_orig = ImageCreateFromJPEG($images);
                        }
                        if ($_FILES[$file]["type"] == "image/jpg"){
                            $images_orig = ImageCreateFromJPG($images);
                        }
                        if ($_FILES[$file]["type"] == "image/png"){
                            $images_orig = ImageCreateFromJPG($images);
                        }
                        if ($_FILES[$file]["type"] == "image/gif"){
                            $images_orig = ImageCreateFromGIF($images);
                        }

                        $photoX = ImagesX($images_orig);
                        $photoY = ImagesY($images_orig);

                        $images_fin = ImageCreateTrueColor($width, $height);
                        ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
                        if ($_FILES[$file]["type"] == "image/jpeg"){
                            ImageJPEG($images_fin, $location."/".$new_images);
                        }
                        if ($_FILES[$file]["type"] == "image/jpg"){
                            ImageJPG($images_fin, $location."/".$new_images);
                        }
                        if ($_FILES[$file]["type"] == "image/png"){
                            ImagePNG($images_fin, $location."/".$new_images);
                        }
                        if ($_FILES[$file]["type"] == "image/png"){
                            ImageGIF($images_fin, $location."/".$new_images);
                        }
                        ImageDestroy($images_orig);
                        ImageDestroy($images_fin);


                        }
                if ($rename!="" && is_null($rename)==false){
                    if ($rename!=""){
                        $fsd = basename($rename);
                        rename ($location."/".$shd , $location."/".$fsd);
                        $shd=$fsd;
                    }else{
                        rename ($location."/".$shd , $location."/".$rename.".".$extension);
                        $shd=$rename.".".$extension;
                    }
                }

                 return $shd;
                }
            }
        }

        public function uploadFile($file, $location, $size = 100000000){
			$special = array("#",":","ñ","í","ó","ú","á","é","Í","Ó","Ú","Á","É"," ","_");
			$common   = array("","","n","i","o","u","a","e","I","O","U","A","E","-","-");
			$_FILES[$file]["name"] = str_replace($special, $common, $_FILES[$file]["name"]);
				$target_file = $location .$_FILES[$file]["name"];

				if ($_FILES[$file]["size"] > $size) {
				    return false;
				}
				if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
			     	return $_FILES[$file]["name"];
			    } else {
			        return false;
			    }
		}

		function __destruct() {

        }

    }

?>