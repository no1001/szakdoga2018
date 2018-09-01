<?php include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<1)toindex();
if ((strlen($_POST['pass'])>32) || (strlen($_POST['pass2'])<6)) toindex('profil&hiba=4');
if (($_POST['pass'])!=($_POST['pass2'])) toindex('profil&hiba=5');
$rpassword=$_POST['rpass'];
$password=$_POST['pass'];
 $updatepasswordSQL="update users set userPassword=md5('$password') where userID=$userID and userPassword=md5('$rpassword')";
$ok=query($updatepasswordSQL);
if ($ok){  
  genlog('',16);
  toindex("profil&msg=11");
}
else{  
  genlog('',17);
  toindex("profil&hiba=20");
}
?>