<?php 
include "../functions.php";
if (!isset($_POST['token'])) toindex('settings/category');
$token=$_POST['token'];
if ($token=='0'){
  $leiras="";
  $kezd=date("Y-m-d");
  $vege="2101-01-01";
}
else{
  $categoryID=getId($token,'category','categoryID');
  $sql="SELECT * FROM `category` WHERE `categoryID`=$categoryID";
  $category=query($sql);
  $leiras =results($category,0,1);
  $kezd   =results($category,0,2);
  $vege   =results($category,0,3);
}
?>
<article><form method="POST" enctype="multipart/form-data" action="category_update_db.php">
    Leírás: <input type="text" name="leiras" value="<?php echo $leiras;?>" required>
    Érvényesség kezdete: <input type="date" name="kezd" value="<?php echo $kezd;?>">
    vége:  <input type="date" name="vege" value="<?php echo $vege;?>">
    <button class="button" type="reset"<?php 
        $script='$("#kategoria_desc").html("");';  
        echo "onclick='".$script."'"; ?>>Mégse</button>
      <button class="button" type="submit" name="token" value="<?php echo $token;?>">Mentés</button>
  </form>

</article>