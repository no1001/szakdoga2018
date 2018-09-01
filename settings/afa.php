<?php if (!defined('included')){header("Location: afa");}
$sql="select * from afa";
$afak=query($sql);
//0-key 1-desc 2-val 3-from 4-to
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article>
  <h1>
    Áfa-kulcs karbantartó
  </h1><hr>
  <div>
    <button class="button" id="new_afa" value='0'>
      Új áfakulcs felvétele
    </button>
  </div>
  <table id="afak" style="max-width: 0;min-width:100%">
    <thead>
      <th>Leírás</th>
      <th>Érték</th>
      <th>Érvényesség kezdete</th>
      <th>Érvényesség vége</th>
      <th>Művelet</th>
    </thead><tbody style="text-align:center">
<?php
while ($afa=fetch($afak)){?>
    <tr>
      <td><?php echo $afa[1];?></td>
      <td><?php echo $afa[2];?></td>
      <td><?php echo $afa[3];?></td>
      <td><?php echo $afa[4];?></td>
      <td><button value="<?php echo saltId($afa[0]);?>" class="edit svgblock" type="button"><svg alt="Szerkesztés" title="Szerkesztés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path  fill="orange" d="M2 4v14h14v-6l2-2v10H0V2h10L8 4H2zm10.3-.3l4 4L8 16H4v-4l8.3-8.3zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></button></td>
    </tr>  
<?php }
?>
 </tbody></table>
</article>
<div id="afa_desc"></div>
<script>
$(document).ready( function () {
    $('#afak').DataTable({      
      "info": false,
      "paging": false,
      "searching": false
    })})

$('#new_afa,.edit').click(function(){
  $token=$(this).val();
  $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>settings/afa_update.php",
  			data: {token: $token}
				 }).done(function(html) {
    $("#afa_desc").html(html);
  });
  
});
</script>