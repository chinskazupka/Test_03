<?php

/* Potrzebne klasy */
require_once('view/View.php');
require_once('model/Client.php');
/* Odwołujemy się wszędzie bezpośrednio do interfejsu */
require_once('model/ClientStorage.php');
require_once('model/ClientBuilder.php');


/*
* Kontroler wykonuje polecenia i wypełnia widok
*/
class Controller{

	/* Atrybut zawiera Widok wykorzystywany przez Kontroler w celu wyświetlenia HTML */
	protected $view;
	/*"Baza danych" zawietrająca dane o klientach */
	protected $clientdb;

	
	
	public function __construct(View $view, ClientStorage $clientdb){
		$this->view=$view;
		/* Tworzymy instancję ClientStorage - interfejsu modelu */
		$this->clientdb=$clientdb;
	}

	/* Przekazuje potrzebne widokowi informacje */
	/* $id pochodzi z adresu URL */
	public function showInformation($id){
		$client = $this->clientdb->read($id);
		if ($client!== null) {
			$this->view->makeClientPage($id, $client);
		}else{
			$this->view->makeUnknownClientPage();
		}
	}

	/* Wywołuje pokazanie listy zwierząt w widoku */
	public function showList(){
		$this->view->makeListPage($this->clientdb->readAll());
	}

	/* Wywołuje z View stronę do tworzenia nowego zwierzęcia */
	/* Używamy danych z sesji, jesli istanieją */
	public function newClient()
	{
		if (isset($_SESSION['currentNewClient'])) {
			$builder = $_SESSION['currentNewClient'];
		} else {
			$builder = new ClientBuilder(array());
		}
		$this->view->makeClientCreationPage($builder);
	}

	/* Zapisywanie nowego zwierzęcia */
	public function saveNewClient(array $data){
		//$this->view->makeDebugPage($data);
		//$this->view->makeDebugPage($client);

		/* Stworzenie instancji modelu ClientBuilder() z danymi przesłanymi z Routera */
		$builder = new ClientBuilder($data);
		/* Tworzy zwierzę jeśli podane poprawne dane, 
		* Lub wraca do formularza z częściowo uzupełnionymi polami */
		if ($builder->isValid()) {
			/* Tworzenie instancji */
			$client = $builder->createClient();
			/* Zapisywanie w bazie: */
			$id = $this->clientdb->create($client);
			/* Usuwamy instancję sesji z przechowywanymi danymi */
			unset($_SESSION['currentNewClient']);
			/* Tworzenie strony z użyciem nowych danych */
			// $this->view->makeClientPage($id, $client);
			/* PRZEKIEROWANIE - pokazujemy że nowe zwierzę zosało stworzone */
			$this->view->displayClientCreationSuccess($id);
			} else {
				$_SESSION['currentNewClient'] = $builder;
				$this->view->displayClientCreationFailure();
			}
	}// end of saveNewClient()


	/* Przygotowuje dla widoku dane do przygotowanei strony z pytaniem o zgodę na skasowanie zwirzęcia */
	public function askClientDeletion($id)
	{
		/* Sprawdza, czy zwierzę w ogóle istnieje */
		$client=$this->clientdb->read($id);
		if ($client === null) {
			$this->view->makeUnknownClientPage();
		} else {
			$this->view->makeClientDeletionPage($id, $client);
		}
	}

	/* Kasowanie zwierzęcia z bazy */
	public function deleteClient($id)
	{
		$ok = $this->clientdb->delete($id);
		if($ok){
			$this->view->displayClientDeletionSuccess();
		} else {
			/* JEśli zwirzę nie isnieje w bazie */
			$this->view->displayClientDeletionFailure($id);
		}
	}

}//end of class Controller

?>