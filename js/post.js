$(document).ready(function(){
    $('a[href*="#"]').each(function(){
	    if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
	        && location.hostname == this.hostname
	        && this.hash.replace(/#/,'') ) {
                var $targetId = $(this.hash), $targetAnchor = $('[name=' + this.hash.slice(1) +']');
				var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;
				if($target){
                    var targetOffset = $target.offset().top;
                    $(this).click(function() {
                    $('html, body').animate({scrollTop: targetOffset}, 1000);
                        return false;
                    });
				}
            }
    });

    //$('a.mailto').mailto();

    var newPostForm= $('.new-comment');
    var newPostButton= $('.add-comment span');

   	$('.add-comment').click(function(){
	   	if(!newPostForm.hasClass("active")){
	   		newPostForm.addClass("active");
	   		newPostButton.attr("class", "fa fa-close");
	   	}else{
		   	newPostForm.removeClass("active");
		   	newPostButton.attr("class", "fa fa-plus");
	   	}
   	})

   $(".comments-wrapper").on("click", ".respond", function(){
	   	if(!newPostForm.hasClass("active")){
	   		newPostForm.addClass("active");
	   		newPostButton.attr("class", "fa fa-close");
	   	}else{
		   	newPostForm.removeClass("active");
		   	newPostButton.attr("class", "fa fa-plus");
	   	}
        $("input[name='rep']").val($(this).data('parent'));
    });

    $("#Commenter").submit(function(event) {
	 	event.preventDefault();
		$.ajax({ type: "POST", url: "deploy.php", data: $("#Commenter").serialize(),
            success: function(data){
                    if(data.trim() != ""){

                        $("input[name='rep']").val("None");
                        $("input[name='web']").val("");
                        $("input[name='email']").val("");
                        $("input[name='name']").val("");
						$("textarea[name='comment']").val("");
                        $("#cFail").hide();
                        $(".comments-wrapper").html(data);
                    	newPostForm.removeClass("active");
						newPostButton.attr("class", "fa fa-plus");
                    }else{
                        $("#cFail").show();
                    }
				}
		});
		return false;
    });
});