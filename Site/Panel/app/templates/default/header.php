<?php

	use Helpers\Assets;
	use Helpers\Url;
	use Helpers\Hooks;

	$hooks = Hooks::get();

?>

<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>

	<meta charset="utf-8"></meta>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
	<meta content="yes" name="apple-touch-fullscreen" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="description" content="Ce site vous permet de suivre la météo dans la ville de Colmar, c'est une station amateur utilisant un Arduino ! "/>
	<meta name="theme-color" content="#212121">
	<meta name="msapplication-navbutton-color" content="#212121">
	<meta name="apple-mobile-web-app-status-bar-style" content="#212121">
	<meta name="apple-touch-fullscreen" content="yes">
	
	<title><?php echo $data['title'].' - '.SITETITLE; ?></title>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>

	<?php
		
		Assets::css(array(
			'https://fonts.googleapis.com/icon?family=Material+Icons',
			Url::templatePath() . 'css/materialize.min.css',
			Url::templatePath() . 'css/main.css'
		));

		$hooks->run('css');
	?>

	<link rel="icon" type="image/png" href=<?php echo Url::templatePath() . '/icons/favicon.ico'; ?> />
	<link rel="apple-touch-icon" sizes="57x57" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-57x57.png'; ?>>
	<link rel="apple-touch-icon" sizes="60x60" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-60x60.png'; ?>>
	<link rel="apple-touch-icon" sizes="72x72" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-72x72.png'; ?>>
	<link rel="apple-touch-icon" sizes="76x76" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-76x76.png'; ?>>
	<link rel="apple-touch-icon" sizes="114x114" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-114x114.png'; ?>>
	<link rel="apple-touch-icon" sizes="120x120" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-120x120.png'; ?>>
	<link rel="apple-touch-icon" sizes="144x144" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-144x144.png'; ?>>
	<link rel="apple-touch-icon" sizes="152x152" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-152x152.png'; ?>>
	<link rel="apple-touch-icon" sizes="180x180" href=<?php echo Url::templatePath() . '/icons/apple-touch-icon-180x180.png'; ?>>
	<link rel="icon" type="image/png" href=<?php echo Url::templatePath() . '/icons/favicon-32x32.png'; ?>>
	<link rel="icon" type="image/png" href=<?php echo Url::templatePath() . '/icons/favicon-194x194.png'; ?>>
	<link rel="icon" type="image/png" href=<?php echo Url::templatePath() . '/icons/favicon-96x96.png'; ?>>
	<link rel="icon" type="image/png" href=<?php echo Url::templatePath() . '/icons/android-chrome-192x192.png'; ?>>
	<link rel="icon" type="image/png" href=<?php echo Url::templatePath() . '/icons/favicon-16x16.png'; ?>>
	<link rel="manifest" href=<?php echo Url::templatePath() . '/icons/manifest.json'; ?>>
	<meta name="msapplication-TileColor" content="#00aba9">
	<meta name="msapplication-TileImage" content=<?php echo Url::templatePath() . '/icons/mstile-144x144.png'; ?>>
	<meta name="theme-color" content="#EEEEEE">

	<meta property="og:title" content="<?php echo $data['title'].' - '.SITETITLE; ?>">
	<meta property="og:url" content="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
	<meta property="og:image" content="<?php echo Url::templatePath() . '/icons/apple-touch-icon-114x114.png'; ?>">

</head>
<body class="blue-grey lighten-5">

<?php
	$hooks->run('afterBody');
?>

<ul id="other-dropdown" class="dropdown-content">
	<li><a href="about">Informations</a></li>
	<li><a href="adsb">Trafic Aérien</a></li>
	<li><a href="contact">Contact</a></li>
</ul>

<nav>
	<div class="nav-wrapper">
		<a href="home" class="brand-logo">Météo Colmar</a>
		<a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>
		<ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="home">Accueil</a></li>
			<li><a href="forecast">Prévisions</a></li>
			<li><a href="thunder">Orages</a></li>
			<li><a href="graphics">Graphiques</a></li>
			<li><a href="historic">Historique</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="other-dropdown">Autres Pages<i class="material-icons right"></i></a></li>
		</ul>
		<ul class="side-nav" id="mobile-menu">
	        <li><a href="home">Accueil</a></li>
			<li><a href="forecast">Prévisions</a></li>
			<li><a href="thunder">Orages</a></li>
			<li><a href="graphics">Graphiques</a></li>
			<li><a href="historic">Historique</a></li>
			<li><hr></li>
			<li><a href="about">Informations</a></li>
			<li><a href="adsb">Trafic Aérien</a></li>
			<li><a href="contact">Contact</a></li>
      </ul>
	</div>
</nav>
        
<div class="container">