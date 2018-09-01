<?php if (!defined('included')){header("Location: books");}
if ($userRank<2)toindex();
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article>
  <h1>Foglalás kezelés</h1><hr>
  <input type="date" id="from" value="<?php echo date('Y-m-d');?>"<label for="from">-tól</label>
  <input type="date" id="to" value="<?php echo date('Y-m-d');?>"<label for="to">-ig</label>
  <button type="button" id="keress" class="button">
    Szűrés
</button>
<hr>
<div id="foglalas">
  
</div>

</article>
<div style="min-height:600px"></div>
<div id="messages">
	
</div>
<script>
  function reflesh($from,$to){
    
     $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>inc/books_load.php",
  			data: {from: $from,to: $to}
				 }).done(function(html) {
    $("#foglalas").html(html);
  })
  }
	
$(document).ready(function(){
	reflesh($('#from').val(),$('#to').val());
	$("#keress").click(function(){
		reflesh($('#from').val(),$('#to').val());
	});
  setInterval(function(){
		reflesh($('#from').val(),$('#to').val())}
		, 300000);
	
})
</script>