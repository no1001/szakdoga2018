<?php
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<1)toindex();
$userEmail=$_POST['email'];
$userRName=htmlspecialchars($_POST['name'],ENT_QUOTES);
$rpassword=$_POST['rpass'];
if (empty($_POST['email'])) toindex('profil&hiba=6');
if (!isset($_POST['name'])) toindex('profil&hiba=7');

if(!file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name'])) {
    $sql="update users set userEmail='$userEmail', userRName='$userRName' where userID=$userID and userPassword=md5('$rpassword')";
}
else{
  $basename=saltId($userID).time();
	$previousavatar=results(query("select avatar from users where userID=$userID"),0,0);
  $path='images/avatars/';	
  include "res/upload/class.upload.php";
 
  $handle = new upload($_FILES['avatar']);
  if ($handle->uploaded) {
  $handle->file_overwrite 			= true;
  $handle->file_new_name_body   = $basename;
  $handle->image_resize         = true;
	$handle->image_ratio_crop     = true;
  $handle->image_x              = 200;
  $handle->image_y              = 200;
  $handle->process($path);
  if ($handle->processed) {    
	$avatar=$handle->file_dst_name;
  $handle->clean();
		$created=1;
  } else {
    $created=0;
    }
  }
	if ($created){
		if (($avatar!=$previousavatar)&&($previousavatar!="default.jpg")) unlink($path.$previousavatar);
		$sql="update users set userEmail='$userEmail', userRName='$userRName',avatar='$avatar' where userID=$userID and userPassword=md5('$rpassword')";}
  else $sql="update users set userEmail='$userEmail', userRName='$userRName',avatar='$avatar' where userID='' and userPassword=''";
 }

$ok=query($sql);
if ($ok){	
	genlog('',18);	
	toindex('profil&msg=12');
}
else{
	genlog('',19);
	toindex('profil&hiba=21');
}
?>