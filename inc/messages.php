<?php
if (!(defined('included'))){header("Location: /");}
function message($kod){
  $msg=array();
  $msg[0]="Sikeres regiszráció";
  $msg[1]="Sikeresen bejelentkezett. Üdvözöljük!";
  $msg[2]="Sikeresen kijelentkezett. Viszontlátásra!";
  $msg[3]="Sikeresen regisztrált, mostmár bejelentkezhet!";
  $msg[4]="Az üdvözlő üzenet sikeresen frissítve lett!";
  $msg[5]="A hír sikeresen publikálva!";
  $msg[6]="A hír szerkesztése sikeres!";
  $msg[7]="A felhasználó rangja sikeresen módosítva lett!";
  $msg[8]="A Rólunk üzenet sikeresen frissítve lett!";
  $msg[9]="A nyitvatartás sikeresen frissítve lett!";
  $msg[10]="A speciális dátum sikeresen felvéve!";
  $msg[11]="Sikeres jelszómódosítás";
  $msg[12]="Sikeres profilmódosítás";
  $msg[13]="A speciális dátum sikeresen frissítve!";
  $msg[14]="A speciális dátum sikeresen törölve!";
  $msg[15]="A kép(ek) sikeresen feltöltve!";
  $msg[16]="A kép(ek) sikeresen törölve!";
  $msg[17]="Adatok sikeresen felvéve";
  $msg[18]="Adatok sikeresen frissítve!";
  $msg[19]="Adatok sikeresen törölve!";
  $msg[20]="Áfa sikeresen mentve!";
  $msg[21]="Felhasználó rangja sikeresen módosítva!";
  $msg[22]="Kategória sikeresen mentve!";
  $msg[23]="Étel sikeresen mentve!";
  $msg[24]="Elrendezés sikeresen mentve!";
  $msg[25]="Asztal sikeresen mentve!";
  $msg[26]="Foglalás sikeresen rögzítve!";
  $msg[27]="Foglalás sikeresen lemondva!";
  $msg[28]="Késés sikeresen jelezve!";
  $msg[29]="Megjelenés sikeresen jelezve!";
  $msg[30]="Távozás sikeresen jelezve!";
  
  print ('<article class="message" onclick="$(this).hide()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" 
                    style="width: 30px;fill: green; align-self: center;">
                    <path d="M10 15l-4 4v-4H2a2 2 0 0 1-2-2V3c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-8zM5 7v2h2V7H5zm4 0v2h2V7H9zm4 0v2h2V7h-2z"/>
              </svg>
              <span style="border-left: 3px solid green;align-self: center;padding: 3px;">'.$msg[$kod].'</span>
           </article>');
}
?>
