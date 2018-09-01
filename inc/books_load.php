<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<2)) {echo "Próbáljon meg újra bejelentkezni";exit;}
$from=$_POST['from'];
$to=$_POST['to'];

//nem jelzett késések kezelése
query("update bookings set progress=2 where datum=CURDATE() and (CURTIME() between erkezes and tavozas) and progress=0");

//régi foglalások "frissítése"
query("update bookings set progress=6 where (datum<CURDATE() or (datum=CURDATE() and `tavozas`<CURTIME())) and progress in (0,1,2,4,5)");


$allapot=array();

$allapot[0]=" - ";
$allapot[1]="késés";
$allapot[2]="nem jelzett késés";
$allapot[3]="jelen";
$allapot[4]="távozott";
$allapot[5]="lemondva/törölve";
$allapot[6]="archív";

 /*
0- készenlét
1- késés
2- nem jelzett késés
3- jelen
4- távozott
5- lemondva/törölve
6- elmúlt/archiv
*/

$getbooks="select `bookingsID`, `datum`, `bookstart`, `bookend`, `erkezes`, `tavozas`, `progress`, (select name from guests where guestID=guests_guestID) from bookings where datum between '$from' and '$to' order by datum,bookstart";
$books=query($getbooks);


?>
<table id="foglalasok">
  <thead>
    <th>Vendég</th>
    <th>Dátum</th>
    <th>Foglalás kezdete</th>
    <th>Foglalás vége</th>
    <th>Várható érkezés</th>
    <th>Várható távozás</th>
    <th>Foglalt ételek</th>
    <th>Foglalt asztalok</th>
    <th>Állapot</th>
    <th>Művelet</th>
  </thead>
  <tbody>
    <?php 
    while ($book=fetch($books)){?>
     <tr>       
        <td class="mod_<?php echo $book[6];?>"><?php echo $book[7];?></td>
        <td class="mod_<?php echo $book[6];?>"><?php echo $book[1];?></td>
        <td class="mod_<?php echo $book[6];?>"><?php echo $book[2];?></td>
        <td class="mod_<?php echo $book[6];?>"><?php echo $book[3];?></td>
        <td class="mod_<?php echo $book[6];?>"><?php echo $book[4];?></td>
        <td class="mod_<?php echo $book[6];?>"><?php echo $book[5];?></td>
        <td class="mod_<?php echo $book[6];?>">
       <?php $sql2="SELECT `leiras`,`mennyiseg`,FORMAT(price+price*(select value from afa where afaID=afa_afaID),0) as ar FROM `bookings_has_foods` join foods on foodsID=`foods_foodsID` WHERE `bookings_bookingsID`=$book[0]";
							$kajak=query($sql2);
							while($kaja=fetch($kajak)) {echo $kaja[0]." ".$kaja[1]." (".$kaja[2]." Ft),";}
						?>
       </td>
       <td class="mod_<?php echo $book[6];?>">
       <?php $sql1="SELECT `leiras` FROM `bookings_has_tables` join tables on `tables_tablesID`=`tablesID` WHERE `bookings_bookingsID`=$book[0]";
							$asztalok=query($sql1);
							while($asztal=fetch($asztalok)) {echo $asztal[0].",";}
						?>
       </td>
       <td class="mod_<?php echo $book[6];?>"><?php echo $allapot[$book[6]];?></td>
       <td class="mod_<?php echo $book[6];?>">
			 <button type="button" title="Késés" class="late svgblock" value="<?php echo saltId($book[0]);?>" <?php if ($book[6]>2) echo "disabled";?>>
				 <svg title="Késés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="brown" d="M11 9h2v2H9V7h2v2zm-5.82 6.08a6.98 6.98 0 0 1 0-10.16L6 0h8l.82 4.92a6.98 6.98 0 0 1 0 10.16L14 20H6l-.82-4.92zM10 15a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/></svg>
				 </button>
				 <button type="button" title="Jelen" class="present svgblock" value="<?php echo saltId($book[0]);?>"  <?php if ($book[6]>2) echo "disabled";?>>
				 <svg title="Jelen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="goldenrod" d="M6 4H5a1 1 0 1 1 0-2h11V1a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V5a1 1 0 0 0-1-1h-7v8l-2-2-2 2V4z"/></svg>
				 </button>
				 <button type="button" title="Távozott" class="left svgblock" value="<?php echo saltId($book[0]);?>"  <?php if ($book[6]!=3) echo "disabled";?>>
				 <svg title="Távozott" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="darkgreen" d="M11 7l1.44 2.16c.31.47 1.01.84 1.57.84H17V8h-3l-1.44-2.16a5.94 5.94 0 0 0-1.4-1.4l-1.32-.88a1.72 1.72 0 0 0-1.7-.04L4 6v5h2V7l2-1-3 14h2l2.35-7.65L11 14v6h2v-8l-2.7-2.7L11 7zm1-3a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
				 </button>
				 <button type="button" title="Törlés" class="giveup svgblock" value="<?php echo saltId($book[0]);?>"  <?php if ($book[6]>2) echo "disabled";?>>
				 <svg title="Törlés" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="gray" d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/></svg>
				 </button>
			 </td>
    </tr> 
    <?php }
    ?>
  </tbody>
</table>
<script>
$(document).ready(function(){
	$('.late').on('click',function(){
		$token=$(this).val();
		
		$.ajax({
			method: "POST",
  		url: "<?php echo $domain;?>inc/books_function.php",
  		data: {token: $token,a: 1}
			}).done(function(html) {
      $("#messages").append(html);
			$('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")}, 500);
      });
	});	
	$('.present').on('click',function(){
		$token=$(this).val();
		
		$.ajax({
			method: "POST",
  		url: "<?php echo $domain;?>inc/books_function.php",
  		data: {token: $token,a: 3}
			}).done(function(html) {
      $("#messages").append(html);
			reflesh($('#from').val(),$('#to').val());
			$('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")}, 500);
      });
	});
	$('.left').on('click',function(){
		$token=$(this).val();
		
		$.ajax({
			method: "POST",
  		url: "<?php echo $domain;?>inc/books_function.php",
  		data: {token: $token,a: 4}
			}).done(function(html) {
      $("#messages").append(html);
			reflesh($('#from').val(),$('#to').val());
			$('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")}, 500);
      });
	});	
	$('.giveup').on('click',function(){
		$token=$(this).val();
		
		$.ajax({
			method: "POST",
  		url: "<?php echo $domain;?>inc/books_function.php",
  		data: {token: $token,a: 5}
			}).done(function(html) {
      $("#messages").append(html);
			reflesh($('#from').val(),$('#to').val());
			$('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")}, 500);
      });
	});
	
  $('#foglalasok').DataTable({
    "pageLength": 25,
		"order": [],
    buttons: [
        'copy', 'csv', 'pdf'
    ],
      fixedHeader: true,
      responsive: false,
      keys: true,
      dom: 'Bfrtip',
      ordring: false,
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
})
</script>