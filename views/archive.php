<!DOCTYPE html>

<!--Aegis Framework | MIT License | http://www.aegisframework.com/ -->

<html lang="en" itemscope itemtype="http://schema.org/WebPage"> <!--Change the lang property to your web's language-->

	<head prefix="og: http://ogp.me/ns#">

		<title>{{title}}</title><!--Up to 60-70 Characters. Optimal Format: Primary Keyword - Secondary Keyword | Brand Name-->

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="description" content="{{description}}"><!--Page description. No longer than 155 characters.-->
		<meta name="keywords" content="{{keywords}}">
		<meta name="author" content="{{author}}"><!--Name of the author.-->
		<base href="{{domain}}">

		<!--Facebook Meta Tags-->
		<meta property="og:image" content="{{domain}}img/{{shareimage}}"/> <!--URL of Image to show-->
		<meta property="og:description" content="{{description}}"/> <!--Page Description-->
		<meta property="og:site_name" content="{{title}}"/> <!--The Name Here-->
		<meta property="og:url" content="{{route}}"/> <!--The Web main URL-->
		<meta property="og:title" content="{{title}}"/><!--The Title Here-->

		<!--Google Meta Tags-->
		<meta itemprop="name" content="{{title}}"><!--The Name or Title Here-->
		<meta itemprop="description" content="{{description}}"><!--Page Description-->
		<meta itemprop="image" content="{{domain}}img/{{shareimage}}"><!--URL of Image to show-->

		<!--Twitter Meta Tags - You'll have to validate your website here: https://dev.twitter.com/docs/cards/validation/validator-->
		<meta name="twitter:card" content="summary_large_image"> <!--Content type:summary, summary_large_image, photo, gallery, product, app, player-->
        <meta name="twitter:domain" content="{{domain}}"> <!--Your web's domain-->
		<meta name="twitter:site" content="{{twitter}}"> <!--@publisher-->
		<meta name="twitter:title" content="{{title}}"> <!--Page Title-->
		<meta name="twitter:description" content="{{description}}"> <!--Page description less than 200 characters-->
		<meta name="twitter:creator" content="{{twitter}}"> <!--@author-->
		<meta name="twitter:image:src" content="{{domain}}img/{{shareimage}}"><!--URL of Image to show-->

		<!--START of Web Apps Tags (Delete if not necessary)-->

			<!--Android Meta Tags-->
			<meta name="mobile-web-app-capable" content="yes">

			<!--Apple Meta Tags-->
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-title" content="{{title}}"> <!--App Title or Name-->

			<!--Microsoft Tags-->
			<meta name="msapplication-TileColor" content=""><!--Color of the tile on Windows. In hexadecimal format-->
			<meta name="application-name" content="{{title}}"/> <!-- App Title -->
			<meta name="msapplication-tooltip" content="{{title}}"/> <!--Small text on hover-->
			<meta name="msapplication-starturl" content="http://"/> <!-- URL to start in -->
			<meta name="msapplication-square70x70logo" content="img/ms-70x70.png" /><!--Image for Tile 70x70-->
			<meta name="msapplication-square150x150logo" content="img/ms-150x150.png" /><!--Image for Tile 150x150-->
			<meta name="msapplication-wide310x150logo" content="img/ms-310x150.png" /><!--Image for Tile 310x150-->
			<meta name="msapplication-square310x310logo" content="img/ms-310x310.png" /><!--Image for Tile 310x310-->

		<!--END of Web Apps Tags-->

		<link rel="publisher" href="https://plus.google.com/{{google}}"><!--Publisher's Google+ URL-->

		<!-- Android Mobile Icons-->
		<link rel="icon" sizes="192x192" href="img/icon_192x192.png">
		<link rel="icon" sizes="128x128" href="img/icon_128x128.png">

		<!--Apple mobile icons-->
		<link rel="apple-touch-icon" href="img/touch-icon-iphone.png"><!--60 x 60-->
		<link rel="apple-touch-icon" sizes="76x76" href="img/touch-icon-ipad.png"><!--76 x 76-->
		<link rel="apple-touch-icon" sizes="120x120" href="img/touch-icon-iphone-retina.png"><!--120 x 120-->
		<link rel="apple-touch-icon" sizes="152x152" href="img/touch-icon-ipad-retina.png"><!--152 x 152-->

		<link rel="shortcut icon" href="img/favicon.ico"/><!--Favicon. Good tool for creating one: http://xiconeditor.com/ Create all sizes.-->
		<link rel="canonical" href="{{domain}}"><!--Canonical URL of your webpage-->

		<!-- build:stylesheets -->
		<link rel="stylesheet" href="style/animate.css">
		<link rel="stylesheet" href="style/normalize.css">
		<link rel="stylesheet" href="style/font-awesome.min.css">
		<link rel="stylesheet" href="style/lazy-sheet.css">
		<link rel="stylesheet" href="style/main.css">
		<!-- endbuild -->

		<!-- build:scripts -->
		<script src="js/aegis.js"></script>
		<script   src="//code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
		<script src="js/plugins.js"></script>
		<script src="js/jquery.fitvids.js"></script>
		<script src="js/jquery.lazyload.min.js"></script>
		<script src="js/archive.js"></script>
		<!-- endbuild -->

		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        <script src="https://apis.google.com/js/platform.js" async defer>
			{lang: 'en'}
		</script>
		<script>!function(d,s,id){var js,ajs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://secure.assets.tumblr.com/share-button.js";ajs.parentNode.insertBefore(js,ajs);}}(document, "script", "tumblr-js");</script>
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

	</head>
	<body>
		{{> facebookScript}}
    	{>{content}<}
	</body>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-7655250-2', 'auto');
		ga('send', 'pageview');
	</script>
</html>