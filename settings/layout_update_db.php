<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();

$leiras=$_POST['leiras'];
$kezd=$_POST['kezd'];
$vege=$_POST['vege'];
$token=$_POST['token'];
$oke=true;
begin();
if ($token=='0'){
    $insertsql="INSERT INTO `layouts` (`leiras`, `ervenyesFrom`, `ervenyesTo`) VALUES ('$leiras','$kezd','$vege')";
    $layoutsID=insert($insertsql);
    if ($layoutsID<1) $oke=false;
    $path='../images/layouts/';	
    include "../res/upload/class.upload.php";
    $basename=saltId($layoutsID).time();
    $handle = new upload($_FILES['background']);
      if ($handle->uploaded) {
        
      $handle->file_overwrite 			= true;
      $handle->image_resize         = true;
      $handle->file_new_name_ext    = 'png';        
      $handle->file_new_name_body   = ($basename.'large');
      $handle->image_x              = 800;
      $handle->image_y              = 450;
      $handle->process($path);
      $handle->file_overwrite 			= true;
      $handle->image_resize         = true;
      $handle->file_new_name_ext    = 'png';
      $handle->file_new_name_body   = ($basename.'medium');
      $handle->image_x              = 400;
      $handle->image_y              = 225;
      $handle->process($path);
      $handle->file_overwrite 			= true;
      $handle->image_resize         = true;
      $handle->file_new_name_ext    = 'png';
      $handle->file_new_name_body   = ($basename.'medium');
      $handle->image_x              = 200;
      $handle->image_y              = 112;
      $handle->process($path);
        
      if ($handle->processed) { 
         $handle->clean();unset($handle);
         $insertBackground="UPDATE layouts set background='$basename' where layoutsID=$layoutsID";
         $ok=query($insertBackground);
        if (!$ok) $oke=false;
        }
    } else {$oke=false;}
 
}
else{
  $layoutsID=getId($token,'layouts','layoutsID');
    if(!file_exists($_FILES['background']['tmp_name']) || !(is_uploaded_file($_FILES['background']['tmp_name']))) {
      $updatesql="UPDATE layouts set `leiras`='$leiras', `ervenyesFrom`='$kezd', `ervenyesTo`='$vege' where layoutsID=$layoutsID";
      $ok=query($updatesql);
      if (!$ok) $oke=false;
    }
   else {
      $path='../images/layouts/';	
      include "../res/upload/class.upload.php";
      $basename=saltId($layoutsID).time();
	    $previousbackground=results(query("select background from layouts where layoutsID=$layoutsID"),0,0);
 
      $handle = new upload($_FILES['background']);
      if ($handle->uploaded) {
        
      $handle->file_overwrite 			= true;
      $handle->image_resize         = true;
      $handle->file_new_name_ext    = 'png';        
      $handle->file_new_name_body   = ($basename.'_large');
      $handle->image_x              = 800;
      $handle->image_y              = 450;
      $handle->process($path);
      $handle->file_overwrite 			= true;
      $handle->image_resize         = true;
      $handle->file_new_name_ext    = 'png';
      $handle->file_new_name_body   = ($basename.'_medium');
      $handle->image_x              = 400;
      $handle->image_y              = 225;
      $handle->process($path);
      $handle->file_overwrite 			= true;
      $handle->image_resize         = true;
      $handle->file_new_name_ext    = 'png';
      $handle->file_new_name_body   = ($basename.'_small');
      $handle->image_x              = 200;
      $handle->image_y              = 112;
      $handle->process($path);
        
      if ($handle->processed) { 
        $handle->clean();unset($handle);
        $updatewbgsql="UPDATE layouts set `leiras`='$leiras', `ervenyesFrom`='$kezd', `ervenyesTo`='$vege', background='$basename' where layoutsID=$layoutsID";
        
        unlink($path.$previousbackground.'_large.png');
        unlink($path.$previousbackground.'_medium.png');
        unlink($path.$previousbackground.'_small.png');
        $ok=query($updatewbgsql);
        if (!$ok) $oke=false;
        } else $oke=false;
    } else $oke=false;
   }
}

 if ($oke){commit();genlog('',42);toindex("settings/layout&msg=24");}
 else  {rollback();genlog('',43);toindex("settings/layout&hiba=33");}
?>