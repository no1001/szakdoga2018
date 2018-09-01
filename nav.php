<?php
if (!(defined('included'))){header("Location: /");}
$url = $_SERVER['REQUEST_URI'];?>
<ul>
  <?php if ($userID>0) {
  $getavatarsql="SELECT avatar FROM users WHERE userID=$userID";
  $avatar=results(query($getavatarsql),0,0);?>
  <li style="border-top: none;"><a href="<?php echo $domain;?>profil"><div class="avatar" style="background-image: url(<?php echo $domain."images/avatars/".$avatar;?>);">    
    </div><div class="topborder" style="width: 100%;<?php if (strpos($url, 'profil') !== false) print 'color:orange;';?>">    
    Profilom</div></a></li>  
<?php } ?>
  <li <?php if(($url==="/")||(strpos($url, 'index&') !== false)||($url==="/index")) print 'class="active"';?>><a href="<?php echo $domain;?>">Főoldal</a></li>
  <li <?php if (strpos($url, 'hirek') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>hirek">Hírek</a></li>
  <li <?php if (strpos($url, 'foglalas') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>foglalas">Foglalás</a></li>
  <?php if ($userRank>1){?>
  <li <?php if (strpos($url, 'books') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>books">Foglalás kezelés</a></li>
  <?php } ?>
  <li <?php if (strpos($url, 'etlap') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>etlap">Étlap</a></li>
  <li <?php if (strpos($url, 'galeria') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>galeria">Galéria</a></li>
  <li <?php if (strpos($url, 'rolunk') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>rolunk">Rólunk</a></li>
  <?php if ($userID<1) { ?>
  <li <?php if (strpos($url, 'login') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>login">Bejelentkezés</a></li>
  <li <?php if (strpos($url, 'regisztracio') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>regisztracio">Regisztráció</a></li>
  <?php } else {
  if ($userRank==3){ ?>
  <li <?php if (strpos($url, 'settings') !== false) print 'class="active"';?>><a href="<?php echo $domain;?>settings">Karbantartás</a></li>
  <?php } ?>
  <li><a href="<?php echo $domain;?>logout.php">Kijelentkezés</a></li>
  <?php } ?>
</ul>