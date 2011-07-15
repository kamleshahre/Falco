<?php
class Help_modules{

static function reservation_help() {
return '
<div id="firstpane" class="menu_list">
  <p class="menu_head">1. Për çka shërben kategoria Rezervo?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori mundet që të rezervoni tiketa të reja, duke mbushur fushat e zbrazëta të formularit.
    </div>
  <p class="menu_head">2. Për çka shërben kategoria Listat?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori mundet që të shihni listat e udhëtarëve duke caktuar datën e udhëtimit në fushën e parë, 
        në fushën e dytë vendin e nisjes dhe në fushën e tretë vendin e mbërritjes, e pastaj klikoni butonin "Shfaqe listën".
        Pasi që të u shfaqet lista e udhëtarëve ju pastaj keni mundësinë që të shihni detajisht të gjitha informacionet si për shembull:
        Profitin, Provizionin, Informacionet e pasagjerëve dhe poashtu keni mundësinë që të i anuloni rezervimet, të i ndryshoni ose të
        printoni një tiketë të re.
    </div>
  <p class="menu_head">3. Për çka shërben kategoria Profit?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori Administratorët e sistemit mundet që të shohin profitin e bërë për të gjithë agjentët, për çdo njërin 
        muaj, duke caktuar muajn në fushën e parë dhe vitin në fushën e dytë, kurse agjentët mund të shohin vetëm profitin e tyre.
   </div>
</div>
';
}

static function users_help() {
return '
<div id="firstpane" class="menu_list">
  <p class="menu_head">1. Për çka shërben kategoria Agjentët?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori mundet që të shtoni një agjent të ri ose të menaxhoni agjentët egzistues duke pasur mundësi që të i
        fshini nga sistemi ose të i ndryshoni të dhënat e tyre.
    </div>
  <p class="menu_head">2. Për çka shërben kategoria Administratorët?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori mundet që të shtoni një administrator të ri ose të menaxhoni administratorët egzistues
        duke pasur mundësi që të i fshini nga sistemi ose të i ndryshoni të dhënat e tyre.
    </div>
</div>
';	
}

static function managment_help() {
return '
<div id="firstpane" class="menu_list">
  <p class="menu_head">1. Për çka shërben kategoria Destinacionet?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori mundet që të shtoni linjë udhëtimi të rij duke i caktuar çmimet përkatëse, ose të menaxhoni
        linjat egzistuese dhe çmimet e tyre duke përfshirë ato një drejtimëshe ose ktheyese.
        Krijimi i një linje të re bëhet duke caktuar një destinacion për një qytet domestik, te fusha e parë që shkrun "Deri:" caktohet
        destinacioni i ri për qytetin përkatës dhe pastaj pas tekstit "Çmimi:" në në fushën e parë caktohet çmimi për udhëtimet 
        një drejtimëshe dhe në fushën e dytë caktohet çmimi për udhëtimet kthyese.
    </div>
  <p class="menu_head">2. Për çka shërben kategoria Stacionet?</p>
    <div class="menu_body">
        Përgjigje: Në këtë kategori mundet që të shtoni qytetet apo stacionet e nisjeve dhe ato të mbërritjes ose të fshijni ato egzistuese.
    </div>
</div>
';	
}
	
}//End of Help_modules
?>