<?php
    include_once("lib/custom-class.php");
	header('Content-Type: application/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title>Moco Comics</title>
		<link><?php echo trim($custom->config->web_domain); ?></link>
		<language>es-MX</language>
		<description>Monitos de Juanele</description>
		<?php echo trim($custom->buildRssFeed()); ?>
	</channel>
</rss>