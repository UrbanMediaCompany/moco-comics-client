<?php
	require("login.php");
?>
<!DOCTYPE html>


<html lang="es" itemscope itemtype="http://schema.org/WebPage"> <!--Change the lang property to your web's language-->

	<head prefix="og: http://ogp.me/ns#">

		<title>Administrador</title><!--Up to 60-70 Characters. Optimal Format: Primary Keyword - Secondary Keyword | Brand Name-->

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="description" content=""><!--Page description. No longer than 155 characters.-->
		<meta name="keywords" content="">
		<meta name="author" content=""><!--Name of the author.-->
		<base href="<?php echo $custom->config->web_domain; ?>" >
		<!--Facebook Meta Tags-->
		<meta property="og:image" content="http://"/> <!--URL of Image to show-->
		<meta property="og:description" content=""/> <!--Page Description-->
		<meta property="og:site_name" content=""/> <!--The Name Here-->
		<meta property="og:url" content="http://"/> <!--The Web main URL-->
		<meta property="og:title" content=""/><!--The Title Here-->

		<!--Google Meta Tags-->
		<meta itemprop="name" content=""><!--The Name or Title Here-->
		<meta itemprop="description" content=""><!--Page Description-->
		<meta itemprop="image" content="http://"><!--URL of Image to show-->

		<!--Twitter Meta Tags - You'll have to validate your website here: https://dev.twitter.com/docs/cards/validation/validator-->
		<meta name="twitter:card" content="summary_large_image"> <!--Content type: summary, summary_large_image, photo, gallery, product, app, player-->
        <meta name="twitter:domain" content=""> <!--Your web's domain-->
		<meta name="twitter:site" content="@"> <!--@publisher-->
		<meta name="twitter:title" content=""> <!--Page Title-->
		<meta name="twitter:description" content=""> <!--Page description less than 200 characters-->
		<meta name="twitter:creator" content="@"> <!--@author-->
		<meta name="twitter:image:src" content="http://"><!--URL of Image to show-->

		<!--START of Web Apps Tags (Delete if not necessary)-->

			<!--Android Meta Tags-->
			<meta name="mobile-web-app-capable" content="yes">

			<!--Apple Meta Tags-->
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-title" content=""> <!--App Title or Name-->

			<!--Microsoft Tags-->
			<meta name="msapplication-TileColor" content=""><!--Color of the tile on Windows. In hexadecimal format-->
			<meta name="application-name" content=""/> <!-- App Title -->
			<meta name="msapplication-tooltip" content=""/> <!--Small text on hover-->
			<meta name="msapplication-starturl" content="http://"/> <!-- URL to start in -->
			<meta name="msapplication-square70x70logo" content="img/" /><!--Image for Tile 70x70-->
			<meta name="msapplication-square150x150logo" content="img/" /><!--Image for Tile 150x150-->
			<meta name="msapplication-wide310x150logo" content="img/" /><!--Image for Tile 310x150-->
			<meta name="msapplication-square310x310logo" content="img/" /><!--Image for Tile 310x310-->

		<!--END of Web Apps Tags-->

		<link rel="publisher" href=""><!--Publisher's Google+ URL-->

		<!-- Android Mobile Icons-->
		<link rel="icon" sizes="192x192" href="img/icon_192x192.png">
		<link rel="icon" sizes="128x128" href="img/icon_128x128.png">

		<!--Apple mobile icons-->
		<link rel="apple-touch-icon" href="img/touch-icon-iphone.png"><!--60 x 60-->
		<link rel="apple-touch-icon" sizes="76x76" href="img/touch-icon-ipad.png"><!--76 x 76-->
		<link rel="apple-touch-icon" sizes="120x120" href="img/touch-icon-iphone-retina.png"><!--120 x 120-->
		<link rel="apple-touch-icon" sizes="152x152" href="img/touch-icon-ipad-retina.png"><!--152 x 152-->

		<link rel="shortcut icon" href="img/favicon.ico"/><!--Favicon. Good tool for creating one: http://xiconeditor.com/ Create all sizes.-->

		<link rel="stylesheet" href="style/normalize.css">
		<link rel="stylesheet" href="style/animate.css">
		<link rel="stylesheet" href="style/font-awesome.min.css">
		<link rel="stylesheet" href="style/lazy-sheet.css">
		<link rel="stylesheet" href="style/admin.css">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/jquery.fitvids.js"></script>
        <script src="js/jquery.lazyload.min.js"></script>
		<script src="js/admin.js"></script>



	</head>
	<body>
		<header class="clearfix">
			<div class="container">
				<h1>Moco-Comics</h1>
				<div class="user-settings">
					<img src="img/admin/juanele.jpeg" class="user-avatar">
					<nav class="settings">
						<ul>
							<li><button class="get-support">¿Problemas?</button></li>
							<!--<li><button class="password">Cambiar contraseña</button></li>-->
							<li><button class="logout">Cerrar sesión</button></li>
						</ul>
					</nav>
				</div>
				<div class="xsd10">
					<nav class="site-nav">
						<ul>
							<li>
								<button data-nav="notifications">
									<span class="fa fa-bell-o sd-l-invisible"></span><span class="xsd-invisible sd-l-visible">Notificaciones</span>
								</button>
							</li>
							<li>
								<button data-nav="characters">
									<span class="fa fa-smile-o sd-l-invisible"></span><span class="xsd-invisible sd-l-visible">Personajes</span>
								</button>
							</li>
							<li>
								<button data-nav="posts">
									<span class="fa fa-newspaper-o sd-l-invisible"></span><span class="xsd-invisible sd-l-visible">Posts</span>
								</button>
							</li>
							<li>
								<button data-nav="store">
									<span class="fa fa-shopping-cart sd-l-invisible"></span><span class="xsd-invisible sd-l-visible">Tienda</span>
								</button>
							</li>
							<li>
								<button data-nav="pages">
									<span class="fa fa-pencil sd-l-invisible"></span><span class="xsd-invisible sd-l-visible">Páginas</span>
								</button>
							</li>
						</ul>
					</nav>
				</div>
				<button class="add-post"><span class="fa fa-plus"></span></button>
			</div>
		</header>
		<section class="modal-window update-info">
			<div class="post-class">
				<div class="form-action clearfix">
					<button class="cancel pull-left-f"><span class="fa fa-close"></span>Cancelar</button>
				</div>
				<div class="modal-content">
					<h3 data-update="title"></h3>
					<span data-update="details"></span>
					<p data-update="description"></p>
					<ul data-update="features">
					</ul>
					<button data-update="install">Actualizar</button>
				</div>
			</div>
		</section>
		<section class="modal-window new-post">
			<div class="post-class">
				<div class="form-action clearfix">
					<button class="cancel pull-left-f"><span class="fa fa-close"></span>Cancelar</button>
					<button id="sendpost" type="submit" class="pull-right-f"><span class="fa fa-check"></span>Publicar</button>
				</div>
				<form class="create-post" id="createpost" method="post">

					<div class="image-input">
						<img data-post="image-preview" src="img/admin/upload.png"/>
						<div class="img-uploader">
							<button>
								<input name="image-input" type="file" class="upload-img" />
							</button>
						</div>
					</div>
					<time data-post="date" datetime=""></time>
                    <input name="post-id" type="hidden" value="0" />
					<span  data-post="category">
						<select  name="post-category">
                            <?php echo $custom->getCategoryOption(); ?>
						</select>
					</span>
					<div data-post="title">
						<input type="text" name="post-title" placeholder="Título del post"/>
					</div>
					<div data-post="content" contenteditable="true" >
						<p>Escribe aquí</p>
					</div>
					<div data-post="inputs"></div>
				</form>
				<div class="editor-tools">
					<div class="url-receiver">
						<button class="close-url"><span class="fa fa-close"></span></button>
						<input type="text" id="url-pass" placeholder="http://ejemplo.com">
						<button class="accept-url"><span class="fa fa-check"></span></button>
					</div>
					<div class="img-receiver">
						<button class="close-img"><span class="fa fa-close"></span></button>
						<button class="img-receiver-input">
							<input type="file" id="img-pass" class="upload-img staged" name="img-pass[]" placeholder="Selecciona una imagen">
							<span>Selecciona una imagen</span>
						</button>
						<button class="accept-img"><span class="fa fa-check"></span></button>
					</div>
					<div class="video-receiver">
						<button class="close-video"><span class="fa fa-close"></span></button>
						<input type="text" id="video-pass" placeholder="Inserta el código HTML">
						<button class="accept-video"><span class="fa fa-check"></span></button>
					</div>
					<div class="tools">
						<button class="xsd2" data-edit="bold" title="Negritas">B</button>
						<button class="xsd2" data-edit="italic" title="Italicas">I</button>
						<button class="xsd2" data-edit="underline" title="Subrayar">U</button>
						<button class="xsd2" data-edit="font" title="Cambiar Letra">F</button>
						<button class="xsd2" data-edit="link" title="Agregar link al texto seleccionado"><span class="fa fa-link"></span></button>
						<button class="xsd2" data-edit="img" title="Agregar una imagen"><span class="fa fa-image"></span></button>
						<button class="xsd2" data-edit="video" title="Agregar video"><span class="fa fa-play"></span></button>
					</div>
				</div>
			</div>
		</section>
		<div class="main">
			<div class="container">
				<section data-site="notifications">
					<div class="widget-wrapper clearfix">
						<div class="widget column xsd12 sd6 md3">
							<div class="counter" data-count="posts">
								<div class="widget-background">
									<span><?php echo $custom->getTotalPosts(); ?></span>
								</div>
								<span class="title"><span class="fa fa-newspaper-o"></span>Posts</span>
							</div>
						</div>
						<div class="widget column xsd12 sd6 md3">
							<div class="counter" data-count="post">
								<div class="widget-background">
									<span><?php echo $custom->getBestPost(date("m"),date("Y")); ?></span>
								</div>
								<span class="title"><span class="fa fa-trophy"></span>Post del mes</span>
							</div>
						</div>
						<div class="widget column xsd12 sd6 md3">
							<div class="counter" data-count="comments">
								<div class="widget-background">
									<span><?php echo $custom->getTotalComments(); ?></span>
								</div>
								<span class="title"><span class="fa fa-comments-o"></span>Comentarios</span>
							</div>
						</div>
						<div class="widget column xsd12 sd6 md3">
							<div class="counter" data-count="user">
								<div class="widget-background">
									<span><?php echo $custom->getBestUser(date("m"),date("Y")); ?></span>
								</div>
								<span class="title"><span class="fa fa-user"></span>Usuario del mes</span>
							</div>
						</div>

					</div>

					<div class="notification-wrapper clearfix">
                        <?php echo $custom->getUpdateNotification(); ?>
                        <?php echo $custom->buildNotifications(); ?>
					</div>
				</section>

				<section data-site="characters">
					<div class="characters-wrapper">
                        <?php echo $custom->buildCharacterForms(); ?>
					</div>
				</section>


				<section data-site="store">

					<div class="items-wrapper">
						<div class="double">

						<form method="post" enctype="multipart/form-data">
							<h2>Subir PDF</h2>
							<input type="file" name="pdf" required>
							<p>Perteneciente a: <select name="belong">
								<?php echo $custom -> storeOptions(); ?>
							</select></p>
						   <input type="submit" value="Subir">
                    	</form>

					<form method="post">
						<h2>Enviar PDF</h2>
						<p>Enviar <select name="sitem" id="so" required><?php echo $custom -> storeSendOptions(); ?></select> al mail <input type="email" name="smail" placeholder="example@example.com" name="smail" required> con el mensaje: <input type="text" name="smessage" value="Gracias por tu compra!" required></p>
					   <input type="submit" value="Enviar">
                    </form>

						</div>
						                    <h2>Items de la Tienda</h2>
                        <?php echo $custom->buildAdminStore(); ?>
					</div>
				</section>

				<section data-site="posts">
					<div class="posts-wrapper">

                        <?php echo $custom->buildAdminPosts(); ?>
					</div>
				</section>

				<section data-site="pages">
					<div class="pages-wrapper">
						<?php echo $custom->buildPages(); ?>
					</div>
				</section>

			</div> <!--END OF CONTAINER -->
		</div>
	</body>
</html>