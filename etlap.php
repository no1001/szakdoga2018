<?php 
if (!defined('included')){header("Location: etlap");}
?>
<article style="display: inline-block; width:100%">
<h1>
  Étlap
  </h1><hr><div class="etlapparent">
  <?php 
  $getActiveCategories="select categoryID,leiras from category where now() between ervenyesFrom and ervenyesTo order by (ervenyesTo-ervenyesFrom), categoryID ";
  $kategoriak=query($getActiveCategories);
  
  while ($kategoria=fetch($kategoriak)){
    
  $getFoodsInCategory="SELECT leiras, (price*(select (value+1) from afa where afaID=afa_afaID)) as brutto FROM `foods_has_category` join foods on `foods_foodsID`=FoodsID where `category_categoryID`=$kategoria[0] and now() between ervenyesFrom and ervenyesTo "; 
   $foods=query($getFoodsInCategory);
   $foodcount=numberofrows($foods);
    if ($foodcount>=1){?>
      <div class="etlapcat">
        <h2>
          <?php echo $kategoria[1];?>
        </h2>
        <table>
          <?php while ($food=fetch($foods)){ ?>
          <tr><td><?php echo $food[0];?></td><td><?php echo number_format($food[1],0, '.', '');?> Ft</td></tr>
          <?php } ?>
        </table>
  </div>
    <?php }
  }
  ?>
    
  </div>
</article>