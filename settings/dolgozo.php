<?php if (!defined('included')){header("Location: dolgozo");}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $domain;?>res/DataTables/datatables.css">
<script src="<?php echo $domain;?>res/DataTables/datatables.min.js"></script>
<article>
  <h1>
    Dolgozók karbantartása
  </h1><hr>
<button class="button" id="newworker">
  Új dolgozó felvétele
  </button>
  <div id="newworkerdiv">
    <form method="post" enctype="multipart/form-data" action="<?php echo $domain;?>settings/dolgozo_update.php" >
      <select id="users" name="token" class="formatted_select"  required>
            <option selected disabled hidden>---Kérjük válasszon---</option>
        <?php 
        $get_not_workers_sql="SELECT `userID`,`userName`,`userRName` FROM `users` WHERE `FKranksID`=1";
        $normal_users=query($get_not_workers_sql);
        while ($user=fetch($normal_users)){ ?>
        <option value="<?php echo saltId($user[0]);?>"><?php echo $user[1];?> - <?php echo $user[2];?></option>
        <?php } ?>
      </select>
      <select name="rank" required>
        <option selected disabled hidden>---Kérjük válasszon---</option>
        <?php
        $get_ranks_sql="select * from ranks";
        $rangok=query($get_ranks_sql);
        while ($rank=fetch($rangok)){?>
        <option value="<?php echo saltId($rank[0]);?>"><?php echo $rank[1];?></option>
        <?php } ?>        
      </select>
      <input type="submit" value="Felvétel">
    </form>
  </div>
</article>
<?php
  $get_workers_sql="SELECT `userID`,`userName`,`userRName`,`userEmail`,`FKranksID` FROM `users` WHERE `FKranksID`!=1 order by `FKranksID` desc";
  $workers=query($get_workers_sql);
 ?>
<article>
  <h1>
    Dolgozók
  </h1><hr><p>
  <small>*</small> A vezetők módosítához/törléséhez vegye fel a kapcsolatot a rendszergazdájával!
  </p>
  
  <table id="workers" >
    <thead><th>Név</th><th>Felhasználónév</th><th>E-mail</th><th>Rang</th><th>Művelet</th></thead>
    <tbody>
    <?php 
      while ($worker=fetch($workers)){ ?>      
        <tr>
          <form method="post" enctype="multipart/form-data" action="<?php echo $domain;?>settings/dolgozo_update.php">
        <input type="hidden" name="token" value="<?php echo saltId($worker[0]); ?>">
          <td><?php echo $worker[2] ?></td>
          <td><?php echo $worker[1] ?></td>
          <td><?php echo $worker[3] ?></td>
          <td>
          <select name="rank" <?php if ($worker[4]==3) echo "disabled";?>>
            <?php 
            $rangok=query($get_ranks_sql);
            while ($rank=fetch($rangok)){?>
            <option value="<?php echo saltId($rank[0]);?>" <?php if ($rank[0]==$worker[4]) echo "selected";?>><?php echo $rank[1];?></option>
            <?php } ?>        
            </select>
          </td>
            <td> <?php if ($worker[4]==3) echo "Nem módosítható"; else echo '<input type="submit" value="Módosítás">';?></td>
        </form>
      </tr>
             
        
      <?php }
      ?>
    
    
    </tbody>
  </table>
</article>
<script>
  $(document).ready(function(){
    $('#newworkerdiv').hide();
    $('#workers').DataTable({
      
      "order": false,
      "info": false,
      "paging": false,
      language: {
        url: '<?php echo $domain;?>res/DataTables/Hungarian.json'}
    })
    
  });
$('#newworker').click(function(){$('#newworkerdiv').slideToggle();});
</script>