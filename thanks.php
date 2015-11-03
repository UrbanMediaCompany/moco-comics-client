<?php
	include_once("lib/custom-class.php");
?>
<!DOCTYPE html>
<html lang="es" itemscope itemtype="http://schema.org/WebPage">

	<head prefix="og: http://ogp.me/ns#">

		<title>Gracias | Moco-Comics - Monitos de Juanele</title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Gracias por tu compra.">
		<meta name="keywords" content="">
		<meta name="author" content="Moco Comics">
		<base href="<?php echo $custom->config->web_domain; ?>" >

		<!--Facebook Meta Tags-->
		<meta property="og:image" content="http://moco-comics.com/img/Autor.png"/>
		<meta property="og:description" content="Gracias por tu compra."/>
		<meta property="og:site_name" content="Gracias"/>
		<meta property="og:url" content="http://moco-comics.com"/>
		<meta property="og:title" content="Gracias | Moco-Comics - Monitos de Juanele"/>

		<!--Google Meta Tags-->
		<meta itemprop="name" content="Gracias | Moco-Comics - Monitos de Juanele">
		<meta itemprop="description" content="Gracias por tu compra.">
		<meta itemprop="image" content="http://moco-comics.com/img/Autor.png">

		<!--Twitter Meta Tags-->
		<meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:domain" content="moco-comics.com">
		<meta name="twitter:site" content="@juanele_tamal">
		<meta name="twitter:title" content="Gracias | Moco-Comics - Monitos de Juanele">
		<meta name="twitter:description" content="Gracias por tu compra.">
		<meta name="twitter:creator" content="@juanele_tamal">
		<meta name="twitter:image:src" content="http://moco-comics.com/img/Autor.png">

		<link rel="publisher" href="https://plus.google.com/105828506087143336483/">

		<!-- Android Mobile Icons-->
		<link rel="icon" sizes="192x192" href="img/icon_192x192.png">
		<link rel="icon" sizes="128x128" href="img/icon_128x128.png">

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
		<script src="js/archive.js"></script>
	</head>
	<body>

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
                <a href="">Inicio</a>
                 <a href="el-autor/">Acerca de</a>
				<a href="archivo-de-comics/">Comics</a>
				<a href="tienda/">Tienda</a>
			</nav>
		</header>
		<section class="about">
			<article>
				<h2>Paypal Checkout</h2>
				<p><?php echo $custom -> getAdditionalData("Thanks"); ?></p>
			</article>
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
                    <a href="">Inicio</a>
                    <a href="el-autor/">Acerca de</a>
					<a href="archivo-de-comics/">Comics</a>
					<a href="tienda/">Tienda</a>
                    <a href="feed/">RSS</a>
				</div>
				<small>©2013-<?php echo date("Y"); ?> Juan Manuel Ramirez de Arellano "Juanele".</small>
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