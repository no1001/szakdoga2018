<?php if (!defined('included')){header("Location: profil");}
if ($userID<1) toindex();
$getUserSQL="SELECT `userName`,`userEmail`,`userRName`,`avatar`,`desc` FROM `users` join ranks on `FKranksID`=`ranksID` where `userID`=$userID";
$user=query($getUserSQL);
$userName=results($user,0,0);
$userEmail=results($user,0,1);
$userRName=results($user,0,2);
$userAvatar=results($user,0,3);
$userRank=results($user,0,4);

?>
<article>
  <h1>
  Felhasználó adatai:
  </h1>
  <form method="post" enctype="multipart/form-data" action="<?php echo $domain;?>updateprofil.php">
		<div id="userform" class="grid">
			<div id="avatar_text">Avatár:</div>
			<img id="avatar_img" src="<?php echo $domain."images/avatars/".$userAvatar;?>" title="<?php echo $userRName;?> avatárja" alt="<?php echo $userRName;?> avatárja">
			<div id="avatar_input"><input type="file" name="avatar" accept="image/*"></div>
			<div id="fnev1">Felhasználónév:</div><div id="fnev2"><?php echo $userName;?></div>
			<div id="jelszo1">Jelszó:</div><div id="jelszo2"><button class="button" type="button" id="jelszomodbutton">Jelszómódosítás</button></div>
			<div id="mnev1">Megjelenített név:</div><div id="mnev2"><input name="name"type="text" required value="<?php echo $userRName;?>"></div>
			<div id="email1">E-mail cím:</div><div id="email2"><input name="email"type="email" required value="<?php echo $userEmail;?>"></div>
			<div id="rang"><?php echo $userRank;?></div>
			<div id="cpass1">Jelenlegi jelszó:</div><div id="cpass2"><input type="password" placeholder="Jelenlegi jelszó" name="rpass" required></div>
			<input id="submit" type="submit" class="button" style="width:100%;" value="Mentés">
			<input id="cancel" type="reset" class="button" style="width:100%;"value="Mégse">
		</div>
	</form>
</article>
<article style="display:none;" id="jelszomod">
  <h1>
  Jelszómódosítás:
  </h1>
  <form class="grid" style="grid-template-columns: auto auto;" method="post" enctype="multipart/form-data" action="<?php echo $domain;?>updatepassword.php">  
  <div>Új jelszó:</div><div><input type="password" placeholder="Jelszó" name="pass" id="pass" pattern=".{6,32}" required  oninvalid="this.setCustomValidity('Minimum 6, maximum 32 karakter')" oninput="setCustomValidity('')"></div>
  <div>Új jelszó mégegyszer:</div><div><input type="password" placeholder="Jelszó mégegyszer" name="pass2" id="pass2" required></div>	
	<div id="msg2" style="grid-column-end: 3;"></div>
	<div>Jelenlegi jelszó:</div><div><input type="password" placeholder="Jelenlegi jelszó" name="rpass" required></div>
		<input type="submit" class="button" value="Mentés" style="grid-column-end: 3;">
  </form>
	<script>
		$('#jelszomodbutton').click(function() {
  $('#jelszomod').slideToggle();
});
    $('#pass2').on('blur keyup',function(){			
			if (($('#pass').val())!=($('#pass2').val())) {$("#pass2").get(0).setCustomValidity('A jelszavak nem egyeznek.');
					$('#msg2').html('<span class="invalid">A jelszavak nem egyeznek</span>');}
				else {$("#pass2").get(0).setCustomValidity('');
						 $('#msg2').html('');
						 }
		});</script>
</article>
<article>
  <h1>
  Vendég/Számlázási adatok:</h1>
		<button class="button" id="newprofil">Új profil</button>
	 <div class="vendegadatok">	
		<?php 
		$sql="select * from guests where userID=$userID";		 
		$adatok=query($sql);		
		
		 $marbooked=array();
		 $sqlx="SELECT distinct `guests_guestID` from bookings join guests on `guests_guestID`=`guestID` where userID=$userID";
		 $marvanfoglalas=query($sqlx);
		 while ($mvf=fetch($marvanfoglalas)){
			 $marbooked[]=$mvf[0];
		 }	
		 
		if (numberofrows($adatok)==0){echo "Nincsennek adatok";}		 
		else{
		while($adat=fetch($adatok)){
		 $csakegy=false;
		 if (numberofrows($adatok)==1){$csakegy=true;}?>
			<div class="profil">
				<div>
					Név:
				</div>
				<div>
					<?php echo $adat[1];?>
				</div><hr>
				<div>
					Elérhetőség(ek):
				</div>
				<div>
					<?php echo $adat[2];?>
				</div>
				<div>
					<?php echo $adat[3];?>	
				</div><hr>
				<div>
					Cím:
				</div>
				<div>
					<?php echo $adat[4];?>	
				</div>
				<hr>
				<div>
					<button class="edit button" value="<?php echo saltId($adat[0]); ?>">
						Módosítás
					</button>
					
					<?php 
				if (in_array($adat[0],$marbooked,true)){
				$csakegy=true;}				
					?> 
					<?php if ($csakegy==false){ 
					?>
					<form style="display: inline-block; float:right">
					<button type="submit" onClick="if (confirm('Biztosan törölni szeretné?')) return true;else return false;" formaction="vendegprofile_delete.php" formmethod="POST" formenctype="multipart/form-data" name="token" value="<?php echo saltId($adat[0]); ?>" class="button" >
						Törlés
					</button>
					</form>
					<?php }?>
				</div>
		</div>
		<?php }}
		?>   </div>
	<script>
		//vendégprofil elérése
function getprofil($token){
	$.ajax({
				method: "POST",
  			url: "<?php echo $domain;?>vendegprofile.php",
  			data: { ajax: "b326b5062b2f0e69046810717534cb09", token: $token}
				 }).done(function(html) {
    $("#extra").html(html);
		
  });
}
		$(document).ready(function(){
	$("#newprofil").click(function(){
		getprofil('');
		$("#extra").slideDown();
		$('html, body, .content').animate({
        scrollTop: $("#extra").offset().top
    }, 1000);
	});
			
	$(".edit").click(function(){
		getprofil($(this).val());
		$("#extra").slideDown();
		$('html, body, .content').animate({
        scrollTop: $("#extra").offset().top
    }, 1000);
	});	
});
	</script>
</article>
<div id="extra" style="display:none;"></div>

<article>
<h1>Eseménynapló</h1>
<button class="button" id="pnaplo">Eseménynapló megtekintése</button>
	<div id="info"></div>
</article>
<script>
$('#pnaplo').click(function(){
	if ($('#info').html()==""){
			$.post( "<?php echo $domain;?>profil_naplo.php",{ajax: "b326b5062b2f0e69046810717534cb09"},function(html) {
  		$("#info").html(html);
			});}
	else {$("#info").html("");}
});
</script>
