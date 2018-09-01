<?php
if (!defined('included')){header("Location: galeria");}?>
<script type="text/javascript" src="<?php echo $domain;?>res/mp/jquery.magnific-popup.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/mp/magnific-popup.css"/>


<?php
if ($userRank>1){?>
<article>
<button class="button" onclick="$('#theform').slideToggle()">Képfeltöltés</button>
<button class="button" onClick="if (confirm('Biztosan törölni szeretné?')) $('#deleteform').submit();else return false;">Kijelöltképek törlése</button>
<div id="theform" style="display:none">
  <form method="post" enctype="multipart/form-data" action="<?php echo $domain;?>galleryupload.php" >  
 <input type="file" name="images[]" accept="image/*" multiple>
  <input type="submit" value="Feltöltés" class="button">
   </form> 
  </div>

</article><?php }?>
<?php if ($userRank>1){echo '<form id="deleteform" action="'.$domain.'deleteimage.php" method="POST" enctype="multipart/form-data">';}?>
<article>
  <h1>
    Galéria
  </h1><hr>
  <div class="galeria"> 
  <?php 
  $sql = "SELECT `image_id`,`name`,`upload`,(select userRName from users where userID=`uploader`) as uploader FROM `gallery`";
  $kepek=query($sql);
  while ($kep = fetch($kepek)){?>
    <div>   
<a href="<?php echo $domain;?>images/gallery/<?php echo $kep[1];?>"><img src="<?php echo $domain;?>images/gallery/thumb_<?php echo $kep[1];?>" alt="Faust Étterem galéria kép" title="Feltöltő: <?php echo $kep[3];?> <?php echo $kep[2];?>"></a>
 <?php  if ($userRank>1){
  ?> 
   <input type="checkbox" name="going_to_be_deleted[]" value="<?php echo saltId($kep[0]);?>">      
  <?php } ?>
  </div>
  <?php }?>     
  </div>
</article>
<?php if ($userRank>1){echo '</form>';}?>
<script>
$('.galeria').magnificPopup({
  delegate: 'a',
  type: 'image',
  gallery:{enabled:true}
});
</script>
