###################
Záródolgozat rendszer
###################

A záródolgozat témaválasztás és konzultáció egyszerűsítésére készült rendszer.

*******************
Server Követelmények
*******************

PHP 5.4 vagy újabb ajánlott.

************
Telepítés
************

- Importálja a zarodolgozatrendszer.sql fájl a szerverre.

- application/config mappán belül a config.php 26. sorában a $config['base_url'] értékét állítsa be arra az url-re ahol az alkalmazás lesz elérhető pl.: http://www.example.com

- Ugyanebben a mappában található database.php-ban állítsa be az adatbázis kapcsolódásához szükséges adatokat (78-82. sor). 
