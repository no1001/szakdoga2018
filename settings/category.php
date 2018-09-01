<?php if (!defined('included')){header("Location: category");}
$sql="select * from category";
$kategoriak=query($sql);
//0-key 1-desc  2-from 3-to
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article>
  <h1>
    Étel kategória karbantartó
  </h1><hr>
  <div>
    <button class="button" id="new_kategoria" value='0'>
      Új kategória felvétele
    </button>
  </div>
  <table id="kategoriak" style="max-width: 0;min-width:100%">
    <thead>
      <th>Leírás</th>     
      <th>Érvényesség kezdete</th>
      <th>Érvényesség vége</th>
      <th>Művelet</th>
    </thead><tbody style="text-align:center">
<?php
while ($kategoria=fetch($kategoriak)){?>
    <tr>
      <td><?php echo $kategoria[1];?></td>
      <td><?php echo $kategoria[2];?></td>
      <td><?php echo $kategoria[3];?></td>
      <td><button value="<?php echo saltId($kategoria[0]);?>" class="edit svgblock" type="button"><svg alt="Szerkesztés" title="Szerkesztés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path  fill="orange" d="M2 4v14h14v-6l2-2v10H0V2h10L8 4H2zm10.3-.3l4 4L8 16H4v-4l8.3-8.3zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></button></td>
    </tr>  
<?php }
?>
 </tbody></table>
</article>
<div id="kategoria_desc"></div>
<script>
$(document).ready( function () {
    $('#kategoriak').DataTable({
      
      "info": false,
      "paging": false,
      "searching": false
    });

$('#new_kategoria,.edit').click(function(){
  $token=$(this).val();
  $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>settings/category_update.php",
  			data: {token: $token}
				 }).done(function(html) {
    $("#kategoria_desc").html(html);
  });
  
});
})


</script>