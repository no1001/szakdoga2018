<?php 
include "../functions.php";
if (!isset($_POST['token'])) toindex('settings/afa');
$token=$_POST['token'];
if ($token=='0'){
  $leiras=$ertek="";
  $kezd=date("Y-m-d");
  $vege="2101-01-01";
}
else{
  $afaID=getId($token,'afa','afaID');
  $sql="SELECT * FROM `afa` WHERE `afaID`=$afaID";
  $afa=query($sql);
  $leiras =results($afa,0,1);
  $ertek  =results($afa,0,2);
  $kezd   =results($afa,0,3);
  $vege   =results($afa,0,4);
}
?>
<article><form method="POST" enctype="multipart/form-data" action="afa_update_db.php">
    Leírás: <input type="text" name="leiras" value="<?php echo $leiras;?>" required>
    Érték: <input type="number" name="ertek"placeholder="1.0" step="0.01" min="0" max="1.0" value="<?php echo $ertek;?>" required>
    Érvényesség kezdete: <input type="date" name="kezd" value="<?php echo $kezd;?>">
    vége:  <input type="date" name="vege" value="<?php echo $vege;?>">
    <button class="button" type="reset"<?php 
        $script='$("#afa_desc").html("");';  
        echo "onclick='".$script."'"; ?>>Mégse</button>
      <button class="button" type="submit" name="token" value="<?php echo $token;?>">Mentés</button>
  </form>

</article>