<?php

/*
 * Wskazujemy, że ścieżki wszystkich zaiwranych plików
 * są relatywne od folderu src
 */
set_include_path("./src");

/* Włączenie klas potrzebnych w tym pliku */
require_once("Router.php");
/* W tym pliku tworzymy instancję połączenia z bazą */
require_once("model/ClientStorageMySQL.php");
/* Dane do połączenia z bazą, które powinny być w bezpiecznym miejscu */
require_once("model/mysql_config.php");


/* Tworzenie połączenia z bazą w obiekcie $pdo*/
$pdo = new PDO(DB, USER, PASS);
/* Dodawanie customowych opcji */
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

/* NIEAKTUALNE TREŚCI : */
/*
 * Tworzę nstancję AnimalStorageFile która będzi eużywana przez aplikację.
 * W przyszłości można ją zastąpić np bazą danych, wystarczy podmienić ten plik, aplikacja będzie działać dalej.
 *
 * UWAGA - UNIWERSYTET!!!!
 * Le serveur du département n'autorise pas PHP à écrire n'importe où.
 * En particulier, on ne peut pas passer un chemin relatif
 * au constructeur de AnimalStorageFile.
 * Pour éviter d'avoir à mettre un chemin absolu, j'utilise
 * le répertoire temporaire de PHP, accessible dans la variable
 * $_SERVER['TMPDIR']. Attention, il n'y a aucune garantie que le
 * fichier ne soit jamais effacé. C'est juste pour tester!
 * używane na uniwerku:
 * $animaldb = new AnimalStorageFile($_SERVER['TMPDIR'].'/animalfiledb.txt');
* UWAGA - miałam problem z pobieraniem tego pliku na Wampie, tylko tak działało :
$animaldb = new AnimalStorageFile('/animalfiledb.txt'); */ 

/* BAZA DANYCH!!!! To animaux.php tworzy instancję połączenia i przesyła ją do modelu*/
$clientdb = new ClientStorageMySQL($pdo);

/* Peuplement initial de la base (à décommenter temporairement si besoin). */
//$animaldb->reinit();

/* 
* Ta strona to tylko punk wejścia uzytkownika.
* Wystarczy w niej stworzyć instancję Router i odpalić jego main().
*/
$router = new Router(getenv("SCRIPT_NAME"),dirname(getenv("SCRIPT_NAME")));
/* Następnie przekazuję instancję bazy danych do main() Routera, która trafi do tworzonego tam Controllera */
$router->main($clientdb);

?>