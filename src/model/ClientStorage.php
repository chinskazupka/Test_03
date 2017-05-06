<?php

/* Niezbędne klasy */	
require_once("model/Client.php");

/*
* Interfejs służy do izolacji od reszty aplikacji zapytań dotyczących klientów
*/

interface ClientStorage {

/* Metoda zwracająca instancję Client - przyjmuje $id lub null, jeśli żaden klient nie posiada danego identyfikatora */
	public function read($id);
/* Metoda zwracająca tablicę asocjacyjną klientów, z $id jako kluczami*/
	public function readAll();
/* Metoda dodająca nowego klienta */
	public function create(Client $a);
/* Kasuje klienta z bazy. Zwraca TRUE jeśli został skasowany i FALSE jeśli nie istniał */
  	public function delete($id);

}

?>