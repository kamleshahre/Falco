<?php
class Help_modules{

static function reservation_help() {
return '
<div id="firstpane" class="menu_list">
  <p class="menu_head">1. P�r �ka sh�rben kategoria Rezervo?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori mundet q� t� rezervoni tiketa t� reja, duke mbushur fushat e zbraz�ta t� formularit.
    </div>
  <p class="menu_head">2. P�r �ka sh�rben kategoria Listat?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori mundet q� t� shihni listat e udh�tar�ve duke caktuar dat�n e udh�timit n� fush�n e par�, 
        n� fush�n e dyt� vendin e nisjes dhe n� fush�n e tret� vendin e mb�rritjes, e pastaj klikoni butonin "Shfaqe list�n".
        Pasi q� t� u shfaqet lista e udh�tar�ve ju pastaj keni mund�sin� q� t� shihni detajisht t� gjitha informacionet si p�r shembull:
        Profitin, Provizionin, Informacionet e pasagjer�ve dhe poashtu keni mund�sin� q� t� i anuloni rezervimet, t� i ndryshoni ose t�
        printoni nj� tiket� t� re.
    </div>
  <p class="menu_head">3. P�r �ka sh�rben kategoria Profit?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori Administrator�t e sistemit mundet q� t� shohin profitin e b�r� p�r t� gjith� agjent�t, p�r �do nj�rin 
        muaj, duke caktuar muajn n� fush�n e par� dhe vitin n� fush�n e dyt�, kurse agjent�t mund t� shohin vet�m profitin e tyre.
   </div>
</div>
';
}

static function users_help() {
return '
<div id="firstpane" class="menu_list">
  <p class="menu_head">1. P�r �ka sh�rben kategoria Agjent�t?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori mundet q� t� shtoni nj� agjent t� ri ose t� menaxhoni agjent�t egzistues duke pasur mund�si q� t� i
        fshini nga sistemi ose t� i ndryshoni t� dh�nat e tyre.
    </div>
  <p class="menu_head">2. P�r �ka sh�rben kategoria Administrator�t?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori mundet q� t� shtoni nj� administrator t� ri ose t� menaxhoni administrator�t egzistues
        duke pasur mund�si q� t� i fshini nga sistemi ose t� i ndryshoni t� dh�nat e tyre.
    </div>
</div>
';	
}

static function managment_help() {
return '
<div id="firstpane" class="menu_list">
  <p class="menu_head">1. P�r �ka sh�rben kategoria Destinacionet?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori mundet q� t� shtoni linj� udh�timi t� rij duke i caktuar �mimet p�rkat�se, ose t� menaxhoni
        linjat egzistuese dhe �mimet e tyre duke p�rfshir� ato nj� drejtim�she ose ktheyese.
        Krijimi i nj� linje t� re b�het duke caktuar nj� destinacion p�r nj� qytet domestik, te fusha e par� q� shkrun "Deri:" caktohet
        destinacioni i ri p�r qytetin p�rkat�s dhe pastaj pas tekstit "�mimi:" n� n� fush�n e par� caktohet �mimi p�r udh�timet 
        nj� drejtim�she dhe n� fush�n e dyt� caktohet �mimi p�r udh�timet kthyese.
    </div>
  <p class="menu_head">2. P�r �ka sh�rben kategoria Stacionet?</p>
    <div class="menu_body">
        P�rgjigje: N� k�t� kategori mundet q� t� shtoni qytetet apo stacionet e nisjeve dhe ato t� mb�rritjes ose t� fshijni ato egzistuese.
    </div>
</div>
';	
}
	
}//End of Help_modules
?>