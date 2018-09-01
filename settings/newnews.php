<?php if (!defined('included')){header("Location: newnews");}
$szerkeszt=false;
$writer=getUserName($userID);
if (isset($_GET['nwsid'])){
  if (getId($_GET['nwsid'],'news','newsID')>0){
  $szerkeszt=true;}
}
if ($szerkeszt){
  $newsID=getId($_GET['nwsid'],'news','newsID');
  $getnewsql="select * from news where newsID=$newsID";
  $selected_new=query($getnewsql);
  $date=results($selected_new,0,1);
  $title=results($selected_new,0,2);
  $writerId=results($selected_new,0,4);
  $writer=getUserName($writerId);
}
?>
<script src="<?php echo $domain;?>res/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'#editor', language: 'hu_HU',                       
                        plugins: [
                                  'advlist autolink link image lists charmap preview hr ',
                                  'searchreplace wordcount visualblocks visualchars code insertdatetime media ',
                                  'table contextmenu directionality emoticons paste textcolor'
                                  ],
                        toolbar: 'insertfile undo redo | cut copy paste | styleselect | bold italic underline | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview code media fullpage | forecolor backcolor emoticons',
                        height: 400
                        
});</script>
<article><p>
  Hír kiválasztása: 
  <select onchange="location = this.value;" class="formatted_select">
    <option selected disabled hidden>---Kérjük válasszon---</option>
    <?php 
    $get_news_sql="SELECT `newsID`, `submitted`, `title` FROM `news`";
    $news=query($get_news_sql);
    while($new=fetch($news)){
    ?>
    <option value="<?php echo ($domain.'settings/newnews&nwsid='.saltId($new[0]));?>"><?php echo ($new[1].' - '.$new[2].'&emsp;');?></option><?php } ?>
  </select>
  </p></article>
<article>
<h1 style="font-family: 'Merienda', cursive;">
 <?php if ($szerkeszt) print "Hír szerkesztése"; else print "Új hír beküldése";?>
  </h1><hr>
 
  <form class="newsform"method="POST" action="<?php if($szerkeszt) print ($domain."settings/updatenew.php");else print ($domain."settings/addnew.php"); ?>" enctype="multipart/form-data">
    <?php if ($szerkeszt){echo ('<input type="hidden" name=token value="'.$_GET['nwsid'].'">');} ?>
    <div><?php if (!$szerkeszt) print "Beküldő:"; else print "Utoljára módosította:";?> </div><input type="text" value="<?php print $writer;?>" disabled>
    <?php if ($szerkeszt) {?>
    <div>Beküldve: </div><input type="text" value="<?php print $date;?>" disabled>
    <?php } ?>
    <div>Cím: </div><input type="text" name='title' value="<?php if ($szerkeszt) print $title;?>" required>
    <div>Szöveg: </div><textarea id="editor" name="newcontent"><?php if($szerkeszt)print html_entity_decode(stripslashes(results(query($getnewsql),0,3)));?></textarea>
    
    <input type="reset" value="Visszaállítás" class="button">
    <input type="submit" value="<?php if ($szerkeszt) print 'Módosítás'; else print 'Beküldés';?>" class="button" id="submit">
    
  </form>

</article>