<?php if (!defined('included')){header("Location: nyitva");}
$sql="Select * from nyitvatartas";
$nyitvatartas=query($sql);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article><h1>
  Általános nyitvatartás
  
  </h1><hr>
<p>
  Zárvatartás esetén a két időpont legyen egyenlő (nyitás:0:01,zárás:0:01) 
  </p>
  <form method="post" enctype="multipart/form-data" action="<?php echo $domain;?>settings/updatenyitvatartas.php">
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(30%, 1fr));">
  <div>♦</div><div>Nyitás</div><div>Zárás</div>
      
  <div>Hétfő:</div><div><input type="time" name="mon_open" required value="<?php echo results($nyitvatartas,1,1);?>"></div><div><input required type="time" name="mon_close" value="<?php echo results($nyitvatartas,1,2);?>"></div>
  <div>Kedd:</div><div><input type="time" name="tue_open" required value="<?php echo results($nyitvatartas,2,1);?>"></div><div><input required type="time" name="tue_close" value="<?php echo results($nyitvatartas,2,2);?>"></div>        
  <div>Szerda:</div><div><input type="time" name="wed_open" required value="<?php echo results($nyitvatartas,3,1);?>"></div><div><input required type="time" name="wed_close" value="<?php echo results($nyitvatartas,3,2);?>"></div>
  <div>Csütörtök:</div><div><input type="time" name="thu_open" required value="<?php echo results($nyitvatartas,4,1);?>"></div><div><input required type="time" name="thu_close" value="<?php echo results($nyitvatartas,4,2);?>"></div>
  <div>Péntek:</div><div><input type="time" name="fri_open" required value="<?php echo results($nyitvatartas,5,1);?>"></div><div><input required type="time" name="fri_close" value="<?php echo results($nyitvatartas,5,2);?>"></div>
  <div>Szombat:</div><div><input type="time" name="sat_open" required value="<?php echo results($nyitvatartas,6,1);?>"></div><div><input required type="time" name="sat_close" value="<?php echo results($nyitvatartas,6,2);?>"></div>
  <div>Vasárnap:</div><div><input type="time" name="sun_open" required value="<?php echo results($nyitvatartas,0,1);?>"></div><div><input required type="time" name="sun_close" value="<?php echo results($nyitvatartas,0,2);?>"></div>
        <input type="reset" class="button" value="Mégse"><div></div>
      <input type="submit" class="button" value="Mentés">
    </div>
    <input type="hidden" value="<?php echo md5(date('Y-m-d'));?>" name="token">
    </form>
  
</article>
<article>
<h1>
  Speciális napok
  </h1><hr>
<form method="post" enctype="multipart/form-data" action="<?php echo $domain;?>settings/specdate.php?a=<?php echo md5('1');?>">
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(40%, 1fr));">
      <div>Dátum:</div><input type="date" name="spec_day" required min="<?php print date("Y-m-d");?>">
      <div>Zárva:</div><input type="checkbox" class="zarvae">
      <div>Nyitás:</div><input type="time" name="spec_open" class="spec_open" required>
      <div>Zárás:</div><input type="time" name="spec_close" class="spec_close" required>
      <input type="reset" class="button" value="Mégse" required>
      <input type="submit" class="button" value="Mentés" required>
  </div></form>

  
<table id="napok" style="min-width:100%;max-width:0;text-align: center;">
  <thead>
  
    <th>Dátum</th>
    <th>Zárva</th>
    <th>Nyitás</th>
    <th>Zárás</th>
    <th>Művelet</th>
    
  </thead>
  <tbody>
  <?php 
    function checkschedule($date){
      if ($date<date('Y-m-d')) echo "style='background-color: lightgray'";
      if ($date>date('Y-m-d')) echo "style='background-color: ghostwhite'";
      if ($date==date('Y-m-d')) echo "style='background-color: lightgreen'";
    }
    $sql="SELECT * FROM `specialdates` order by date asc";
    $ds=query($sql);
    while ($d=fetch($ds))
    {?>
   
    <tr <?php checkschedule($d[1]);?>>
      <form method="POST" enctype="multipart/form-data">  
      <td><input type='date' class="date" name="spec_day"value="<?php echo $d[1];?>" disabled required></td>
      <td><input type='checkbox' class="zarva_box" <?php if ($d[2]==$d[3]){echo "checked";} ?> disabled></td>
      <td><input type='time' class="open" name="spec_open" value="<?php echo $d[2];?>" disabled required></td>
      <td><input type='time' class="close"name="spec_close" value="<?php echo $d[3];?>" disabled required></td>
      <td>
        
        <button class="edit svgblock" type="button"><svg alt="Szerkesztés" title="Szerkesztés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="green" d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></button>
        <button class="save svgblock" name='token' value="<?php echo saltId($d[0]);?>" type="submit" formaction="<?php echo $domain;?>settings/specdate.php?a=<?php echo md5('2');?>"disabled><svg alt="Mentés" title="Mentés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#004BFF" d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/></svg></button>
        <button class="cancel svgblock" type="button" disabled><svg alt="Mégse" title="Mégse" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path path fill="red" d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"/></svg></button>
        <button class="delete svgblock" name='token' onClick="if (confirm('Biztosan törölni szeretné?')) return true;else return false;" value="<?php echo saltId($d[0]);?>" type="submit" formaction="<?php echo $domain;?>settings/specdate.php?a=<?php echo md5('3');?>"><svg alt="Törlés" title="Törlés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="gray" d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/></svg></button>
        
      </td></form></tr>
      
   <?php }
    ?>
  </tbody>
  
</table>

<script>
  $(document).on('click','.edit',function(){
    $(":input:not(:button)").prop( "disabled", true );
    var row = $(this).closest('tr');
    $('.date,.open,.close,.save,.cancel,.zarva_box').prop( "disabled", true );
      row.find('.delete,.edit').prop( "disabled", true );
      row.find('.date,.open,.close,.save,.cancel,.zarva_box').prop( "disabled", false );
      
    });
  $(document).on('click','.cancel',function(){
    $(':input').prop( "disabled", false );
    $('.date,.open,.close,.save,.cancel,.zarva_box').prop( "disabled", true );    
  });
  $('.zarva_box').change(function() {
    var row = $(this).closest('tr');
   if($(this).is(":checked")) {
     row.find('.open,.close').val( "00:01" );
     
     
   }
   
});
  
   $('.zarvae').change(function() {
   if($(this).is(":checked")) { 
     $('.spec_open,.spec_close').val( "00:01" );  
     
   }
   
});
  $(document).ready( function () {
    $('#napok').DataTable({
      
      "info": false,
      "paging": false,
      "searching": false,
      "ordering":  false
    })})
  </script>
</article>