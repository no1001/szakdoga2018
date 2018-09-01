<?php 
include "../functions.php";
if (!isset($_POST['token'])) toindex('settings/layout');
$token=$_POST['token'];
if ($token=='0'){
  $leiras="";
  $cap=0;
  $kezd=date("Y-m-d");
  $vege="2101-01-01";
}
else{
  $tablesID=getId($token,'tables','tablesID');
  $sql="SELECT * FROM `tables` WHERE `tablesID`=$tablesID";
  $tables=query($sql);
  $leiras =results($tables,0,1);
  $cap    =results($tables,0,2);
  $kezd   =results($tables,0,3);
  $vege   =results($tables,0,4);
}
?>
<article><form method="POST" enctype="multipart/form-data" action="table_update_db.php">
    Leírás: <input type="text" name="leiras" value="<?php echo $leiras;?>" required>
    Férőhely: <input type="text" name="cap" value="<?php echo $cap;?>" required>
    Érvényesség kezdete: <input type="date" name="kezd" value="<?php echo $kezd;?>">
    vége:  <input type="date" name="vege" value="<?php echo $vege;?>">
    <button class="button" type="reset"<?php 
        $script='$("#table_desc").html("");';  
        echo "onclick='".$script."'"; ?>>Mégse</button>
      <button class="button" type="submit" name="token" value="<?php echo $token;?>">Mentés</button>
  </form>

</article>