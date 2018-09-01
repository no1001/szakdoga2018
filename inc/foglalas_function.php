<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<1)||(!isset($_POST['a']))) {echo "Próbáljon meg újra bejelentkezni";exit;}

//egyáltalán nyitva vagyunk-e és ilyen nyitvatartással
 function checkIfOpen($date){
   $checkifspecificSql="SELECT  IF(  `open` =  `close` ,  'Zárva',  'Nyitva' ) as nyitvae FROM  `specialdates` WHERE  `date` =  '$date'";
   $checkifspecific=query($checkifspecificSql);
   if (numberofrows($checkifspecific)==0){
     $dayofweek = date('w', strtotime($date));
     $checkifopenSql="SELECT  IF(  `open` =  `close` ,  'Zárva',  'Nyitva' ) as nyitvae FROM  `nyitvatartas` WHERE  `nap` =  '$dayofweek'";
     $nyitvae=results(query($checkifopenSql),0,0);
     if ($nyitvae=="Nyitva") return '1';
     else return '0';
   }
   else {
     $nyitvae=results(query($checkifspecificSql),0,0);
     if ($nyitvae=="Nyitva") return '3';
     else return '0';
   }
   
 }

//mikor nyitunk
function getOpening($nyitva,$date){
  if ($nyitva==1){
    $dayofweek = date('w', strtotime($date));
    $openSql="SELECT  `open`  FROM  `nyitvatartas` WHERE  `nap` =  '$dayofweek'";     
  }
  if ($nyitva==3){$openSql="SELECT  `open`  FROM  `specialdates` WHERE  `date` =  '$date'";}
  $open=results(query($openSql),0,0);
  return $open;
}

//mikor zárunk
function getClosing($nyitva,$date){
  if ($nyitva==1){
    $dayofweek = date('w', strtotime($date));
    $closeSql="SELECT  `close`  FROM  `nyitvatartas` WHERE  `nap` =  '$dayofweek'";     
  }
  if ($nyitva==3){$closeSql="SELECT  `close`  FROM  `specialdates` WHERE  `date` =  '$date'";}
  $close=results(query($closeSql),0,0);
  return $close;
}

//Minimális foglalás
function getMinFoglalas(){
  $getMinFoglalasSql="select MinFoglalas from restaurant";
  $minfoglalas=results(query($getMinFoglalasSql),0,0);
  return $minfoglalas;
}

//maximális foglalás
function getMaxFoglalas(){
  $getMaxFoglalasSql="select MaxFoglalas from restaurant";
  $maxfoglalas=results(query($getMaxFoglalasSql),0,0);
  return $maxfoglalas;
}

//utolsó lehetséges foglalás
function getLastBook($close,$min){    
  $timestramp=strtotime($close."-1 sec")-$min;
  $lastbook=date('H:i',$timestramp);
  return $lastbook;
}

switch ($_POST['a']){
    //időpont választó
  case ('1'):
    $userdate=$_POST['userdate'];
    if (checkIfOpen($userdate)=='0') echo "<span class='invalid'>Zárva vagyunk</span>";
    else {
      if (checkIfOpen($userdate)=='3') {$open=getOpening(3,$userdate);$close=getLastBook(getClosing(3,$userdate),getMinFoglalas());}
        else {$open=getOpening(1,$userdate);$close=getLastBook(getClosing(1,$userdate),getMinFoglalas());}?>
      <label for='usertime'>Időpont: (<?php echo $open;?> és <?php echo $close;?> között)</label>
      <input type='hidden' value='<?php echo checkIfOpen($userdate);?>'>
      <input type='time' name='usertime' id='usertime' min='<?php echo $open;?>' max='<?php echo $close;?>' step='300'  required> 

       <script>
      $(document).ready(function(){
         $('#usertime').change(function(){
					 $('#idotartam,#asztal,#kaja,#finish').html("");
            $userdate=$('#datepicker').val();
            $usertime=$('#usertime').val();
            $.ajax({
				        method: "POST",
  			          url: "<?php echo $domain;?>inc/foglalas_function.php",
  			          data: {userdate: $userdate,nyitva: <?php echo checkIfOpen($userdate);?>,usertime: $usertime,a: 2}
				     }).done(function(html) {
            $("#idotartam").html(html);		
  });
      })
      });
</script> 
    <?php } break;
    //időtartam választó
  case ('2'):
    $userdate=$_POST['userdate'];
    $nyitva=$_POST['nyitva'];
    $usertime=$_POST['usertime'];
    $close=getClosing($nyitva,$userdate);
    $minfoglalas=getMinFoglalas();  
    
    if (($usertime>=getLastBook($close,$minfoglalas))||($usertime<=date('H:i', strtotime(getOpening($nyitva,$userdate)."- 1 sec")))){echo "<span class='invalid'>Kérjük a megadott intervallumba eső időpontot válasszon!</span>";}
    else{
    $maxfoglalas=getMaxFoglalas();
    $i=$minfoglalas;
    $perc=60;
    $difference=strtotime($close)-strtotime($usertime);?>
   <label for="useridotartam">Időtartam: </label><select id="useridotartam" name="useridotartam">
     <option selected disabled hidden>---Kérjük válasszon---</option>
     <?php 
     while (($i<=$difference)&&($i<=$maxfoglalas)){?>
       <option value='<?php echo $i;?>'><?php echo $perc;?> perc</option>
     <?php 
       $perc=$perc+5;
       $i=$i+5*60;}
     ?>
</select>
<script>
      $(document).ready(function(){
         $('#useridotartam').change(function(){
					 $('#asztal,#kaja,#finish').html("");
            $userdate=$('#datepicker').val();
            $usertime=$('#usertime').val();
            $useridotartam=$("#useridotartam").val();
            $sw=$("article").width();
           
            $.ajax({
				        method: "POST",
  			          url: "<?php echo $domain;?>inc/foglalas_function.php",
  			          data: {userdate: $userdate,nyitva: <?php echo checkIfOpen($userdate);?>,usertime: $usertime,useridotartam: $useridotartam,sw: $sw,a: 3},
									timeout: 300000
				     }).done(function(html) {
            $("#asztal").html(html); });
					 
					 $.ajax({
				        method: "POST",
  			          url: "<?php echo $domain;?>inc/foglalas_function.php",
  			          data: {a: 4}
				     }).done(function(html) {
            $("#kaja").html(html);
      		});
					 $.ajax({
				        method: "POST",
  			          url: "<?php echo $domain;?>inc/foglalas_function.php",
  			          data: {a: 6}
				     }).done(function(html) {
            $("#finish").html(html);
      		})
      });})
</script> 
    <?php } break;
    //asztal választó
  case ('3'):
		$userdate=$_POST['userdate'];
		$usertime=$_POST['usertime'];
		$useridotartam=$_POST['useridotartam'];
		$usertavozas=date('H:i',(strtotime($usertime)+$useridotartam));
		$sw=$_POST['sw'];
		$getAllLayouts="select layoutsID, leiras from layouts where '$userdate' between ervenyesFrom and ervenyesTo";
		$layouts=query($getAllLayouts);
		$alreadyBooked[]="";
		$getAlreadyBooked="SELECT `tables_tablesID` FROM `bookings_has_tables` join bookings on `bookings_bookingsID`=bookingsID where datum='2018-03-28' and ('08:55' between `erkezes` and `tavozas`) and ('10:30' between `erkezes` and `tavozas`) and progress not in (4,5)";

	$result1=query($getAlreadyBooked);
  while($row1=fetch($result1)){
    $alreadyBooked[] = $row1[0]; 
  }
		
?> 
    <label for="userasztal">Asztal(ok): </label><select id="userasztal"  multiple="multiple">
      <?php 
		
		while ($layout=fetch($layouts)){ ?>
			<optgroup label="<?php echo $layout[1];?>">
			<?php 
				$getTables="select tableID,leiras,cap from tables_in_layouts join tables on tableID=tablesID where layoutID=$layout[0] and '$userdate' between ervenyesFrom and ervenyesTo";
				$result2=query($getTables);
				while ($asztal=fetch($result2)){?>
					<option value="<?php echo saltId($asztal[0]);?>" id="<?php echo saltId($asztal[0]);?>" data-cap="<?php echo $asztal[2];?>" <?php if ((in_array($asztal[0],$alreadyBooked,true))||($asztal[2]<1)) echo "disabled";?>><?php echo $asztal[1];?> (<?php echo $asztal[2];?> fős)</option>
				<?php }
				?>
			</optgroup>
			<?php }?>
			
        
    </select>
<?php 
		if ($sw>800) {$size="_large";$width="800px";$height="450px";}
  	if (($sw>400)&&($sw<800)) {$size="_medium";$width="400px";$height="225px";}
  	if ($sw<400) {$size="_small";$width="200px";$height="113px";}
		$getLayout2="select layoutsID from layouts where '$userdate' between ervenyesFrom and ervenyesTo";
		$layouts2=query($getLayout2);	
		
		while ($layout2=fetch($layouts2)){
		$layoutsID=$layout2[0];
		$getLayoutDescSql="select * from layouts where layoutsID=$layoutsID";
		$LayoutDesc=query($getLayoutDescSql);
		$leiras=results($LayoutDesc,0,1);
		$background=results($LayoutDesc,0,4);
		?>
	<p>
		<?php echo $leiras;?>:
</p>
	<div id="layout_parent" style="width:<?php echo $width;?>;height:<?php echo $height;?>; background-image: url('<?php echo $domain;?>images/layouts/<?php echo $background.$size;?>.png');">
    <?php 
    $getThoseTables="SELECT `tableID`, `positionX`, `positionY`,`leiras`,`cap` FROM `tables_in_layouts` join tables on `tableID`=`tablesID` where `layoutID`=$layoutsID";
    $tablesInLayout=query($getThoseTables);
    while ($tableInLayout=fetch($tablesInLayout)){
		if ((!(in_array($tableInLayout[0],$alreadyBooked,true)))&&(!($tableInLayout[4]<1))){
		?>
		
      <div class="asztal_basic asztal<?php echo saltId($tableInLayout[0]);?>" style="left: <?php echo ($tableInLayout[1]*$width);?>px; top: <?php echo ($tableInLayout[2]*$height);?>px;">
				<input type=checkbox name='asztal[]' class="grafic" value='<?php echo saltId($tableInLayout[0]);?>' id='asztal_<?php echo saltId($tableInLayout[0]);?>'><label for='asztal_<?php echo saltId($tableInLayout[0]);?>'><?php echo $tableInLayout[3];?></label>
                  
      </div>
      
    <?php } }
    ?>
    
  </div>

			
<?php } ?>
    <script>
    $(document).ready(function(){
       $('#userasztal').multipleSelect({
         placeholder: "Kérjük válasszon",
         width: '100%',
         selectAll: false,
         minimumCountSelected: 100
       });
			
			 $('.grafic, .ms-parent :checkbox').change(function(){
				 if( $(this).is(':checked') ){
					 $(":checkbox[value="+$(this).val()+"]").prop("checked",true);
					 
				 }
				 else {
					 $(":checkbox[value="+$(this).val()+"]").prop("checked",false);
				 }
				 })	
  });
			
    </script>
<?php break;
		
	//ételfoglalás
	case ('4'): ?>
		<p>Ételfoglalás<small>(Nem kötelező)</small><br>
		<button type="button" title="Új" class="svgblock" id="new"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="green" d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/></svg></button>			
		</p>
			<script>
		$('#new').click(
		function(){
			$.ajax({
				        method: "POST",
  			          url: "<?php echo $domain;?>inc/foglalas_function.php",
  			          data: {userdate: $userdate,a: 5}
				     }).done(function(html) {
            $("#kaja").append(html);
      		})
		})
		</script>

<?php
		break;	
	case ('5'):	
		$userdate=$_POST['userdate'];
		$sql="SELECT distinct `foodsID`,`leiras`,(`price`+`price`*(select value from afa where afaID=`afa_afaID`)) FROM foods_has_category join foods on foods_foodsID=`foodsID` where '$userdate' between ervenyesFrom and ervenyesTo and `category_categoryID` in (select categoryID from category where '$userdate' between ervenyesFrom and ervenyesTo)";
		$kajak=query($sql);
		$time=time();
		echo '<div class="flex"> <select name="foglaltkaja['.$time.'][1]">';
		while ($kaja=fetch($kajak)){?>
		<option value="<?php echo saltId($kaja[0]);?>"><?php echo $kaja[1];?> - (<?php echo number_format($kaja[2],0, '.', '');?> Ft)</option> 
		<?php } ?>
</select>
<label for="q<?php echo $time;?>">mennyiség</label>
<input type="number" placeholder="mennyiség" id="q<?php echo $time;?>" name=foglaltkaja[<?php echo $time;?>][2] required>
<button type="button" class="svgblock remove">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="red" d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm5-9v2H5V9h10z"/></svg>
</button></div>
<?php break;
	case ('6'):?>
<span id="hiba" class="invalid"></span><br>
<input type="button" class="button2" value="Foglalás" id="book">
<script>
	$(document).ready(function(){
		$('#book').click(function(){
			if ($("input[type='checkbox']:checked").length > 0){
				$('#form').submit();
			}
			else $('#hiba').text("Kérjük válasszon asztalt");
		});
		
		$(document).on('click','.remove', function(){
			var removable=$(this).closest('.flex');
			removable.empty();
			removable.html("");
			removable.remove();
		})
	})
	

</script>
<?php break;
	case ('7'):
		$token=$_POST['token'];
		$bookingsID=getId($token,'bookings','bookingsID');
		$maxlate=results(query("select MaxLate from restaurant"),0,0);
		$i=300;
		$perc=5;?>
		<form method="POST" action="<?php echo $domain;?>foglalas_keses.php" enctype="multipart/form-data">
			<label for="keses">Késés mértéke:</label>
			<select name="late">
				<?php 
				while ($i<=$maxlate){
					echo "<option value=$i>$perc perc</option>";
					$i=$i+300;
					$perc=$perc+5;
				}
				?>
			</select>
			<button type="submit" value="<?php echo $token;?>" name="token">Mentés</button>
</form>
		<?php
		break;
}

?>