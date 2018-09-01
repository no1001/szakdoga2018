<?php if (!defined('included')){header("Location: index.php?p=login");}
$ip=$_SERVER['REMOTE_ADDR'];
	$checkBF="SELECT count(*) as db from log where date(happen)=date(NOW()) and  MINUTE(timediff(happen,now()))<60 and whatcode=0 and whereip='$ip'";
	$er=query($checkBF);
	$db=results($er,0,'db');
	if ($db>=5) 
	{ 
    include_once 'inc/errors.php';
		hiba(35);
    exit;
	}?>
<article style="min-height: 50vh;max-height:600px">
<form method="post" action="<?php echo $domain;?>loginuser.php" enctype="multipart/form-data" class="grid"
      style="grid-template-columns: auto auto;">
  <div style="grid-column-end: 3;grid-column-start:1;"><h1 style="font-family: 'Merienda', cursive;">Bejelentkezés</h1>
  </div>
  <div>Felhasználónév:</div><input type="text" placeholder="Felhasználónév" name="userName" id="userName" required autofocus>
  <div>Jelszó:</div><input type="password" placeholder="Jelszó" name="userPassword" id="userPassword" required>
  
    <input class="button" type="submit" value="Bejelentkezés" 
           style="grid-column-end: 3;
                  grid-column-start:1;
                  ">
  
  </form>

</article>