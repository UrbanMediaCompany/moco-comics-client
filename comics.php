<?php
	include_once("lib/custom-class.php");
?>
<!DOCTYPE html>
<html lang="es" itemscope itemtype="http://schema.org/WebPage">

	<head prefix="og: http://ogp.me/ns#">

		<title>Archivo de Comics | Moco-Comics - Monitos de Juanele</title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content=""><!--Page description. No longer than 155 characters.-->
		<meta name="keywords" content="">
		<meta name="author" content="Moco Comics">
		<base href="<?php echo $custom->config->web_domain; ?>" >

		<!--Facebook Meta Tags-->
		<meta property="og:image" content="http://"/> <!--URL of Image to show-->
		<meta property="og:description" content=""/> <!--Page Description-->
		<meta property="og:site_name" content=""/> <!--The Name Here-->
		<meta property="og:url" content="http://"/> <!--The Web main URL-->
		<meta property="og:title" content="Archivo de Comics | Moco-Comics - Monitos de Juanele"/>

		<!--Google Meta Tags-->
		<meta itemprop="name" content="Archivo de Comics | Moco-Comics - Monitos de Juanele">
		<meta itemprop="description" content=""><!--Page Description-->
		<meta itemprop="image" content="http://"><!--URL of Image to show-->

		<!--Twitter Meta Tags-->
		<meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:domain" content=""> <!--Your web's domain-->
		<meta name="twitter:site" content="@juanele_tamal">
		<meta name="twitter:title" content="Archivo de Comics | Moco-Comics - Monitos de Juanele">
		<meta name="twitter:description" content=""> <!--Page description less than 200 characters-->
		<meta name="twitter:creator" content="@juanele_tamal">
		<meta name="twitter:image:src" content="http://"><!--URL of Image to show-->

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
        <script src="js/jquery.lazyload.min.js"></script>
		<script src="js/archive.js"></script>
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
		<!--<aside class="announcement">
			<div class="container">
				<p>Proyecto apoyado por el <a href="http://fonca.conaculta.gob.mx" class="bold" target="_blank">Fondo Nacional Para la Cultura y las Artes</a></p>
			</div>
		</aside>-->
		<header id="main">
			<h1><a href="">Moco-Comics</a></h1>
			<span>Monitos de Juanele</span>
			<nav class="main-nav">
				<a href="">Inicio</a>
				<a href="el-autor/">Acerca de</a>
				<a href="tienda/">Tienda</a>
			</nav>
		</header>
		<section class="archive">
			<div class="container">
				<nav>
					<?php
                        echo $custom->buildArchiveMenu();
                    ?>
				</nav>
				<div class="items-wrapper" id="comics-wrapper">
					<?php
                        echo $custom->buildArchive();
                    ?>
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
					<a href="">Inicio</a>
					<a href="el-autor/">Acerca de</a>
					<a href="tienda/">Tienda</a>
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