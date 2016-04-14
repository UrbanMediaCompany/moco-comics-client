$_ready(function(){

    $_(".nav .menu-icon").click(function(){
		$_(this).parent().find("ul").toggleClass("active");
		$_(this).toggleClass('fa-bars fa-times');
	});

	$_(".nav li").click(function(){
	    if($_(".menu-icon").isVisible()){
	      $_(".menu-icon").toggleClass('fa-bars fa-times');
	      $_(this).parent().parent().find("ul").toggleClass("active");
	    }
	});


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

    (function(){
	$_(".mailto").each(function(element){
		console.log(element);
		var email = element.href.replace("(at)", "@").replace("(dot)", ".");
		var classes = $_(element).attribute("class");

		element.insertAdjacentHTML('beforebegin', '<a href="mailto:' + email
							+ '" class="' + classes + '"  title="Email ' + email
							+ '"">'+$_(element).html() + '</a>');
							element.parentNode.removeChild(element);


	});

})();

    $('.video-wrapper').fitVids();

    var articleTops = [];

    function getArticleTop(){
	    $('.blog article').each(function(index){
		    articleTops[index]= $(this).offset().top - 100;
	    })
    }

	getArticleTop();

    var stickyNav= $('.sd-l-aside-wrapper');
    var stickyNavHeight;

    var blogSection= $('.blog');
    var blogSectionHeight;
    var blogSectionTop;

    var stickyMaxScroll;
    var stickyNavTop;

    $(window).scroll(function(){
	    var scrolled= $(window).scrollTop();

	    stickyNavHeight= stickyNav.height();
	    blogSectionHeight= blogSection.outerHeight();
	    stickyMaxScroll= blogSectionHeight - stickyNavHeight + blogSectionTop;
	    blogSectionTop= blogSection.offset().top

	    if(scrolled < blogSectionTop + 50){
		    stickyNavTop= blogSectionTop - scrolled + 50;
	    }else{
		    if(stickyMaxScroll -100 > scrolled){
			    stickyNavTop= 0;
		    }else{
			    stickyNavTop= stickyMaxScroll - scrolled -100;
		    }
	    }
	    stickyNav.css({top : stickyNavTop});

	    if(scrolled < articleTops[1]){
		    //console.log(scrolled, articleTops);
		    $('.spy.current').removeClass('current');
		    $('.spy:first-child').addClass('current');
	    }else if(scrolled < articleTops[2]){
	    	$('.spy.current').removeClass('current');
		    $('.spy:nth-child(2)').addClass('current');
	    }else if(scrolled < articleTops[3]){
	    	$('.spy.current').removeClass('current');
		    $('.spy:nth-child(3)').addClass('current');
	    }else if(scrolled >= articleTops[3]){
			$('.spy.current').removeClass('current');
		    $('.spy:last-child').addClass('current');
		}
    });

    $(window).resize(function(){
	    getArticleTop();
    });

    $('button.prev').click(function(){
	    if($('.mobile-donation').is(":visible")){
		    if($('.prev span').text()=='0'){

            }else{
                if($('.prev span').text()=='4'){
                    window.location.href = '/#blog';
                }else{
                    window.location.href = 'page/'+(parseInt($('.prev span').text()))/4+"/#blog";
                }

            }
	    }else{
            if($('.prev span').text()=='0'){

            }else{
               if($('.prev span').text()=='4'){
                    window.location.href = '/#blog';
                }else{
                    window.location.href = 'page/'+(parseInt($('.prev span').text()))/4+"/#blog";
                }
            }
	    }
    });

    $('button.next').click(function(){
	    if($('.mobile-donation').is(":visible")){
		    if($('.prev span').text()=='0'){
                window.location.href = 'page/2'+"/#blog";
            }else{
                window.location.href = 'page/'+(parseInt($('.prev span').text())+8)/4+"/#blog";
            }
	    }else{
		    if($('.prev span').text()=='0'){
                window.location.href = 'page/2'+"/#blog";
            }else{
                window.location.href = 'page/'+(parseInt($('.prev span').text())+8)/4+"/#blog";
            }
	    }
    });

});