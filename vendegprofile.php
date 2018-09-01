<?php
//ajax vagy url-es elérés csekkolása
if (isset($_POST['ajax'])){
  include "functions.php";
  $userID=getUserID();
}
else {
  if (!defined('included')){header("Location: vendegprofile");}  
}
//be van-e jelentkezve
if ($userID<1) toindex();

//meglévő profil-e
if (isset($_POST['token'])){
  $guestID=getId($_POST['token'],'guests','guestID');  
}
//új profil felvétele
if (!(isset($_POST['token']))||($guestID<1)){
  $name=$email=$tel=$address="";
}
//meglévő profil adatainak kinyerése
else {
  $sql = "SELECT `name`,`email`,`tel`,`address` FROM `guests` WHERE `guestID`=$guestID and `userID`=$userID";
  $profil =query($sql);
  $name   =results($profil,0,0);
  $email  =results($profil,0,1);
  $tel    =results($profil,0,2);
  $address=results($profil,0,3);  
}
?>
<article>
<h1>
  Profil adatai:
  </h1>
  <form action="saveprofile.php" method="POST" enctype="multipart/form-data"> 
<div class="vendegadatok">
  <div class="profil" style="width: 100%;min-width: 0;max-width: 100%;">
				<div>
					Név:
				</div>
				<div>
          <input type="text" name="name" value="<?php echo $name;?>" required placeholder="Név">
				</div><hr>
				<div>
					Elérhetőség(ek):
				</div>
				<div>
					<input type="email" name="email" value="<?php echo $email;?>" required placeholder="E-mail">
				</div>
				<div>
					<input type="tel" name="tel" value="<?php echo $tel;?>" placeholder="Telefonszám">
				</div><hr>
				<div>
					Cím:
				</div>
				<div>
					<input type="text" name="address" value="<?php echo $address;?>" placeholder="1111 Minta Vmi ut. 11">	
				</div><hr>
    <div style="float:right">
      <button class="button" type="reset"<?php if (isset($_POST['ajax'])) {
        $script='$("#extra").slideUp();';  
        echo "onclick='".$script."'";} ?>>Mégse</button>
      <button class="button" type="submit" name="token" value="<?php if (isset($_POST['token'])) echo $_POST['token'];?>">Mentés</button>
    </div>
		</div>
  </form>
  </article>
