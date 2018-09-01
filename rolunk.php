<?php if (!defined('included')){header("Location: rolunk");}
$sql="select aboutus from restaurant where restaurantID=$restaurantID";
$res=query($sql);
$aboutus=results($res,0,0);?>
<article>
<?php print html_entity_decode(stripslashes($aboutus));?>
</article>