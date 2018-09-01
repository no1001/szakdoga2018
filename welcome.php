<?php if (!defined('included')){header("Location: /");}
$sql="select welcome from restaurant where restaurantID=$restaurantID";
$res=query($sql);
$welcome=results($res,0,0);?>
<article style="
    width: 100%;
    background-image: url(res/welcome.jpg);
    background-position: center;
    background-size: cover;
    text-align: center;

">
  <!--Photo by Kaboompics // Karolina from Pexels https://www.pexels.com/photo/table-in-vintage-restaurant-6267/ -->
  
  <div style="
    background-color: rgba(0,0,0, 0.8);
    border-radius: 5%;
    display: inline-block;
    position: relative;
    max-width: 600px;
    color: wheat;
">
    <?php print html_entity_decode($welcome);?>
  </div>

  
</article>