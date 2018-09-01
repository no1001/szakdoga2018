<?php if (!defined('included')){header("Location: naplo");}
include 'inc/events.php';

$sql="SELECT `happen`, `whereip`, `whatcode`, `userName` FROM `log` left join users on who_userID=userID where whatcode not in (0,1,2,3,16,17,18,19,28,19,30,31,32,33) order by `logID` desc LIMIT 0, 200";
$result=query($sql);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article>
<table id="naplo" class="display" style="width:100%">
  <thead>
  <tr>
    <th>Időpont</th>    
    <th>Mit</th>
    <th>Ki</th>
    <th>Honnan</th>
    </tr>
  </thead>
  <tbody>
  <?php while ($esemeny=fetch($result)){?>
    <tr>
    <td><?php print $esemeny[0];?></td>
    <td><?php print $eventcodes[$esemeny[2]];?></td>    
    <td><?php print $esemeny[3];?></td>
    <td><?php print $esemeny[1];?></td>    
    </tr>
    <?php } ?>
  </tbody>
  
</table>
</article>
<script>
  $(document).ready( function () {
    $('#naplo').DataTable({
    "pageLength": 25,
    buttons: [
        'copy', 'csv', 'pdf'
    ],
      fixedHeader: true,
      responsive: true,
      keys: true,
      dom: 'Bfrtip',
      "order": [],
      language: {
        url: '<?php echo $domain;?>res/DataTables/Hungarian.json',
            buttons: {
                copyTitle: 'Másolás',                
                copySuccess: {
                    _: '%d sor másolva',
                    1: '1 sor másolva'
                }
            }
        }
} );
} );</script>
