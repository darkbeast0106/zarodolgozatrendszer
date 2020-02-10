<?php

/*************************
	 Table names
*************************/
$lang['diakok'] = 'Diakok';
$lang['felhasznalok'] = 'Felhasznalok';
$lang['hataridok'] = 'Hataridok';
$lang['jogosultsag'] = 'Jogosultsag';
$lang['osztalyok'] = 'Osztalyok';
$lang['tanarok'] = 'Tanarok';
$lang['temak'] = 'Temak';
$lang['uzenetek'] = 'Uzenetek';
$lang['valasztott'] = 'Valasztott';

$lang['nev'] = 'Név';
/*************************
	 Table: Diakok
*************************/
$lang['diak_felh_id'] = 'OM';
$lang['diak_vnev'] = 'Vezetéknév';
$lang['diak_knev'] = 'Keresztnév';
$lang['diak_knev2'] = 'Keresztnév 2';
$lang['diak_oszt_id'] = 'Osztály';


/*************************
	 Table: Felhasznalok
*************************/
$lang['felhasznalo_id'] = 'id';
$lang['felhasznalo_nev'] = 'Felhasználónév';
$lang['felhasznalo_jelszo'] = 'Jelszó';
$lang['felhasznalo_jelszo_regi'] = 'Jelenlegi jelszó';
$lang['felhasznalo_jelszo_megerosit'] = 'Jelszó megerősítése';
$lang['felhasznalo_email'] = 'E-mail';


/*************************
	 Table: Hataridok
*************************/
$lang['hatarido_id'] = 'id';
$lang['hatarido_megnevezes'] = 'Megnevezés';
	// 'hatarido_megnevezes' has some enum values, you can name them
	$lang['kihirdetes'] = 'Kihírdetés';
	$lang['jelentkezes'] = 'Jelentkezés';
	$lang['vegleges_elfogadas'] = 'Végleges téma elfogadás';
	$lang['elso_bemutatas'] = 'Első bemutatás';
	$lang['masodik_bemutatas'] = 'Második bemutatás';
	$lang['harmadik_bemutatas'] = 'Harmadik bemutatás';
	$lang['beadas'] = 'Leadás';
$lang['hataridok_ertek'] = 'Határidő';


/*************************
	 Table: Jogosultsag
*************************/
$lang['jogosultsag_id'] = 'id';
$lang['jogosultsag_nev'] = 'Megnevezés';
$lang['konzulens'] = 'Konzulens';
$lang['osztalyfonok'] = 'Osztályfőnök';
$lang['vezetoseg'] = 'Iskola vezetőség tagja';
$lang['koordinator'] = 'Koordinátor';


/*************************
	 Table: Osztalyok
*************************/
$lang['osztaly_id'] = 'id';
$lang['osztaly_nev'] = 'Osztály neve';
$lang['osztalyfonok_id'] = 'Osztályfőnök';
$lang['vegzes_eve'] = 'Végzés éve';


/*************************
	 Table: Tanarok
*************************/
$lang['tanar_felh_id'] = 'OM';
$lang['tanar_vnev'] = 'Vezetéknév';
$lang['tanar_knev'] = 'Keresztnév';
$lang['tanar_knev2'] = 'Keresztnév 2';
$lang['tanar_ferohely'] = 'Férőhelyek száma';
$lang['tanar_jogosultsag_id'] = 'Jogosultság';


/*************************
	 Table: Temak
*************************/
$lang['tema_id'] = 'id';
$lang['kiiro_id'] = 'Kiíró tanár';
$lang['tema_cim'] = 'Téma címe';
$lang['tema_leiras'] = 'Téma leírása';
$lang['tema_eszkozok'] = 'Javasolt eszközök';
$lang['tema_evszam'] = 'Év';


/*************************
	 Table: Uzenetek
*************************/
$lang['uzenet_id'] = 'id';
$lang['kuldo_id'] = 'Küldő';
$lang['cimzett_id'] = 'Címzett';
$lang['tartalom'] = 'Tartalom';
$lang['kuldes_ideje'] = 'Küldés ideje';


/*************************
	 Table: Valasztott
*************************/
$lang['valasztott_id'] = 'id';
$lang['valaszto_diak_id'] = 'Diák';
$lang['konzulens_id'] = 'Konzulens';
$lang['valasztott_tema_id'] = 'Téma';
$lang['sajat_tema'] = 'Saját Téma';
$lang['valasztott_cim'] = 'Téma címe';
$lang['valasztott_link'] = 'Elérési link';
$lang['program_allapot'] = 'Program állapota';
$lang['dokumentacio_allapot'] = 'Dokumentáció állapota';
$lang['valasztott_status'] = 'Téma állapota';
	$lang['elutasitva'] = 'Elutasítva';
	$lang['elfogadasra_var'] = 'Elfogadásra vár';
	$lang['felt_elfogadva'] = 'Feltételesen elfogadva';
	$lang['vegleg_elfogadva'] = 'Véglegesen elfogadva';
	$lang['1_bemutatva'] = '1. Bemutatás megtörtént';
	$lang['2_bemutatva'] = '2. Bemutatás megtörtént';
	$lang['3_bemutatva'] = '3. Bemutatás megtörtént';
	$lang['leadva'] = 'Teljesen elkészült';
