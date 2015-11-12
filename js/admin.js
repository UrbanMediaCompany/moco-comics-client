$(document).ready(function () {
    /**
     * Smooth scroll links in page.
     */
    $('a[href*=#]').each(function () {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
	        && location.hostname == this.hostname
	        && this.hash.replace(/#/,'') ) {
                var $targetId = $(this.hash), $targetAnchor = $('[name=' + this.hash.slice(1) +']');
				var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;
				if($target){
                    var targetOffset = $target.offset().top;
                    $(this).click(function() {
                    $('html, body').animate({scrollTop: targetOffset}, 1200);
                        return false;
                    });
				}
            }
    });

    $('.new-post').on("change",'.staged',function(){
	    if (this.files && this.files[0]) {

		    var reader = new FileReader();
            var name =this.files[0].name;
            reader.onload = function(e){
	            $('[data-post="content"]').append("<img alt='new-image' src='" + e.target.result + "' data-name='"+name+"' class='medium lazy' data-post='img'/>");
            }
            reader.readAsDataURL(this.files[0]);
            $(this).clone().appendTo(".img-receiver-input");
			$("div[data-post='inputs']").append($(this));
            $('[data-post="inputs"] .staged').removeClass("staged");
			$('.img-receiver').removeClass("active");
			$('.staged').removeClass("error");
			$('.staged').val("");
        }

    });

    $('a.mailto').mailto();
    $(function() {
        $(".lazy").lazyload();
    });
    $('.video-wrapper').fitVids();

    $('[data-color]').each(function(){
        var color = $(this).data('color');
        $(this).css({background: color});
    });

    var navActive = "notifications";
    $('[data-nav]').click(function(){
	    var clicked = $(this).data("nav");
	    if(clicked != navActive){
		    $('[data-nav="' + navActive + '"]').removeClass("active");
		    $()
	    }
    });

    var displaying= "notifications";

   	function changeSection(section){
	   $('[data-nav="' + section + '"]').addClass('active');
	   $('[data-site="' + section + '"]').addClass('active');
    }

    changeSection(displaying);

   	$('[data-nav]').click(function(){
	   	var newS= $(this).data('nav');
	   	if(newS != displaying){
		   $('[data-nav="' + displaying + '"]').removeClass('active');
		   $('[data-site="' + displaying + '"]').removeClass('active');
		   changeSection(newS);
		   displaying=newS;
	   	}
   	})


   	$(".characters-wrapper").on("click",".new-color",function(event){
	   	event.preventDefault();
	   	if ( !$(this).parent().hasClass("active") ){
		   	var button= $(this);
		   	var color= button.data("color");
		   	var character= button.closest("[data-character]");
		   	var current= character.find(".active");
		   	var parent = button.parent();
		   	var input= character.find("[name='new-color']");

		   	character.css({background: color});
		   	current.removeClass("active");
		   	parent.addClass("active");
		   	input.attr("value", color);
	   	}
   	})

   	$('.characters-wrapper [data-character]').each(function(){
	   	var active= $(this).css("background-color");
	   	$(this).find('.color').each(function(index){
		   	var children= $(this).find('.new-color');
		   	var children_color= children.css("background-color");
		   	if(active==children_color){
			   	$(this).addClass("active");
		   	}
	   	})
   	})

   	function readURL(input) {
	   	var imageParent = $(input).closest(".image-input");
	   	var image = $(imageParent).find("img");


        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                image.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("section").on("change",".upload-img",function(){
        readURL(this);
    });

    $(".upload-img").change(function(){
        readURL(this);
    });

    $(".posts-wrapper").on("click","[data-action='edit']",function(){

        $.ajax({ type: "POST", url: "lib/deploy.php",data: {"postinfo":$(this).data("id")},dataType:"json",
				success: function(data){
                    $("[data-post='image-preview']").attr("src", data["Image"]);
                    $("[data-post='content']").html(data["Content"]);
                    $("[name='post-title']").val(data["Title"]);
                    $("[name='post-id']").val(data["ID"]);
                    $("[data-post='date']").text(data["Date"]);
                    $("[data-post='date']").attr("datetime", data["Date"]);
                    $("[name='post-category']").val(data["Category"]);
                    $(".image-preview").attr("src", data["Image"]);

                    $(".new-post").hasClass("active") ? $(".new-post").removeClass("active") : $(".new-post").addClass("active");
				}
		});

        return false;
    });

    $("input[name='new-color']").each(function(){
        $(this).closest(".color-select").closest(".absolute-select").addClass("stuffs");
        $(this).closest(".color-select").closest(".absolute-select").find(".new-color[data-color="+$(this).val()+"]").addClass("active");
    });

    $(".post-class").on("submit","#createpost",function(event) {
        event.preventDefault();
        $("[alt='new-image']").each(function(){
            var newName="img/Posts/"+$(this).data("name").replace(/[#:íóúáéÍÓÚÁÉ]/g, "").replace(/[ñÑ]/,"n").replace(/[ _]/g,"-");
            $(this).attr("src",newName);
            $(this).attr("alt",$(this).data("name"));
        });
        var formData= new FormData(this);
        formData.append('post-content', $("[data-post='content']").html());
        $.ajax({ type: "POST", data: formData,
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                $("[data-post='image-preview']").attr("src", "");
                $("[data-post='content']").html("");
                $("[name='post-title']").val("");
                $("[name='post-id']").val(0);
                $("[data-post='date']").text("");
                $("[data-post='date']").attr("datetime", "");
                $("[name='post-category']").val("Random");
                $(".image-preview").attr("src", "img/admin/upload.png");
                $("div[data-post='inputs']").html("");

                    $(".new-post").hasClass("active") ? $(".new-post").removeClass("active") : $(".new-post").addClass("active");
                $(".posts-wrapper").html(data);

            }
        });
        return false;
    });
    $(".get-support").click(function(){
        window.location.replace("mailto:soporte@codify.mx");
    });

    $(".logout").click(function(){
        window.location.replace("logout.php");
    });

    $("#sendpost").click(function(){
        $("#createpost").submit();
    });
    $(".notification-wrapper").on("click","[data-type='update']",function(){
        $.ajax({ type: "POST", data: {"get-updates":"GO"},
            url: "lib/deploy.php",
            dataType:"json",
            success: function(data){

                $("[data-update='title']").text(data["Title"]);
                $("[data-update='details']").text("Actualización "+data["Version"] + " Hash: " + data["Hash"]);
                $("[data-update='description']").text(data["Description"]);
                var feat=data["Features"].split(",");
                var feats="";
                for(var i=0;i<feat.length;i++){

                        feats+="<li>"+feat[i]+"</li>";


                }
                $("[data-update='features']").html(feats);
                $(".update-info").addClass("active");
            }
        });
        return false;
    });


    $("[data-update='install']").click(function(){
        $.ajax({ type: "POST", data: {"install":"update"},
            url: "lib/deploy.php",
            success: function(data){
                if(data.trim()=="Installed"){
                    location.reload();
                }else{
                    alert("Ha ocurrido un error.");
                }

            }
        });
        return false;
    });




    $("#cancelpost").click(function(){
         $("[data-post='image-preview']").attr("src", "img/admin/upload.png");
                $("[data-post='content']").html("");
                $("[name='post-title']").val("");
                $("[name='post-id']").val(0);
                $("[data-post='date']").text("");
                $("[data-post='date']").attr("datetime", "");
                $("[name='post-category']").val("Random");
                $(".image-preview").attr("src", "");
                $("div[data-post='inputs']").html("");

    });
    /*=======================================================================*/

    $(".items-wrapper").on("submit",".stor",function(event) {
        event.preventDefault();
        $.ajax({ type: "POST", data: new FormData(this),
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                $(this).find("input[type='submit']").val("Actualizado");
                $(".items-wrapper").html(data);

            }
        });
        return false;
    });

    $(".items-wrapper").on("submit","#newstor",function(event) {
        event.preventDefault();
        $.ajax({ type: "POST", data: new FormData(this),
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                $(".items-wrapper").html(data);
            }
        });
        return false;
    });

    $(".characters-wrapper").on("submit",".char",function(event) {
        event.preventDefault();
        $.ajax({ type: "POST", data: new FormData(this),
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                $(".characters-wrapper").html(data);
                $('[data-color]').each(function(){
                    var color = $(this).data('color');
                    $(this).css({background: color});
   	            });
                $('.characters-wrapper [data-character]').each(function(){
                    var active= $(this).css("background-color");
                    $(this).find('.color').each(function(index){
                        var children= $(this).find('.new-color');
                        var children_color= children.css("background-color");
                        if(active==children_color){
                            $(this).addClass("active");
                        }
                    })
                })
                $(this).find("input[type='submit']").text("Actualizado");
            }
        });
        return false;
    });

    $(".characters-wrapper").on("submit","#newchar",function(event) {
        event.preventDefault();
        $.ajax({ type: "POST", data: new FormData(this),
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                $(".characters-wrapper").html(data);
                $('[data-color]').each(function(){
                    var color = $(this).data('color');
                    $(this).css({background: color});
   	            });
                $('.characters-wrapper [data-character]').each(function(){
                    var active= $(this).css("background-color");
                    $(this).find('.color').each(function(index){
                        var children= $(this).find('.new-color');
                        var children_color= children.css("background-color");
                        if(active==children_color){
                            $(this).addClass("active");
                        }
                    })
                })
            }
        });
        return false;
    });

    $(".double form").submit(function(event) {
        event.preventDefault();
        $.ajax({ type: "POST", data: new FormData(this),
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
	            if(data.trim() != "error" && data.trim() != ""){
					$(".double form").each(function(){
	            		this.reset();
            		});
            		$("#so").html(data);
					}

            }

        });
        return false;
    });

    $(".items-wrapper").on("click","[data-action='deletes']",function(){
        if(confirm("¿Seguro que quieres eliminar este producto?")){
              $.ajax({ type: "POST", url: "lib/deploy.php",data: {"DelStore":$(this).data("id")},
				success: function(data){

					$(".items-wrapper").html(data);
				}
		      });

            $(this).hide();
            return false;
         }else{

         }

    });

    $(".posts-wrapper").on("click","[data-action='deletep']",function(){
        if(confirm("¿Seguro que quieres eliminar este post?")){
            $.ajax({ type: "POST", url: "lib/deploy.php",data: {"DelPost":$(this).data("id")},
                    success: function(data){
                        $(".posts-wrapper").html(data);
                    }
            });
            $(this).text("Eliminado");
            return false;
        }
    });

    $(".notification-wrapper").on("click",".notification",function(){
        var ur= $(this).data("url");
        var di = $(this).data("id");
        $(this).data("status","read");
        if(di){
            $.ajax({ type: "POST", url: "lib/deploy.php", data: {"Notifiying":di},
				success: function(data){
                    if(ur){
                        window.open(ur);
                    }

                    $(".notification-wrapper").html(data);
				}
		});
        }

		return false;
    });



    $(".pages-wrapper").on("submit",".additional-page",function(event) {
	 	event.preventDefault();
        	var temp = $(this);
        	var da = temp.find("textarea");
        	if(da.val().trim() == ""){
        		da.val("[EMPTY]");
        	}
		$.ajax({ type: "POST", url: "lib/deploy.php", data: temp.serialize(),
				success: function(data){
                    $(".pages-wrapper").html(data.trim());
                    $(".store-button[data-id='"+temp.data("id")+"']").val("Guardado!");
                    $('[data-color]').each(function(){
                        var color = $(this).data('color');
                        $(this).css({background: color});
                    });
				}
		});
		return false;
    });

    $(".pages-wrapper").on("submit","#aboutform",function(event) {
        event.preventDefault();
        $.ajax({ type: "POST", data: new FormData(this),
            url: "lib/deploy.php",
            processData: false,
            contentType: false,
            cache: false,
            success: function(data){
                $(".pages-wrapper").html(data);
                $('[data-color]').each(function(){
                    var color = $(this).data('color');
                    $(this).css({background: color});
                });
                $(".about-button").val("Guardado!");
            }
        });
        return false;
    });

   	$('.add-post, button.cancel').click(function(){
	   	$(".modal-window.new-post").hasClass("active") ? $(".modal-window.new-post").removeClass("active") : $(".modal-window.new-post").addClass("active")
        $("[data-post='image-preview']").attr("src", "img/admin/upload.png");
                $("[data-post='content']").html("");
                $("[name='post-title']").val("");
                $("[name='post-id']").val(0);
                $("[data-post='date']").text("");
                $("[data-post='date']").attr("datetime", "");
                $("[name='post-category']").val("Random");
                $(".image-preview").attr("src", "");
                $("div[data-post='inputs']").html("");
   	})

   	$('.modal-window:not(.new-post) button.cancel').click(function(){
	   	$(".modal-window").hasClass("active") ? $(".modal-window").removeClass("active") : $(".modal-window").addClass("active")
   	})

   	$('.tools button').click(function(event){
	    event.preventDefault();
	    var this_function=$(this).attr('data-edit');
	    var this_editor= $('[contenteditable="true"]');
		this_editor.focus();
	    editorFunction(this_function, this_editor);
    })

    $('.close-url').click(function(){
	    $('.url-receiver').removeClass("active");
	    $('#url-pass').removeClass("error");
		$('#url-pass').val("");
    })
    $('.close-img').click(function(){
	    $('.img-receiver').removeClass("active");
	    $('.staged').removeClass("error");
		$('.staged').val("");
    })

    function editorFunction(this_function, this_editor){
	    switch (this_function){
		    case "bold":

		    	document.execCommand("bold", "false", "null");
		    	break;

		    case "italic":

		    	document.execCommand("italic", "false", "null");
		    	break;

		    case "underline":

		    	document.execCommand("underline", "false", "null");
		    	break;

		    case "font":

		    	document.execCommand("fontName", false, "Arial");
		    	break;

		    case "link":

		    	$('.url-receiver').addClass("active");
		    	$('#url-pass').focus();
		    	$('.accept-url').click(function(){
			    	uri= $('#url-pass').val();
			    	var RegExp= /^(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
			    	if(RegExp.test(uri)){
				    	document.execCommand("createLink", "false", uri);
				    	$('.url-receiver').removeClass("active");
				    	$('#url-pass').removeClass("error");
				    	$('#url-pass').val("");
			    	}else{
				    	$('#url-pass').addClass("error");
			    	}
		    	})
		    	break;

		    case "img":
				$('.img-receiver').addClass("active");

		    	break;

		    case "video":
		    	$('.video-receiver').addClass("active");
		    	$('.accept-video').click(function(){
					var this_data= $('#video-pass').val();
					$('[data-post="content"]').append("<div class='video-wrapper'>" + this_data + "</div><br>");
					$('.video-receiver').removeClass("active");
				    $('#video-pass').removeClass("error");
				    $('#video-pass').val("");
				})

		    	break;
		    default:
		    	break;
	    }
    }



    function magic(){
        $("[alt='new-image']").each(function(){
            $(this).attr("src",$(this).data("name"));
        });
    }

    $(document).on("keydown", function (e) {
        if (e.which === 8 && !$(e.target).is("input, textarea,[contenteditable]")) {
            e.preventDefault();
        }
    });

});
