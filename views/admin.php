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
		<link rel="stylesheet" href="style/font-awesome.min.css">
		<link rel="stylesheet" href="style/lazy-sheet.css">
		<link rel="stylesheet" href="style/admin.css">
		<!-- endbuild -->

		<!-- build:scripts -->
		<script src="js/aegis.js"></script>
		<script src="//code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
		<script src="js/plugins.js"></script>
		<script src="js/jquery.fitvids.js"></script>
		<script src="js/jquery.lazyload.min.js"></script>
		<script src="js/admin.js"></script>
		<!-- endbuild -->

	</head>
	<body>
    	{>{content}<}
	</body>
</html>