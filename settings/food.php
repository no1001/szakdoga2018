<?php if (!defined('included')){header("Location: food");}
$sql = "SELECT foods.foodsID, foods.leiras, foods.price, foods.ervenyesFrom, foods.ervenyesTo, afa.leiras as afaleiras, afa.value as afavalue FROM `foods` join afa on `afa_afaID`=afaID ";
$etelek=query($sql);
//0-key 1-desc  2-from 3-to
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article>
  <h1>
    Ételek karbantartása
  </h1><hr>
  <div>
    <button class="button" id="new_etel" value='0'>
      Új étel felvétele
    </button>
  </div>
  <table id="etelek" style="max-width: 0;min-width:100%">
    <thead>     
      <th>Leírás</th>
			<th>Ár nettó</th>
			<th>Áfa-kulcs</th>
			<th>Ár bruttó</th>
      <th>Érvényesség kezdete</th>
      <th>Érvényesség vége</th>
			<th>Kategóriák</th>  
      <th>Művelet</th>
    </thead><tbody style="text-align:center">
<?php
while ($etel=fetch($etelek)){?>
    <tr>
      <td><?php echo $etel[1];?></td>
      <td><?php echo $etel[2];?></td>
      <td><?php echo $etel[5];?></td>
			<td><?php echo (($etel[6]+1)*$etel[2]);?></td>
			<td><?php echo $etel[3];?></td>
			<td><?php echo $etel[4];?></td>
			<td>
			<?php 
				//kategóriák kiolvasása
				$getCake="SELECT leiras FROM `foods_has_category` join category on `category_categoryID`=categoryID where `foods_foodsID`='$etel[0]'";
				$cakes=query($getCake);
				while ($cake=fetch($cakes))
				{
					echo ($cake[0].",");
				}
				?>
			</td>
			
      <td><button value="<?php echo saltId($etel[0]);?>" class="edit svgblock" type="button"><svg alt="Szerkesztés" title="Szerkesztés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path  fill="orange" d="M2 4v14h14v-6l2-2v10H0V2h10L8 4H2zm10.3-.3l4 4L8 16H4v-4l8.3-8.3zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></button></td>
    </tr>  
<?php }
?>
 </tbody></table>
</article>
<div id="etel_desc"></div>
<script>
$(document).ready( function () {
    $('#etelek').DataTable({
      
      "info": false,
      "paging": false,
      "searching": false
    });

$('#new_etel,.edit').click(function(){
  $token=$(this).val();
  $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>settings/food_update.php",
  			data: {token: $token}
				 }).done(function(html) {
    $("#etel_desc").html(html);
  });
  
});
})


</script>