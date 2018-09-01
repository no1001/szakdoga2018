<?php 
include "../functions.php";
if (!isset($_POST['token'])) toindex('settings/food');
$token=$_POST['token'];
$getAfak="select * from afa";
$afak=query($getAfak);
$getKategoriak="select * from category";
$kategoriak=query($getKategoriak);
if ($token=='0'){
  $leiras="";
  $price="";
  $kezd=date("Y-m-d");
  $vege="2101-01-01";
  $hasCategory[]="";
  $afa_afaID=0;
}
else{
  $foodsID=getId($token,'foods','foodsID');
  $sql="SELECT * FROM `foods` WHERE `foodsID`=$foodsID";  
  $food=query($sql);
  
  $leiras =results($food,0,1);
  $price  =results($food,0,2);
  $kezd   =results($food,0,3);
  $vege   =results($food,0,4);
  $afa_afaID=results($food,0,5);
  
  $getFoodCateg="SELECT `category_categoryID` FROM `foods_has_category` WHERE `foods_foodsID`=$foodsID";
  $result=query($getFoodCateg);
  while($row=fetch($result)){
    $hasCategory[] = $row[0]; 
  }
}
?>
<article><form method="POST" enctype="multipart/form-data" action="food_update_db.php" >
  <table>
   <tr><td><label for="leiras">Leírás: </label></td><td><input type="text" name="leiras" id="leiras" value="<?php echo $leiras;?>" required></td></tr>
   <tr><td><label for="price">Ár (nettó ft):</label></td><td><input type="number" name="price" value="<?php echo $price;?>" id="price" required></td></tr>
   <tr><td><label for="afa">Áfa: </label></td><td><select id="afa" name="afa" required>
  <?php while ($afa=fetch($afak)){?>
  <option data-kulcs="<?php echo $afa[2];?>" value=<?php echo ('"'.saltId($afa[0]).'"'); if ($afa[0]==$afa_afaID) echo ' selected';?>><?php echo $afa[1];?></option>
  <?php } ?>
  </select></td></tr>
  <tr><td><label for="price2">Ár (bruttó ft): </label></td><td><input type="number" id="price2" readonly></td></tr>
  <tr><td><label for="kezd">Érvényesség kezdete:</label></td><td><input type="date" id="kezd" name="kezd" value="<?php echo $kezd;?>"></td></tr>
  <tr><td><label for="vege">Érvényesség vége:</label></td><td><input type="date" id="vege" name="vege" value="<?php echo $vege;?>"></td></tr>
  <tr><td>Kategóriák:</td></tr>
  <?php while ($kategoria=fetch($kategoriak)){?>
<tr>
  <td><input type="checkbox" name="kategoriak[]" id="<?php echo saltId($kategoria[0]);?>" value="<?php echo saltId($kategoria[0]);?>" <?php if (in_array($kategoria[0],$hasCategory)) echo "checked";?>>
    <label for="<?php echo saltId($kategoria[0]);?>"><?php echo $kategoria[1];?></label></td>
  </tr><?php } ?>
    <tr>
    <td><button class="button" type="reset"<?php 
        $script='$("#etel_desc").html("");';  
        echo "onclick='".$script."'"; ?>>Mégse</button></td>
      <td><button class="button" type="submit" name="token" value="<?php echo $token;?>">Mentés</button></td></tr>
  </table>
  </form>
<script>
  $(document).ready(
    function(){
    $afa=parseFloat($('#afa').find(':selected').data('kulcs'));
    $netto=parseFloat($('#price').val());
    $('#price2').val($netto*(1+$afa));
   });
  $('#price, #afa').change(function(){
    $afa=parseFloat($('#afa').find(':selected').data('kulcs'));
    $netto=parseFloat($('#price').val());
    $('#price2').val($netto*(1+$afa));
  });
  </script>
</article>