<?php
function hiba($kod){
  $hiba=array();
  $hiba[0]="A keresett oldal nem található";
  $hiba[1]="Sikertelen bejelentkezési kísérlet, próbálja újra";
  //Sikertelen regisztráció
  $hiba[2]="Sikertelen regisztrációs kísérlet, a felhasználónév nem lehet 6-karakternél rövidebb,vagy 32 karakternél hosszabb";
  $hiba[3]="Sikertelen regisztrációs kísérlet, a felhasználónév már foglalt";
  $hiba[4]="Sikertelen regisztrációs kísérlet, a jelszó nem lehet 6-karakternél rövidebb,vagy 32 karakternél hosszabb";
  $hiba[5]="Sikertelen regisztrációs kísérlet, a jelszavak nem egyeznek";
  $hiba[6]="Sikertelen regisztrációs kísérlet, kötelező e-mail címet megadni";
  $hiba[7]="Sikertelen regisztrációs kísérlet, kötelező nevet megadni";
  $hiba[8]="Sikertelen regisztrációs kísérlet, kötelező elfogadni a feltételeinket";
  $hiba[9]="Sikertelen regisztrációs kísérlet,próbálja újra, ha a hiba fennáll kérjük jelezze";
  
  //kezdőképernyő
  $hiba[10]="Az üdvözlő üzenet nem lehet üres!";
  $hiba[11]="Az üdvözlő üzenetet nem sikerült frissíteni!";
  //hírek
  $hiba[12]="A hír szövege nem lehet üres!";
  $hiba[13]="A hírt nem sikerült publikálni!";
  $hiba[14]="A hírt nem sikerült szerkeszteni!";
  
  //dolgozó felvétele/rang módosítása
  $hiba[15]="A felhasználó rangját nem sikerült módosítani!";
  
  //rólunk
  $hiba[16]="A Rólunk üzenet nem lehet üres!";
  $hiba[17]="A Rólunk üzenetet nem sikerült frissíteni!";
  //nyitvatartás
  $hiba[18]="A nyitvatartást nem sikerült frissíteni!";
  $hiba[19]="Nem sikerült felvenni a speciális napot!";
  
  //profil
  $hiba[20]="Nem sikerült módosítani a jelszót!";
  $hiba[21]="Nem sikerült módosítani a profilját!";
  
  //nyitvatartás folyt.
  $hiba[22]="Nem sikerült frissíteni a speciális napot!";
  $hiba[23]="Nem sikerült törölni a speciális napot!";
  
  //galéria
  $hiba[24]="Nem sikerült a képfeltöltés!";
  $hiba[25]="Nem sikerült a kép(ek) törlése!";
  
  //vendégadatok
  $hiba[26]="Nem sikerült az adatok felvitele!";
  $hiba[27]="Nem sikerült az adatok frissítése!";
  $hiba[28]="Nem sikerült az adatok törlése!"; 
  
  //áfák
  $hiba[29]="Nem sikerült az áfa mentése!";
  
  //rangok
  $hiba[30]="Nem sikerült módosítani a felhasználó rangját!";
  
  //kategóriák
  $hiba[31]="Nem sikerült a kategória mentése!";
  
  //étlap
  $hiba[32]="Nem sikerült az étel mentése!";
  
  //elrendezések, asztalok
  $hiba[33]="Nem sikerült az elrendezés mentése!";
  $hiba[34]="Nem sikerült az asztal mentése!";
  
  //biztonság
  $hiba[35]="30 percen belül maximum 5-ször próbálkozhat bejelentkezéssel!";
  
  //foglalas
  $hiba[36]="Nem sikerült rögzíteni a foglalást!";
  $hiba[37]="Nem sikerült lemondani a foglalást!";
  $hiba[38]="Nem sikerült jelezni a késést!";
  $hiba[39]="Nem sikerült jelezni a megjelenést!";
  $hiba[39]="Nem sikerült jelezni a távozás!";
  
  print ('<article class="hiba"  onclick="$(this).hide()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" 
                    style="width: 30px;fill: red; align-self: center;">
                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"></path>
              </svg>
              <span style="border-left: 3px solid red;align-self: center;padding: 3px;">'.$hiba[$kod].'</span>
           </article>');
}
?>