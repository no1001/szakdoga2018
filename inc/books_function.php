<?php 
include "../functions.php";
define('included',true);
include "errors.php";
include "messages.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<2)||(!isset($_POST['a']))) {echo "Hueston...";}

$a=$_POST['a'];
$token=$_POST['token'];
$bookingsID=getId($token,'bookings','bookingsID');

switch ($a){
   //késés form
    case ('1'): 
   
		$maxlate=results(query("select MaxLate from restaurant"),0,0);
		$i=300;
		$perc=5;?>
      <div><label for="keses">Késés mértéke:</label>
			<select class="lateselect">
				<?php 
				while ($i<=$maxlate){
					echo "<option value=$i>$perc perc</option>";
					$i=$i+300;
					$perc=$perc+5;
				}
				?>
			</select>
			<button type="button" value="<?php echo $token;?>" class="token">Mentés</button>
        
      </div>
      <script>
$('.token').on('click',function(){
		$token=$(this).val();
    $latediv=$(this).closest('div');
    $late=$latediv.find('.lateselect').val();    
		
		$.ajax({
			method: "POST",
  		url: "<?php echo $domain;?>inc/books_function.php",
  		data: {token: $token,late: $late,a: 2}
			}).done(function(html) {
      $("#messages").append(html);
      $('#messages').animate({scrollTop: $('#messages').prop("scrollHeight")}, 500);
      reflesh($('#from').val(),$('#to').val());
      });
	});
</script>
      <?php
    break;
    //késés save
    case ('2'):
    $late=$_POST['late'];
    $getprev="select bookstart,bookend from bookings where bookingsID=$bookingsID";
    $prev=query($getprev);
    $bookstart=results($prev,0,0);
    $bookend=results($prev,0,1);

    $tserkezes=strtotime($bookstart)+$late;
    $tstavozas=strtotime($bookend)+$late;

    $erkezes=date('H:i',$tserkezes);
    $tavozas=date('H:i',$tstavozas);
    
    $sql="update bookings set erkezes='$erkezes', tavozas='$tavozas', progress=1 where bookingsID=$bookingsID";

    $ok=query($sql);

    if ($ok){genlog($sql,52);message(28);}
    else {genlog($sql,53);hiba(38);}
    break;
    //jelen
    case ('3'):
    $sql="update bookings set erkezes=now(), progress=3 where bookingsID=$bookingsID";
    $ok=query($sql);

    if ($ok){genlog($sql,54);message(29);}
    else {genlog($sql,55);hiba(39);}
    break;
    //távozott
    case ('4'): 
    $sql="update bookings set tavozas=now(), progress=4 where bookingsID=$bookingsID";
    $ok=query($sql);

    if ($ok){genlog($sql,56);message(30);}
    else {genlog($sql,57);hiba(40);}
    
    break;
    //lemondta/törölve
    case ('5'): 
    $sql="update bookings set progress=5 where bookingsID=$bookingsID";
    $ok=query($sql);

    if ($ok){genlog($sql,58);message(27);}
    else {genlog($sql,59);hiba(37);}
    break;
}
?>