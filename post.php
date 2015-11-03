<!DOCTYPE html>
<html lang="es" itemscope itemtype="http://schema.org/WebPage">

	<head prefix="og: http://ogp.me/ns#">

		<title><?php echo $post["Title"]; ?> | Moco-Comics - Monitos de Juanele</title>
		<base href="<?php echo $custom->config->web_domain; ?>" >
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?php echo trim(substr(strip_tags($post["Content"]),0,150))."...";  ?>">
		<meta name="keywords" content="moco comics,comics,juanele,<?php echo $post["Category"]; ?>">
		<meta name="author" content="Moco Comics">

		<!--Facebook Meta Tags-->
		<meta property="og:image" content="http://moco-comics.com/<?php echo $post["Image"]; ?>"/> <!--URL of Image to show-->
		<meta property="og:description" content="<?php echo trim(substr(strip_tags($post["Content"]),0,150))."...";  ?>"/>
		<meta property="og:site_name" content="Moco Comics"/>
		<meta property="og:url" content="http://moco-comics.com/<?php echo $post["Url"]; ?>"/>
		<meta property="og:title" content="<?php echo $post["Title"]; ?>"/>

		<!--Google Meta Tags-->
		<meta itemprop="name" content="<?php echo $post["Title"]; ?>">
		<meta itemprop="description" content="<?php echo trim(substr(strip_tags($post["Content"]),0,150))."...";  ?>">
		<meta itemprop="image" content="http://moco-comics.com/<?php echo $post["Image"]; ?>">

		<!--Twitter Meta Tags - You'll have to validate your website here: https://dev.twitter.com/docs/cards/validation/validator-->
		<meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:domain" content="moco-comics.com">
		<meta name="twitter:site" content="@juanele_tamal">
		<meta name="twitter:title" content="<?php echo $post["Title"]; ?>">
		<meta name="twitter:description" content="<?php echo trim(substr(strip_tags($post["Content"]),0,150))."...";  ?>">
		<meta name="twitter:creator" content="@juanele_tamal">
		<meta name="twitter:image:src" content="http://moco-comics.com/<?php echo $post["Image"]; ?>">

		<link rel="publisher" href="https://plus.google.com/105828506087143336483/">

		<!-- Android Mobile Icons-->
		<link rel="icon" sizes="192x192" href="img/favicon.ico">
		<link rel="icon" sizes="128x128" href="img/favicon.ico">

		<!--Apple mobile icons-->
		<link rel="apple-touch-icon" href="img/touch-icon-iphone.png"><!--60 x 60-->
		<link rel="apple-touch-icon" sizes="76x76" href="img/touch-icon-ipad.png"><!--76 x 76-->
		<link rel="apple-touch-icon" sizes="120x120" href="img/touch-icon-iphone-retina.png"><!--120 x 120-->
		<link rel="apple-touch-icon" sizes="152x152" href="img/touch-icon-ipad-retina.png"><!--152 x 152-->

		<link rel="shortcut icon" href="img/favicon.ico"/>
		<link rel="canonical" href="http://moco-comics.com/">

		<link rel="stylesheet" href="style/normalize.css">
		<link rel="stylesheet" href="style/animate.css">
		<link rel="stylesheet" href="style/font-awesome.min.css">
		<link rel="stylesheet" href="style/lazy-sheet.css">
		<link rel="stylesheet" href="style/main.css">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/post.js"></script>
        <script src="https://apis.google.com/js/platform.js" async defer>
			{lang: 'en'}
		</script>
		<script>!function(d,s,id){var js,ajs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://secure.assets.tumblr.com/share-button.js";ajs.parentNode.insertBefore(js,ajs);}}(document, "script", "tumblr-js");</script>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        <!-- Project Wonderful Ad Box Loader -->
		<script type="text/javascript">
			(function(){function pw_load(){
			if(arguments.callee.z)return;else arguments.callee.z=true;
			var d=document;var s=d.createElement('script');
			var x=d.getElementsByTagName('script')[0];
			s.type='text/javascript';s.async=true;
			s.src='//www.projectwonderful.com/pwa.js';
			x.parentNode.insertBefore(s,x);}
			if (window.attachEvent){
			window.attachEvent('DOMContentLoaded',pw_load);
			window.attachEvent('onload',pw_load);}
			else{
			window.addEventListener('DOMContentLoaded',pw_load,false);
			window.addEventListener('load',pw_load,false);}})();
		</script>
		<!-- End Project Wonderful Ad Box Loader -->


	</head>
	<body>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<!--<aside class="announcement">
			<div class="container">
				<p>Proyecto apoyado por el <a href="http://fonca.conaculta.gob.mx" class="bold" target="_blank">Fondo Nacional Para la Cultura y las Artes</a></p>
			</div>
		</aside>-->
		<header id="main">
			<h1><a href="">Moco-Comics</a></h1>
			<span>Monitos de Juanele</span>
			<nav class="cartoons">
				<img class="character" src="img/patote.png" title="Patote"/>
				<img class="character" src="img/abuela.png" title="Abuela Karateca"/>
				<img class="character" src="img/chocolomo.png" title="Chocolomo"/>
				<img class="character" src="img/cuco.png" title="Cuco"/>
			</nav>
			<nav class="main-nav">
				<a href="archivo-de-comics/">Comics</a>
				<a href="el-autor/">Acerca de</a>
				<a href="tienda/">Tienda</a>
			</nav>
		</header>
		<section class="featured-wrapper">
			<div class="container clearfix">
				<div class="column sd-l12">
					<a href="" class="home-link"><span class="fa fa-angle-left"></span><span class=" fa fa-home"></span></a>
				</div>
				<div class="column sd-l7 md8">
					<article class="clearfix">
						<img data-post="img" class="small featured-img" src="<?php echo $post["Image"]; ?>">
						<time datetime="<?php echo $post["Date"]; ?>"><?php echo ucwords(strftime("%A %e de %B del %Y ",strtotime($post["Date"])))?></time>
						<span data-post="category"><?php echo $post["Category"]; ?></span>
						<h5 data-post="title"><?php echo $post["Title"]; ?></h5>
						<?php echo $post["Content"]; ?>
						<footer data-post="footer">
							<div class='social-wrapper'>
                                <div class='facebook-buttons'>
                                    <div class='fb-like' data-href='http://www.moco-comics.com/<?php echo $post["Url"]; ?>/' data-layout='button_count' data-action='like'data-show-faces='false' data-share='true'></div>
                                </div>
                                <div class='twitter-button'>
                                    <a href='https://twitter.com/share' class='twitter-share-button' data-url='http://www.moco-comics.com/<?php echo $post["Url"]; ?>/'>Tweet</a>
                                </div>
                                <div class="google-button">
                                	<div class='g-plusone'  data-size='medium'  data-href='http://www.moco-comics.com/<?php echo $post["Url"]; ?>/'></div>
                                </div>
								<div class="tumblr-button">
									<a class='tumblr-share-button' data-color='blue' data-notes='right' href='https://embed.tumblr.com/share' data-content='http://www.moco-comics.com/<?php echo $post["Image"]; ?>' data-posttype='photo'></a>
								</div>
                            </div>
						</footer>
					</article>
				</div>
				<div class="sd-l-aside-wrapper column sd-l5 md4" data-site="post">
					<nav class="posts-navigation">
						<div class="tools" data-site="post">
							<div class="container clearfix">
								<h5>¡Comenta!</h5>
								<button class="add-comment"><span class="fa fa-plus"></span></button>
								<form class="new-comment"  method="post" id="Commenter">
									<input type="text" name="name" placeholder="Nombre" required/>
									<input type="email" name="email" placeholder="Correo" required/>
                                    <input type="url" name="web" placeholder="Web" />
									<input type="hidden" name="rep" value="None">
                                    <input type="hidden" name="cuco" value="<?php echo $post["ID"]; ?>">
									<textarea name="comment" placeholder="Escribe tu comentario..." required></textarea>
									<input type="submit" value="Aceptar">
								</form>
                                <span id="cFail">Tu comentario no se ha enviado.</span>
							</div>
						</div>
                        <div class='comments-wrapper'>
                            <?php
                                echo $custom->buildComments($post["ID"]);
                            ?>
						</div>
					</nav>
				</div>
			</div>
		</section>
		<section class="js-responsive-aid">
			<div class="ads">
				<!-- Project Wonderful Ad Box Code -->
				<div id="pw_adbox_76232_5_0"></div>
				<script type="text/javascript"></script>
				<noscript><map name="admap76232" id="admap76232"><area href="http://www.projectwonderful.com/out_nojs.php?r=0&c=0&id=76232&type=5" shape="rect" coords="0,0,728,90" title="" alt="" target="_blank" /></map>
				<table cellpadding="0" cellspacing="0" style="width:300x;border-style:none;background-color:#ffffff;"><tr><td><img src="http://www.projectwonderful.com/nojs.php?id=76232&type=5" style="width:300px;height:90px;border-style:none;" usemap="#admap76232" alt="" /></td></tr><tr><td style="background-color:#ffffff;" colspan="1"><center><a style="font-size:10px;color:#0000ff;text-decoration:none;line-height:1.2;font-weight:bold;font-family:Tahoma, verdana,arial,helvetica,sans-serif;text-transform: none;letter-spacing:normal;text-shadow:none;white-space:normal;word-spacing:normal;" href="http://www.projectwonderful.com/advertisehere.php?id=76232&type=5" target="_blank">Ads by Project Wonderful! Your ad here, right now: $0.20</a></center></td></tr></table>
				</noscript>
				<!-- End Project Wonderful Ad Box Code -->
			</div>
		</section>
		<footer>
			<div class="social-wrapper buttons-only">
				<a href="http://www.facebook.com/MocoComics" target="_blank" class="facebook-btn"><span class="fa fa-facebook"></span>Dale like</a>
				<a href="http://juanele.deviantart.com/" target="_blank" class="deviantart-btn"><span class="fa fa-deviantart"></span>Comenta</a>
				<a href="http://twitter.com/juanele_tamal" target="_blank" class="twitter-btn"><span class="fa fa-twitter"></span>Síguenos</a>
				<a href="http://juanele-tamal.tumblr.com/" target="_blank" class="tumblr-btn"><span class="fa fa-tumblr"></span>Comparte</a>
			</div>
			<div class="container clearfix">
				<div class="site-links">
					<a href="archivo-de-comics/">Comics</a>
					<a href="el-autor/">Acerca de</a>
					<a href="tienda/">Tienda</a>
                    <a href="feed/">RSS</a>
				</div>
				<small>©2013-2015 Juan Manuel Ramirez de Arellano "Juanele".</small>
				<small class="developer">Desarrollado por <a href="http://www.codify.mx" target="_blank">Codify</a></small>
			</div>
		</footer>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-7655250-2', 'auto');
			ga('send', 'pageview');
		</script>
	</body>
</html>