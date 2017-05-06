<?php

/* Niezbędne klasy */
require_once('model/Client.php');
require_once('model/ClientStorage.php');

/**
* Pozwala zarządzać klientami w bazie danych 
*/
class ClientStorageMySQL implements ClientStorage
{
	/* Instancja PDO - klasy łączącej się z serwerem */
	protected $pdo;

	/* Przygotowane zapytania - W atanie początkowym puste */
	/* odczytujące dane klienta */
	private $readStatement = null;
	/* tworzące nowego klienta */
	private $createStatement = null;
	/* kasujące wybranego klienta */
	private $deleteStatement = null;


	/* Twoerzenie instancji na podstawie instancji przekazanej przez animaux.php */
	function __construct($pdo)
	{
		$this->pdo = $pdo;
	}


	/**
	 * Inicjalizuję bazę - jako pustą */
	public function init() {
/*
		 * Zapytanie SQL tworzące tablicę.
		 * NB: le charset 'utf8mb4' est le vrai UTF-8. Ce que MySQL
		 * appelle UTF-8 n'est pas de l'UTF-8… et il tronquera le
		 * contenu sans rien dire!
		 * [https://mathiasbynens.be/notes/mysql-utf8mb4]
		 */
		$query = '
				USE mvc;
                DROP TABLE IF EXISTS emp_clients;
				CREATE TABLE emp_clients (
				`id_client` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(50) NOT NULL,
				`surname` varchar(50) NOT NULL,
				`email` varchar(50) NOT NULL UNIQUE,
				`status` varchar(50) NOT NULL,
				`telephone` varchar(50),
				PRIMARY KEY (`id`))
				DEFAULT CHARSET=utf8mb4;
		';
		$this->pdo->exec($query);
	}

	/**
	 * Reinicjalizuje bazę, z trzema pierwotnymi wpisami
	 */
	public function reinit() {
		$this->init();
		/*
		$this->create(new Animal('Médor', 'chien', 4));
		$this->create(new Animal('Félix', 'chat', date('Y') - 1919));
		$this->create(new Animal('Denver', 'dinosaure', 65000000));
		*/
	}


	/* IMPLEMENTING THE INTERFACE */


/* Metoda zwracająca instancję Client - przyjmuje $id lub null, jeśli żaden klient nie posiada danego identyfikatora */
	public function read($id){
		if ($this->readStatement === null) {
			/* Zapytanie nie zostało jeszcze przygotowane - dzieje się to tutaj: 
			(najczęstszy zabieg, ale niepolecany, jeśli read() będzie wielokrotnie wywoływane przy odpaleniu danej strony - nieergonomiczne )*/
			/* Zapytanie "z dziurą */
			$query = 'SELECT `name`, `surname`, `email`, `status`, `telephone` FROM `emp_clients` WHERE `id_client` = :id;';
			/* Przygotowywanie zapytania */
			$this->readStatement = $this->pdo->prepare($query);
		}
		/* Wykonywanie przygotowanego zapytania - uzupełnienie */
		$this->readStatement->execute(array(':id' => $id));
		/* Odbieranie wyniku */
		$arr = $this->readStatement->fetch();
		/* Sprawdzamy zawartość */
		/* Jeśli tablica jest pusta, znaczy to, że zapytanie nic nie zwróciło */
		if (!$arr) {
			return null;
		}
		/* Jeśli nie jest pusta, tworzymy obiekt Client na podstawie danych */
		return new Client($arr['name'], $arr['surname'], $arr['email'], $arr['status'], $arr['telephone']);
	}


/* Metoda zwracająca Listę - tablicę asocjacyjną klientów, z $id jako kluczami*/
	public function readAll(){
		$query = 'SELECT `id_client`, `name`, `surname`, `email`, `status`, `telephone` FROM `emp_clients`;';
		$res = $this->pdo->query($query);
		/* Tworzę tablicę asocjacyjną */
		$clients = array();
		while ($arr = $res->fetch()) {
			$clients[$arr['id_client']] = new Client($arr['name'], $arr['surname'], $arr['email'], $arr['status'], $arr['telephone']);
		}
		return $clients;
	}

/* Metoda dodająca nowego klienta */
	public function create(Client $a){
		if($this->createStatement === null) {
			$query = 'INSERT INTO `emp_clients` (`name`, `surname`, `email`, `status`, `telephone`) VALUES (:name, :surname, :email, :status, :telephone);';
			$this->createStatement = $this->pdo->prepare($query);
		}
		$this->createStatement->execute(array(
			':name' => $a->getName(),
			':surname' => $a->getSurname(),
			':email' => $a->getEmail(),
			':status' => $a->getStatus(),
			':telephone' => $a->getTelephone(),
		));
		return $this->pdo->lastInsertId();
	}

/* Kasuje klienta z bazy. Zwraca TRUE jeśli zosał skasowany i FALSE jeśli nie istniał */
  	public function delete($id){
		if($this->deleteStatement === null) {
			$query = 'DELETE FROM `emp_clients` WHERE `id_client` = :id';
			$this->deleteStatement = $this->pdo->prepare($query);
		}
		$this->deleteStatement->execute(array(':id' => $id));
		return $this->deleteStatement->rowCount() !== 0;
  	}

}// end of class ClientStorageMySQL
?>