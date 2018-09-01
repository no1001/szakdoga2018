<?php if (!defined('included')){header("Location: layout");}
$getLayoutsSql = "SELECT `layoutsID`, `leiras`, `ervenyesFrom`, `ervenyesTo` FROM `layouts`";
$layouts=query($getLayoutsSql);
//0-key 1-desc  2-from 3-to
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js" ></script>
<article>
  <h1>
    Elrendezés karbantartó
  </h1><hr>
  <div>
    <button class="button" id="new_layout" value='0' >
      Új elrendezés felvétele
    </button>
    <button class="button" id="new_table" value='0' >
      Új asztal felvétele
    </button>		
  </div>
	</article>
	<article>
		<h1>
			Elrendezések
		</h1><hr>
  <table id="layouts" style="max-width: 0;min-width:100%">
    <thead>     
      <th>Leírás</th>			
      <th>Érvényesség kezdete</th>
      <th>Érvényesség vége</th>
			<th>Asztalok</th>
      <th>Művelet</th>
    </thead><tbody style="text-align:center">
<?php
while ($layout=fetch($layouts)){?>
    <tr>
      <td><?php echo $layout[1];?></td>
      <td><?php echo $layout[2];?></td>      
			<td><?php echo $layout[3];?></td>
			<td><?php 
				$getTablesInLayoutSql="SELECT leiras FROM `tables_in_layouts` join tables on tables_in_layouts.tableID=tables.tablesID where `layoutID`='$layout[0]'";
				$TablesInLayout=query($getTablesInLayoutSql);
				if (numberofrows($TablesInLayout)<1){echo "Nincs";}
				else{
					while ($TableInLayout=fetch($TablesInLayout)){
						echo ($TableInLayout[0].',');
					}
				}
				?></td>	
      <td>
				<button value="<?php echo saltId($layout[0]);?>" class="ledit svgblock" type="button"><svg alt="Szerkesztés" title="Szerkesztés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path  fill="orange" d="M2 4v14h14v-6l2-2v10H0V2h10L8 4H2zm10.3-.3l4 4L8 16H4v-4l8.3-8.3zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></button>
				<button value="<?php echo saltId($layout[0]);?>" class="layoutedit svgblock" type="button"><svg alt="Módosítás" title="Módosítás" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path  fill="orange" d="M10 20S3 10.87 3 7a7 7 0 1 1 14 0c0 3.87-7 13-7 13zm0-11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg></button>
			</td>			
    </tr>  
<?php }
?>
 </tbody></table>
</article>
<div id="layout_desc"></div>
<div id="layout_editor"></div>
<article>
	<h1>
		Asztalok
	</h1><hr>
<table id="tables" style="max-width: 0;min-width:100%">
    <thead>     
      <th>Leírás</th>
			<th>Férőhely</th>
      <th>Érvényesség kezdete</th>
      <th>Érvényesség vége</th>	
      <th>Művelet</th>
    </thead><tbody style="text-align:center">
<?php
	$getTablesSql="select * from tables";
	$tables=query($getTablesSql);	
while ($table=fetch($tables)){?>
    <tr>
      <td><?php echo $table[1];?></td>
      <td><?php echo $table[2];?> fő</td>      
			<td><?php echo $table[3];?></td>
			<td><?php echo $table[4];?></td>
      <td><button value="<?php echo saltId($table[0]);?>" class="tedit svgblock" type="button"><svg alt="Szerkesztés" title="Szerkesztés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path  fill="orange" d="M2 4v14h14v-6l2-2v10H0V2h10L8 4H2zm10.3-.3l4 4L8 16H4v-4l8.3-8.3zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></button></td>
    </tr>  
<?php }
?>
 </tbody></table></article>
<div id="table_desc"></div>
<script>
$(document).ready( function () {
    $('#layouts, #tables').DataTable({
			language: {
        url: '<?php echo $domain;?>res/DataTables/Hungarian.json'}
		});

$('#new_layout,.ledit').click(function(){
  $token=$(this).val();
  $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>settings/layout_update.php",
  			data: {token: $token}
				 }).done(function(html) {
    $("#layout_desc").html(html);
		$('html, body, .content').animate({
        scrollTop: $("#layout_desc").offset().top
    }, 1000);
  });
  
});
	$('#new_table,.tedit').click(function(){
  $token=$(this).val();
  $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>settings/table_update.php",
  			data: {token: $token}
				 }).done(function(html) {
    $("#table_desc").html(html);
		$('html, body, .content').animate({
        scrollTop: $("#table_desc").offset().top
    }, 1000);
  });
  
});
	$('.layoutedit').click(function(){
  $token=$(this).val();
  $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>settings/layout_editor.php",
  			data: {token: $token, sw: $('article').width()}
				 }).done(function(html) {
    $("#layout_editor").html(html);
		$('html, body, .content').animate({
        scrollTop: $("#layout_editor").offset().top
    }, 1000);
  });
  
});
})

</script>