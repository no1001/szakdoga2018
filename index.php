<!doctype html>
<html lang="hu">
<?php include_once "functions.php";
	define('included',true);
	$userID=getUserID();
	$userRank=getUserRank($userID);
	?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="<?php echo $domain;?>res/favico.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>default.min.css">	
	<script src="<?php echo $domain;?>res/jquery.js"></script>
	<script src="<?php echo $domain;?>res/jqueryui.js"></script>
	<script src="<?php echo $domain;?>functions.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116951890-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-116951890-1');
</script>

	<?php if (!isset($_COOKIE['okicookie']))
	print ('<script src="'.$domain.'res/js.cookie.js"></script>');
	?>
	<?php if (isset($_GET['p'])){
				if ($_GET['p']=="index") {echo '<title>Főoldal - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Főoldal">';}
				if ($_GET['p']=="etlap") {echo '<title>Étlap - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Étlap">';}
				if ($_GET['p']=="settings") {echo '<title>Beállítások - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Beállítások">';}
				if ($_GET['p']=="profil") {echo '<title>Profil - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Profil">';}
				if ($_GET['p']=="rolunk") {echo '<title>Rólunk - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Rólunk">';}
				if ($_GET['p']=="hirek") {echo '<title>Hírek - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Hírek">';}
				if ($_GET['p']=="galeria") {echo '<title>Galéria - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Galéria">';}
				if ($_GET['p']=="login") {echo '<title>Bejelentkezés - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Bejelentkezés">';}
				if ($_GET['p']=="regisztracio") {echo '<title>Regisztráció - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Regisztráció">';}
				if ($_GET['p']=="foglalas") {echo '<title>Foglalás - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Foglalás">';}
				if ($_GET['p']=="books") {echo '<title>Foglalás kezelés - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Foglalás kezelés">';}
				}else {
															{  echo '<title>Főoldal - Faust C&#38;R</title>';
																 echo '<meta name="description" content="Faust Étterem - Főoldal">';}
}
?>
<link rel="manifest" href="<?php echo $domain;?>res/manifest.json">
<meta name="theme-color" content="orange"/>
	
	
	<style>
		@import url('https://fonts.googleapis.com/css?family=Merienda: 400,700');
	</style>
</head>

<body>
<?php if (!isset($_COOKIE['okicookie'])){include_once 'cookie.php';}?>

	<header>

		<div id="menu"><svg width='30' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="white"  d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg><span>Menü</span></div>
		<div class="logo">&#9884;Faust&#9884;</div>
		<div id="social">
			<a href="https://facebook.com"><img src="<?php echo $domain;?>res/facebook.png" alt="Facebook" title="Facebook ..."/></a>
			<a href="https://twitter.com"><img  src="<?php echo $domain;?>res/twitter.png" alt="Twitter" title="Twitter @..."/></a>
		</div>
	</header>

	<nav>
		<?php include_once 'nav.php'; ?>
	</nav>

		<div class="content">
			
			<?php 			
			if (isset($_GET['hiba'])){include_once 'inc/errors.php';hiba($_GET['hiba']);}
			if (isset($_GET['msg'])){include_once 'inc/messages.php'; message($_GET['msg']);}
			if (isset($_GET['p'])){
				if ($_GET['p']=="index"){
					include_once "welcome.php";
				  include_once "hirek.php";}
				else if (file_exists($_GET['p'].".php")) include_once $_GET['p'].".php";
				else {include_once 'inc/errors.php'; hiba(0);}
			}
			
			else {
				include_once "welcome.php";
				include_once "hirek.php";
			}	
			?>
			</div>

		<footer>&copy;Vasvári Antal 2017 - <?php echo date('Y');?> - Faust v.0.75</footer>
	
</body>

</html>