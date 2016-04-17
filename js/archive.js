$(document).ready(function(){

    //Smooth scroll links in page.

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
    //$('img').absoluteImage();

   	$('.archive nav a').each(function(){
	   	var color = $(this).data('color');
	   	$(this).css({background: color});
   	})

   	var displaying= "Patote";

   	function changeComics(character){
	   $('[data-character-link="' + character + '"]').addClass('active');
	   $('[data-character="' + character + '"]').addClass('active');
   	}

   	changeComics(displaying);

   	$('.character-link').click(function(){
	   	var newC= $(this).data('character-link');
	   	if(newC != displaying){
		   $('[data-character-link="' + displaying + '"]').removeClass('active');
		   $('[data-character="' + displaying + '"]').removeClass('active');

		   changeComics(newC);
		   displaying=newC;
	   	}
   	})

    $("#store").submit(function(event) {
	 	event.preventDefault();
		$.ajax({ type: "POST", url: "lib/deploy.php", data: $("#store").serialize(),
				success: function(data){
                    $("#store").trigger('reset');
                    $("#store input[type='submit']").val("Graciash!");
				}
		});
		return false;
    });

    $(function() {
        $(".lazy").lazyload();
    });

});