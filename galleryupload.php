<?php
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<2){
  toindex();  
}

$oke=true;
$path='images/gallery/';	
  include "res/upload/class.upload.php";
$files = array();
foreach ($_FILES['images'] as $k => $l) {
  foreach ($l as $i => $v) {
  if (!array_key_exists($i, $files))
    $files[$i] = array();
    $files[$i][$k] = $v;
  }
}
begin();
foreach ($files as $file) {
  $basename=md5(time());
  
  $handle = new Upload($file);
  if ($handle->uploaded) {
    $handle->file_new_name_body= $basename;
    $handle->process($path);
    $sql="insert into gallery (name,uploader) values ('$handle->file_dst_name',$userID)";
    $handle->file_new_name_body= $basename;
    $handle->file_name_body_pre = 'thumb_';
    $handle->image_resize         = true;
    $handle->image_ratio_crop     = true;
    $handle->image_x              = 150;
    $handle->image_y              = 150;
    $handle->process($path);   
    if ($handle->processed){
    $ok=query($sql);
      if (!$ok) $oke=false;
    } else {
      $oke=false;
    }}
  $handle->clean();
  unset($handle);
}
if ($oke) {commit(); genlog('',24);toindex('galeria&msg=15');
          }
else {rollback();genlog('',25);toindex('galeria&hiba=24');
     }

?>