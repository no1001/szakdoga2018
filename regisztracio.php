<?php if (!defined('included')){header("Location: regisztracio");}?>
<article>
<form method="post" action="<?php echo $domain;?>newuser.php"  id="reg" enctype="multipart/form-data"enctype="multipart/form-data" class="grid"
      style="grid-template-columns: auto auto;">
  <div style="grid-column-end: 3;grid-column-start:1;"><h1 style="font-family: 'Merienda', cursive;">Regisztráció</h1>
  <p>
    <small> A *-gal jelölt mezők kitöltése kötelező</small>
    </p>
  </div>
  <div><label for="fnev">Felhasználónév:<small>*</small></label></div><div>
	<input type="text" placeholder="Felhasználónév 6-32karakter" name="fnev" id="fnev" pattern=".{6,32}" required 
     autofocus><div id="msg1"></div>
	</div>
  <input type=hidden value=0  id="hiba">
  <div><label for="pass">Jelszó:<small>*</small></label></div><input type="password" placeholder="Jelszó 6-32karakter" name="pass" id="pass" pattern=".{6,32}" required  oninvalid="this.setCustomValidity('Minimum 6, maximum 32 karakter')"
    oninput="setCustomValidity('')">
  <div><label for="pass2">Jelszó mégegyszer:<small>*</small></label></div><div>
	<input type="password" placeholder="Jelszó mégegyszer" name="pass2" id="pass2" required>
	<div id="msg2">	</div>
	</div>
	<div><label for="email">E-mail cím:<small>*</small></label></div><input type="email" placeholder="E-mail" name="email" id="email" required>
	<div><label for="name">Név:<small>*</small></label></div><input type="text" placeholder="Név" name="name" id="name" required>
	<div><label for="tel">Telefonszám:</label></div><input type="text" placeholder="Telefonszám" name="tel" id="tel">
	<div><label for="addr">Cím:</label></div><input type="text" placeholder="Cim" name="addr" id="addr">
	<?php 
	$tos=results(query("select tos from restaurant"),0,0);?>
  <input type="checkbox" name="tos" id="tos" required style="justify-self:  right;" oninvalid="this.setCustomValidity('A regisztrációhoz el kell fogadnia a feltételeket')"><label for="tos">Elfogadom a <a href="<?php echo $tos;?>">Felhasználási feltételeket</a></label>
   <input class="button" id="regbutton"type="submit" value="Regisztráció"style="grid-column-end: 3;grid-column-start:1;">
   <input class="button" type="Reset" style="grid-column-end: 3;grid-column-start:1;">
  </form>
 <script>
   
   //felhaszálónév ellenőrzése 
	function checkname(){
		var fnev=$("#fnev").val();    
		$.ajax({
			url:"<?php echo $domain;?>inc/checkusername.php",
			method:"POST",
			data:{userName:fnev},
			dataType:"text",
			success:function(text){       
				$('#hiba').val(text);
				}
			});
	$( document ).ajaxStart(function(){
		$('#msg1').html('Felhasználónév ellenőrzése');
		$('#regbutton').prop('disabled', true); 
	});
	$( document ).ajaxStop(function(){		
		$('#regbutton').prop('disabled', false);
		if ($('#hiba').val()>0){
			$('#msg1').html('<span class="invalid">A felhasználónév már foglalt</span>');
			$("#fnev").get(0).setCustomValidity('A felhasználónév már foglalt');
		}
		else {$('#msg1').html('<span class="valid">A felhasználónév szabad</span>');
				 $("#fnev").get(0).setCustomValidity('');}
	});	
	}  
	 
   //form validálása =>mivel html5 addig úgyse engedi regisztrálni míg minden mező nem valid   
    $(document).ready(function(){
			$('#fnev').on('keyup paste blur',function(){
				$hosz=$('#fnev').val().length;
				$('#fnev').get(0).setCustomValidity('');
				if ($hosz<6){$('#msg1').html('<span class="invalid">A felhasználónév túlrövid</span>');
				 $("#fnev").get(0).setCustomValidity('A felhasználónév túlrövid');}
				else if ($hosz>32){$('#msg1').html('<span class="invalid">A felhasználónév túlhosszú</span>');
				 $("#fnev").get(0).setCustomValidity('A felhasználónév túlhosszú');}
				else checkname();	
			});
		//jelszavak egyezőségének ellenőrzése
		$('#pass2').on('blur keyup',function(){
			
			if (($('#pass').val())!=($('#pass2').val())) {$("#pass2").get(0).setCustomValidity('A jelszavak nem egyeznek.');
					$('#msg2').html('<span class="invalid">A jelszavak nem egyeznek</span>');}
				else {$("#pass2").get(0).setCustomValidity('');
						 $('#msg2').html('');
						 }
		});
		});
  
  </script>
</article>