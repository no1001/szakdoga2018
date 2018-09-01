<?php
if (!defined('included')){header("Location: hirek");}
$sql = "SELECT newsID,title,content,submitted,avatar,userRName as author FROM `news` join users where userID=author ORDER BY submitted desc limit 0, 20";
$hirek=query($sql);
while ($hir = fetch($hirek)) {?>
<article class="hir">
<h1>
  <?php print $hir['title'];?>
  </h1><hr>
  <div>
    <?php print html_entity_decode($hir['content']);?>
  </div><hr>
  <div class="adat">
    <img class="avatar_min" src="<?php echo $domain."images/avatars/".$hir['avatar'];?>" alt="<?php print $hir['author'];?> avatárja" title="<?php print $hir['author'];?> avatárja">
     <span><?php print $hir['author'];?><br>
    <?php print $hir['submitted'];?></span>
  </div>
</article>

<?php }?>
