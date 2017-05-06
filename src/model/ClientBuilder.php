<?php
/* Niezbędne klasy */
require_once('model/Client.php');

/**
* Reprezentuje instancję klasy Client podczas manipulacji 
* (tworzenia lub edycji).
* Waliduje również dane przesłane z formularza ClientForm.
*/

class ClientBuilder
{

	/* ENKAPSULACJA NAZW PÓL FORMULARZA */
	/* Nazwy pól dostępne będą tylko w tej klasie więc 
	* w razie potrzeby, wystarczy je zmienić tutal, 
	* a widoczne będą wszędzie w html */
	const NAME_REF='name';
	/* Klucz nazwiska klienta w tablicy danych */
	const SURNAME_REF='surname';
	/* Klucz emailu klienta w tablicy danych */
	const EMAIL_REF='email';
	/* Klucz statusu klienta w tablicy danych */
	const STATUS_REF='status';
	/* Klucz telefonu klienta w tablicy danych */
	const TELEPHONE_REF='telephone';

	/* ATRYBUTY */
	/* Dane z formularza, służące do stworzenia instancji Client */
	protected $data;
	/* Błędy w danych */
	private $error;
	
	/* Tworzy nową instancję na podstawie przesłanej tablicy */
	function __construct(array $data)
	{
		/* Weryfikacja istnienia pól */
		if (!key_exists(self::NAME_REF,$data)) {
			$data[self::NAME_REF] = '';
		}

		if (!key_exists(self::SURNAME_REF,$data)) {
			$data[self::SURNAME_REF] = '';
		}

		if (!key_exists(self::EMAIL_REF,$data)) {
			$data[self::EMAIL_REF] = '';
		}

		if (!key_exists(self::STATUS_REF,$data)) {
			$data[self::STATUS_REF] = '';
		}

		if (!key_exists(self::TELEPHONE_REF,$data)) {
			$data[self::TELEPHONE_REF] = '';
		}

		$this->data=$data;
		/* Przy samym tworzeniu, bez walidacji, tablica danych jest null */
		$this->error=null;
	}// end of __construct()


	/* GETTERS */ 

	/* Zwraca tablicę danych */
	public function getData()
	{
		return $this->data;
	}

	/* Zwraca błędy przesłanych danych lub null, 
	* jeśli dane nie były jeszcze walidowane */
	public function getError()
	{
		return $this->error;
	}


	/* METODY */

	/* Używa arraya z danymi z konstruktora tej klasy, z danymi nowej instancji przekazanymi przez Konstruktor  */
	public function createClient(){
		return new Client($this->data[self::NAME_REF], $this->data[self::SURNAME_REF], $this->data[self::EMAIL_REF], $this->data[self::STATUS_REF], $this->data[self::TELEPHONE_REF]);
	}

	/* Walidacja danych przesłanych z formularza */
	public function isValid()
	{
		$this->error = '';
		if ($this->data[self::NAME_REF] === '') {
			$this->error .= "Pole IMIĘ nie może być puste.";
		}
		if ($this->data[self::SURNAME_REF] === '') {
			$this->error .= "Pole NAZWISKO nie może być puste.";
		}
		if ($this->data[self::EMAIL_REF] === '') {
			$this->error .= "Pole EMAIL nie może być puste.";
		}
		if ($this->data[self::STATUS_REF] === '') {
			$this->error .= "Pole STATUS nie może być puste.";
		}
		if ($this->data[self::TELEPHONE_REF] === '') {
			$this->error .= "Pole TELEFON nie może być puste.";
		}
		return $this->error === ''; /* ???? DLACZEGO PUSTE JAK TO DZIAŁA ??? */
	}// end isValid()

}// end class ClientBuilder


?>