$(document).ready(function(){
    $('a[href*=#]').each(function(){
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
    
    $('a.mailto').mailto();
    
    var newPostForm= $('.new-comment');
    var newPostButton= $('.add-comment span');
    
   	$('.add-comment, .respond').click(function(){
	   	if(!newPostForm.hasClass("active")){
	   		newPostForm.addClass("active");
	   		newPostButton.attr("class", "fa fa-close");
	   	}else{
		   	newPostForm.removeClass("active");
		   	newPostButton.attr("class", "fa fa-plus");
	   	}
   	})    
    
   $(".respond").click(function(){
            $("input[name='rep']").val($(this).data('parent'));
    });
    var ht=$("#Commenter").html();
    
    $("#Commenter").submit(function(event) {
	 	event.preventDefault();
		$.ajax({ type: "POST", url: "lib/deploy.php", data: $("#Commenter").serialize(),
            success: function(data){
                    if(data.trim()=="Graciash por tu comentario!"){
                        $("input[name='rep']").val(0);
                        $("#cFail").hide();
                        $("#Commenter").html(data);
                    }else{
                        $("#cFail").show();
                    }
				}
		});
		return false;
    });
});