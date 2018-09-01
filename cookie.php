<?php
if (!(defined('included'))){header("Location: /");}?>
<div id="cookie" style="
    position: fixed;
    width: 300px;
    height: 250px;
    min-width: 200px;
    background-image: url(<?php echo $domain;?>res/note.svg);
    bottom: 1%;
    right: 1%;
    background-size: cover;
    padding: 40px 30px 0px 30px;
    text-align: center;
    background-position-x: center;
    font-family: cursive;
    z-index: 9999;">
  <p>
    Az oldalunkon sütiket használunk<br>
    az oldal használatával ezt elfogadja</p>
    
    <button class="button2" style="width: 60%;" onclick="createcookie()">
      Értem
    </button>
  <script>
    function createcookie(){
      Cookies.set('okicookie', 'hello', { expires: 30 });
      $('#cookie').hide();
    }
  </script>
</div>