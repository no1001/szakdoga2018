<?php if (!defined('included')){header("Location: editaboutus");}
if ($userRank<3) toindex();
$sql="select aboutus from restaurant where restaurantID=$restaurantID";
$res=query($sql);
$aboutus=results($res,0,0);?>
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

<article>
<h1 style="font-family: 'Merienda', cursive;">
    Rólunk üzenet szerkesztése
  </h1><hr>

  <form method="POST" action="<?php echo $domain;?>settings/updateaboutus.php" enctype="multipart/form-data">
    <textarea id="editor" name="newaboutus"><?php print html_entity_decode(stripslashes($aboutus));?></textarea>
    
    <input type="reset" value="Visszaállítás" class="button" style="margin-top: 3%">
    <input type="submit" value="Mentés" class="button" style="margin-top: 3%;float: right;" id="submit">
    
  </form>

</article>