<?php include "functions.php";
//regisztráció megkezdése
$userName=htmlspecialchars($_POST['fnev'],ENT_QUOTES);
$userPassword=($_POST['pass']);
$userEmail=$email=$_POST['email'];
$name=$userRName=htmlspecialchars($_POST['name'],ENT_QUOTES);
$tel=htmlspecialchars($_POST['tel'],ENT_QUOTES);
$address=htmlspecialchars($_POST['addr'],ENT_QUOTES);

//validálás arra az esetre ha a kliens nem tánogatja a javascriptet
 if ((strlen($_POST['fnev'])>32) || (strlen($_POST['fnev'])<6)) toindex('regisztracio&hiba=2');
  $sql="SELECT userID from users where userName collate utf8_bin like '$userName' limit 1";
  $darab=numberofrows(query($sql)); 
if ($darab>0) toindex('regisztracio&hiba=3');
if ((strlen($_POST['pass'])>32) || (strlen($_POST['pass2'])<6)) toindex('regisztracio&hiba=4');
if (($_POST['pass'])!=($_POST['pass2'])) toindex('regisztracio&hiba=5');
if (empty($_POST['email'])) toindex('regisztracio&hiba=6');
if (!isset($_POST['name'])) toindex('regisztracio&hiba=7');
if (!isset($_POST['tos'])) toindex('regisztracio&hiba=8');

//felhasználó regiszrációja
  $insertUser="insert into users (userName,userPassword,userEmail,userRName) values ('$userName',md5('$userPassword'),'$userEmail','$userRName')";
  $userID=insert($insertUser);


//ha sikertelen
  if (!($userID>0)){toindex("regisztracio&hiba=9");}
else{
//vendég regisztrációja
  $insertGuest="INSERT INTO guests(name, email, tel, address, userID) VALUES ('$name','$email','$tel','$address',$userID)";
  $guestID=insert($insertGuest);

  
//ha sikeres átdobás a bejelentkezésre, ha nem törölje a felhasználót is
if ($guestID>0){
  $ip=$_SERVER['REMOTE_ADDR'];
	$user=$userID;
	$sql = "INSERT INTO log (`whereip`, `whatcode`, `howsql`, `who_userID`) VALUES ('$ip',3,'','$user');";	
	query($sql);	
  toindex("login&msg=3");
}
else {
  $deleteuser="delete from users where userID=$userID";query($deleteuser);
	toindex("regisztracio&hiba=9");}
}
?>