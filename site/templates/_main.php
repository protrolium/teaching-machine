<?php namespace ProcessWire;

// Optional main output file, called after rendering page’s template file. 
// This is defined by $config->appendTemplateFile in /site/config.php, and
// is typically used to define and output markup common among most pages.
// 	
// When the Markup Regions feature is used, template files can prepend, append,
// replace or delete any element defined here that has an "id" attribute. 
// https://processwire.com/docs/front-end/output/markup-regions/
	
/** @var Page $page */
/** @var Pages $pages */
/** @var Config $config */
/** @var RockFrontend $rockfrontend */

$home = $pages->get('/'); // homepage directory

?>
<!DOCTYPE html>
<html lang="en">
	<head id="html-head">
		
		<!-- hide our site content -->
		<!-- <style>html{visibility: hidden;opacity:0;}body.preload * {transition: none !important;animation: none !important;}body.preload .page-content {opacity: 0;visibility: hidden;}</style> -->
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<!-- add our styles and scripts -->
		<?= $rockfrontend->styleTag($config->urls->templates . "/dst/styles.min.css") ?>
		<?= $rockfrontend->scriptTag($config->urls->templates . "/dst/scripts.min.js") ?>

		<!-- make sure we get styling on mobile by setting meta viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo ($page->name == 'home' ? $page->title : $page->title . ' — Teaching Machine'); ?></title>
		<meta name="description" content="The Teaching Machine is an independent arts laboratory devising strategies for amalgamated practices within the cinematic imaginary, musical zeitgeist, and networked hyperstructres.">
		<meta name="keywords" content="teaching machine audio visual art collective concert visuals vj video installation virutal reality music releases classical beat techno experimental chamber music performer electronic film cinema opera print illustration web net software los angeles barcelona singapore 3D fractal hypercube strangeloop looop gavin gamboa jake bloch micah nelson gemma soldati ian simon ben olsen timeboy brainfeeder gallery exhibition opening robotics">
		<meta name="generator" content="ProcessWire">

		<!-- fonts -->
		<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="" rel="stylesheet">  -->
		<link rel="preload" href="<?php echo $config->urls->templates?>styles/fonts/oswald/Oswald-Regular.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="<?php echo $config->urls->templates?>styles/fonts/oswald/Oswald-Medium.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="<?php echo $config->urls->templates?>styles/fonts/oswald/Oswald-Light.woff2" as="font" type="font/woff2" crossorigin>

		<!-- favicons -->
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $config->urls->assets?>favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $config->urls->assets?>favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $config->urls->assets?>favicon/favicon-16x16.png">
		<link rel="manifest" href="<?php echo $config->urls->assets?>favicon/site.webmanifest">
		<link rel="mask-icon" href="<?php echo $config->urls->assets?>favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">

		<!-- metatags -->
		<?php $metadata = $modules->get('MarkupMetadata');?>
		<?php echo $metadata->render();?>

	</head>
	<body id="html-body">
		<!-- make sure we are in dark mode -->
		<script type="text/javascript">
			const selectedTheme = localStorage.getItem('dark-mode');
			if (selectedTheme === "enabled") {
				html.dataset.theme = `theme-dark`;
			} else if (selectedTheme === "disabled") {
				html.dataset.theme = `theme-light`;
			}
		</script>

		<?= $rockfrontend->render("sections/includes/header.latte") ?>
		<?= $rockfrontend->renderLayout($page) ?>
		<?= $rockfrontend->render("sections/includes/footer.latte") ?>

		<!-- show our site content -->
		<!-- <style>html{visibility: visible;opacity:1;}</style> -->

		<!-- unhide the site content set via inline css above -->
		<!-- <script type="text/javascript">window.addEventListener('load', function () {document.body.classList.remove('preload');});</script> -->

		<!-- scripts for once DOM is loaded -->
		<script type="text/javascript" src="<?php echo $config->urls->templates?>scripts/onload.js" defer></script>
		<!-- mastodon verification -->
		<a class="noExternalSVG" rel="me" href="https://autonomous.zone/@theteachingmachine" style="display:hidden;" aria-label="Mastodon Verification"></a>
	</body>
</html>