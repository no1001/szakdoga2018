<?php
include "functions.php";
$userID=getUserID();
if ((!isset($_POST['ajax']))||($userID<1)){toindex();}
include 'inc/events.php';

$sql="SELECT `happen`, `whereip`, `whatcode`  FROM `log` where who_userID=$userID order by `logID` desc";
$result=query($sql);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>

<table id="naplo" class="display" style="width:100%">
  <thead>
  <tr>
    <th>Időpont</th>    
    <th>Esemény</th>   
    <th>IP</th>
    </tr>
  </thead>
  <tbody>
  <?php while ($esemeny=fetch($result)){?>
    <tr>
    <td><?php print $esemeny[0];?></td>
    <td><?php print $eventcodes[$esemeny[2]];?></td>   
    <td><?php print $esemeny[1];?></td>    
    </tr>
    <?php } ?>
  </tbody>
  
</table>

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
