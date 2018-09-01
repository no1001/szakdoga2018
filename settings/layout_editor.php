<?php
include "../functions.php";
if (!isset($_POST['token'])) toindex('settings/category');
$token=$_POST['token'];
$sw=$_POST['sw'];
$layoutsID=getId($token,'layouts','layoutsID');
$getLayoutDescSql="select * from layouts where layoutsID=$layoutsID";
$LayoutDesc=query($getLayoutDescSql);
$leiras=results($LayoutDesc,0,1);
$ervenyesFrom=results($LayoutDesc,0,2);
$ervenyesTo=results($LayoutDesc,0,3);
$background=results($LayoutDesc,0,4);
$alreadyUsed[]="";$used[]="";$unusable[]="";

//már más elrendezésben szerepel
$getAlredyUsed="SELECT `tableID` FROM `tables_in_layouts` WHERE `layoutID` in (select layoutsID from layouts where (ervenyesFrom between '$ervenyesFrom' and '$ervenyesTo') or (ervenyesTo between '$ervenyesFrom' and '$ervenyesTo')) and layoutID!=$layoutsID ";

  $result1=query($getAlredyUsed);
  while($row1=fetch($result1)){
    $alreadyUsed[] = $row1[0]; 
  }

//még/már nem érvényes
$getUnusable="select tablesID from tables where (ervenyesFrom not between '$ervenyesFrom' and '$ervenyesTo') and (ervenyesTo not between '$ervenyesFrom' and '$ervenyesTo')";

  $result2=query($getUnusable);
  while($row2=fetch($result2)){
    $unusable[] = $row2[0]; 
  }
// az elrendezésben használva
$getInLayout="select tableID from `tables_in_layouts` WHERE `layoutID`=$layoutsID";

  $result3=query($getInLayout);
  while($row3=fetch($result3)){
    $used[] = $row3[0]; 
  }
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<article>
  <h1>
    <?php echo $leiras;?>
  </h1><hr>
  <?php 
  $getAllTable="select tablesID,leiras,cap from tables";
  $AllTable=query($getAllTable);
  while ($table=fetch($AllTable)){ ?>
  <label class="blockylabel" for="<?php echo saltId($table[0]);?>">
    <input class="tablechb" type="checkbox" id="<?php echo saltId($table[0]);?>" 
           <?php if ((in_array($table[0],$alreadyUsed,true))||(in_array($table[0],$unusable,true))){echo "disabled";}
           else {
             echo ('value="'.saltId($table[0]).'" ');
             echo ('data-leiras="'.$table[1].'" ');
             if (in_array($table[0],$used,true)) echo "checked";
             
           }?>
           >
  <?php echo $table[1];?> (<?php echo $table[2];?> fős)</label>
  <?php }
  if ($sw>800) {$size="_large";$width="800px";$height="450px";}
  if (($sw>400)&&($sw<800)) {$size="_medium";$width="400px";$height="225px";}
  if ($sw<400) {$size="_small";$width="200px";$height="113px";}
  ?>
  <hr><form method="POST" enctype="multipart/form-data" action="layout_save.php">  
  
  <div id="layout_parent" style="width:<?php echo $width;?>;height:<?php echo $height;?>; background-image: url('<?php echo $domain;?>images/layouts/<?php echo $background.$size;?>.png');">
    <?php 
    $getThoseTables="SELECT `tableID`, `positionX`, `positionY`,`leiras` FROM `tables_in_layouts` join tables on `tableID`=`tablesID` where `layoutID`=$layoutsID";
    $tablesInLayout=query($getThoseTables);
    while ($tableInLayout=fetch($tablesInLayout)){?>
      <div class="asztal_basic asztal<?php echo saltId($tableInLayout[0]);?>" style="left: <?php echo ($tableInLayout[1]*$width);?>px; top: <?php echo ($tableInLayout[2]*$height);?>px;"><?php echo $tableInLayout[3];?>
                  <input type=hidden name='asztal[<?php echo saltId($tableInLayout[0]);?>][name]' value='<?php echo saltId($tableInLayout[0]);?>'>
                  <input type=hidden class='xpoz' name='asztal[<?php echo saltId($tableInLayout[0]);?>][xpoz]' value='<?php echo ($tableInLayout[1]*$width);?>'>
                  <input type='hidden' class='ypoz' name='asztal[<?php echo saltId($tableInLayout[0]);?>][ypoz]' value='<?php echo ($tableInLayout[2]*$height);?>'>
      </div>
      
    <?php }
    ?>
    
  </div>
  <hr>
  <input type="hidden" name="sw" value="<?php echo $width;?>">
  <input type="hidden" name="sh" value="<?php echo $height;?>">
  <input type="hidden" name="token" value="<?php echo $token;?>">
  <input type="submit" class="button" value="Mentés">
  <button class="button" type="reset"<?php 
        $script='$("#layout_editor").html("");';  
        echo "onclick='".$script."'"; ?>>Mégse</button>
    </form>
  <script>
  $('.tablechb').change(function(){
    if ($(this).is(':checked')) {
    var $asztal=$("<div class='asztal_basic asztal"+$(this).attr('id')+"'>"+$(this).data('leiras')+
                  "<input type=hidden name='asztal["+$(this).attr('id')+"][name]' value='"+$(this).val()+"'><input type='hidden' class='xpoz' name='asztal["+$(this).attr('id')+"][xpoz]' value='0'><input type='hidden' class='ypoz' name='asztal["+$(this).attr('id')+"][ypoz]' value='0'></div>");
    $('#layout_parent').append($asztal);
    $asztal.draggable(
    { containment: "parent",
        drag: function(){
            var offset = $(this).position();
            var xPos = offset.left;
            var yPos = offset.top;
            $(this).children('.xpoz').val(xPos);
            $(this).children('.ypoz').val(yPos);
        }});}
    else {
      var $removable='.asztal'+$(this).attr('id');
      $($removable).empty()
      $($removable).removeClass()
      $('#layout_parent').remove($removable);
    }
  })
    $(document).ready(function(){
    $(".asztal_basic").draggable({
      containment: "parent",
        drag: function(){
            var offset = $(this).position();
            var xPos = offset.left;
            var yPos = offset.top;
            $(this).children('.xpoz').val(xPos);
            $(this).children('.ypoz').val(yPos);
        }});
      });
  </script>
</article>