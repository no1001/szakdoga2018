<?php
if (!defined('included')){header("Location: foglalas");}
if ($userID<1){?>
  <article> <p>A foglaláshoz be kell jelentkeznie<br>
    <p><a href="<?php echo $domain;?>login"class="button2" style="padding: 10px">Bejelentkezés</a>
    <a href="<?php echo $domain;?>regisztracio" class="button2" style="padding: 10px">Regisztráció</a></p>
</article>
  
<?php exit;} 
$getlimit="select foglalaslimit from restaurant";
$limit=results(query($getlimit),0,0);?>
<script type="text/javascript" src="<?php echo $domain;?>res/datepicker-hu.js"></script>
<script type="text/javascript" src="<?php echo $domain;?>res/multiple-select.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/multiple-select.css">

<article><h1>Foglalásaim</h1><hr>
  <div class="mybooks">
    <?php 
		$getmybooks="select `bookingsID`, `datum`, `bookstart`, `bookend`, `erkezes`, `tavozas`, `progress`, (select name from guests where guestID=guests_guestID) from bookings where guests_userID=$userID or guests_guestID in (select guestID from guests where userID=$userID) order by progress asc, datum desc";
		$mybooks=query($getmybooks);
		if (numberofrows($mybooks)<1) echo "Még nincs";
		else {
			while ($mybook=fetch($mybooks)){?>
				<div class="mybook mod_<?php echo $mybook[6];?>">
					<div>
						Név: <?php echo $mybook[7];?>
					</div><hr>
					<div>
						Foglalás: <?php echo $mybook[1];?><br> <?php echo $mybook[2]." ~ ".$mybook[3];?>
					</div><hr>
					<div>
						Várható érkezés: <?php echo $mybook[4];?>
					</div>
					<div>
						Várható távozás: <?php echo $mybook[5];?>
					</div><hr>
					<div>
						Foglalt asztal(ok): 
						<?php $sql1="SELECT `leiras` FROM `bookings_has_tables` join tables on `tables_tablesID`=`tablesID` WHERE `bookings_bookingsID`=$mybook[0]";
							$asztalok=query($sql1);
							while($asztal=fetch($asztalok)) {echo $asztal[0].",";}
						?>
					</div><hr>
					<div>
						Foglalt ételek: 
						<?php $sql2="SELECT `leiras`,`mennyiseg`,FORMAT(price+price*(select value from afa where afaID=afa_afaID),0) as ar FROM `bookings_has_foods` join foods on foodsID=`foods_foodsID` WHERE `bookings_bookingsID`=$mybook[0]";
							$kajak=query($sql2);
							while($kaja=fetch($kajak)) {echo $kaja[0]." ".$kaja[1]." (".$kaja[2]." Ft),";}
						?>
					</div><hr>
					<div style="text-align:center;">
						<?php if ($mybook[6]<3){?>
						<form method="POST" action="<?php echo $domain;?>foglalas_lemond.php" enctype="multipart/form-data">
							<button type="button" class="button" id="late" value="<?php echo saltId($mybook[0]);?>">
								Késés
							</button>
							<button type="submit" class="button" name="token" value="<?php echo saltId($mybook[0]);?>" onClick="if (confirm('Biztosan le szeretné mondani?')) return true;else return false;">
								Lemondás
							</button>
							</form>
							<?php } ?>
							
					</div>
		</div>
			<?php }
		}
		?>
  </div>
	<div id="extra">
		
	</div>
	<small>*Az árak változhatnak</small>
</article>
<article><h1>Új foglalás</h1><hr>
  <div>
    <form method="POST" action="foglalas_save.php" enctype="multipart/form-data" id="form" class="grid" style="grid-template-columns: 100%;">
			<div>
				<label for="vendeg">Vendég: </label><select name="token" id="vendeg" style="width:100%">
				
				 <?php 
				$sql="SELECT `guestID`,`name`,`email`,`tel`,`address` FROM `guests`";
				if (getUserRank($userID)<2) {$sql=$sql." WHERE `userID`=$userID";}
				$guests=query($sql);
				while ($guest=fetch($guests)){?>
				<option value="<?php echo saltId($guest[0]);?>"><?php echo $guest[1];?> - <?php echo $guest[2];?> - <?php echo $guest[3];?> - <?php echo $guest[4];?></option>
				<?php }
				?>
				</select>
			</div>
      <div>Dátum: <input type="date" id="datepicker" name="datum" readonly></div><br>
      <div id="idopont"></div><br>
      <div id="idotartam"></div><br>
      <div id="asztal"></div><br>			
      <div id="kaja"></div><br>
      <div id="finish"></div><br>
    </form>
  </div>
</article>
<script>
  <?php 
  $getdisableddates="SELECT `date` FROM `specialdates` WHERE `open`=`close`";
  $disableddates=query($getdisableddates);
  ?>
  $(document).ready(function(){
  var array = [<?php while ($ddate=fetch($disableddates)){
  echo ('"'.$ddate[0].'",');
}?>];
$( function() {
    $( "#datepicker" ).datepicker({
      
      dateFormat: "yy-mm-dd",
      minDate: "+0d", 
      maxDate: "+<?php echo $limit;?>",
      showOtherMonths: true,
      selectOtherMonths: true,
      beforeShowDay: function(date) {
       var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
        return [ array.indexOf(string) == -1 ]
    }},
    $.datepicker.regional[ "hu" ],);
  } );
		
	$('form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
    });
  
  $('#datepicker').change(
  function(){
		$('#idopont,#idotartam,#asztal,#kaja,#finish').html("");
    $userdate=$('#datepicker').val();
    $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>inc/foglalas_function.php",
  			data: {userdate: $userdate,a: 1}
				 }).done(function(html) {
    $("#idopont").html(html);
		
  });
  }
  );
	$(document).ready(function(){
		$("#late").click(function(){
		$token=$(this).val();
		 $.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>inc/foglalas_function.php",
  			data: {token: $token,a: 7}
				 }).done(function(html) {
    $("#extra").html(html);
		
  });
		
	})
	})
	
	
   
  </script>