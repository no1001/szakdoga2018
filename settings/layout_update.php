<?php 
include "../functions.php";
if (!isset($_POST['token'])) toindex('settings/layout');
$token=$_POST['token'];
if ($token=='0'){
  $leiras="";
  $kezd=date("Y-m-d");
  $vege="2101-01-01";
}
else{
  $layoutID=getId($token,'layouts','layoutsID');
  $sql="SELECT * FROM `layouts` WHERE `layoutsID`=$layoutID";
  $layout=query($sql);
  $leiras =results($layout,0,1);
  $kezd   =results($layout,0,2);
  $vege   =results($layout,0,3);
}
?>
<article><form method="POST" enctype="multipart/form-data" action="layout_update_db.php">
    Leírás: <input type="text" name="leiras" value="<?php echo $leiras;?>" required>
    Érvényesség kezdete: <input type="date" name="kezd" value="<?php echo $kezd;?>">
    vége:  <input type="date" name="vege" value="<?php echo $vege;?>">
    háttérkép: <input type="file" name="background" accept="image/*" <?php if ($token=='0') echo "required";?>>
    <button class="button" type="reset"<?php 
        $script='$("#layout_desc").html("");';  
        echo "onclick='".$script."'"; ?>>Mégse</button>
      <button class="button" type="submit" name="token" value="<?php echo $token;?>">Mentés</button>
  </form>

</article>