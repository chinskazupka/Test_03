<?php

/**
* Klasy potrzebne Routerowi do działania:
*/
require_once('view/View.php');
require_once('control/Controller.php');
/* Tutaj nie tworzymy już instancji (została nam przekazana przez animaux.php), więc wystarczy nam interfejs */
require_once('model/ClientStorage.php');


/* Tylko Router ma dostęp do URLi. 
* Inne klasy muszągo o niego zapytać poprzez getXXXURL()*/

class Router
{
	/** The prefix for URLs rooted by this instance. */
    protected $baseURL;

    /** The prefix for URLs of resources directly accessible via get requests. */
    protected $webBaseURL;

    /** The current view. */
    private $view;

     /**
     * Builds a new instance.
     * @param $baseURL The prefix for URLs rooted by this instance (e.g., "http://domain.com/index"
     * will yield URLs of the form "http://domain.com/index/path/to/resource"); the prefix should not
     * include a trailing "/"
     * @param $webBaseURL The prefix for URLs of resources directly accessible via get requests
     * (css, js, image files, etc.); for instance, "http://domain.com" will yield URLs of the
     * form "http://domain.com/css/stylesheet.css"); the prefix should not
     * include a trailing "/"
     */
    public function __construct ($baseURL, $webBaseURL) {
        $this->baseURL = $baseURL;
        $this->webBaseURL = $webBaseURL;
        echo $baseURL;
        echo "<br>";
        echo $webBaseURL;  
    }
	
	function main(ClientStorage $clientdb){
		session_start();
		/* Pobieram feedback z poprzedniej sesji i jeśli coś w nim jest, 
		* umieszczam to coś w $feedback, 
		* jeśli jest tam null, umieszczam w nim pustkę */
		$feedback = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : '';
		/* Czyszczę niepotrzebną już sesję */ 
		$_SESSION['feedback'] = '';

		/* Tworzy nowy widok i przekazuje do niego przez $this info z Routera 
		* oraz feedback (pusty lub nie) otrzymany z sesji*/
		$view = new View($this, $feedback);
		$ctl = new Controller($view, $clientdb);

		/* Używam Controllera do wygenerownia informacji o zwierzęciu : */
		/* Testy parametru przekazanego przez URL */
		/* Test na zawartość atrybutu id */
		$id = key_exists('id',$_GET) ? $_GET['id'] : null;
		/* Test na zawartość atrybutu action */
		$action = key_exists('action',$_GET) ? $_GET['action'] : null;


		$url = getenv('PATH_INFO');
		$urlParts = explode('/', $url);
		// First element is always empty, skipping it
        array_shift($urlParts);

        // Retrieving first real element
        $page = array_shift($urlParts);


        // Tranferring control
        switch ($page) {
        	case '':
        		$view->makeHomePage();
        		break;
        	case 'list':
        	// Expecting URL of the form "list/x"
                if (!empty($urlParts[0])) {
                    $id = array_shift($urlParts);
                    $ctl->showInformation($id);
                    break;
                    } else {
           				$ctl->showList();                	
                    }
        		break;
        	case 'action':
        		if (! empty($urlParts[0])) {
        			$doAction = array_shift($urlParts);
        			switch ($doAction) {
						case 'add':
							$ctl-> newClient();
							break;
						case 'save':
							$ctl->saveNewClient($_POST);
							break;
						case 'delete' :
						    // Expecting URL of the form "delete/x"
                			if (!empty($urlParts[0])) {
                   			$id = array_shift($urlParts);
                    		$ctl->askClientDeletion($id);
                    		break;
                    		} else {
           						$view->makeUnknownActionPage();             	
                    		}
							break;
						case 'confirm':
							// Expecting URL of the form "confirm/x"
                			if (!empty($urlParts[0])) {
                   			$id = array_shift($urlParts);
                   			$ctl->deleteClient($id); 
                    		break;
                    		} else {
           						$view->makeUnknownActionPage();         	
                    		}
							break;	
						default:
							$view->makeUnknownActionPage();
							break;
					}// end switch $doAction
        		} // end if $doAction
        		break; // end case 'action'
        	default:
        		$view->makeUnknownActionPage();
        		break;
        }// end switch $page


	/* Wyświetlam przygotowany wcześniej widok */
	$view->render();
	} // end method main()


	/*
	* Przekierowuje usera na podany w argumencie URL 
	* poprzez przekierowanie 303.
	* Metoda przeznaczona do używania po wykonaniu POST, 
	* na URLach podanych przez Router
	* (trzeba więc zdekodowac znaczniki HTML)
	*/
	public function POSTredirect($url)
	{
		header("Location:".htmlspecialchars_decode($url), true, 303);
		/* 
		* UWAGA! Trzeba przerwać wykonywanie skyptu:
		* przekierowanie jest efektywne tylko raz, 
		* kiedy klient dostaje  wiadomość HTTP. 
		* Nie trzeba (i jest niebezpieczne) wyświetlać widok ! 
		*/
		/* NB: il faut interrompre l'exécution du script: la redirection
		 * n'est effective qu'une fois que le client a reçu le message
		 * HTTP. Inutile (et dangereux d'un point de vue sécurité) d'afficher
		 * la vue ! */
		die;
	}



	/* Te metody używane są w linkach, kiedy zmienia się stronę 
	* Dane z nich trafiają do routera i tam są przetwarzane */

	/* Zwraca stronę główną */
	public function getHomeURL()
	{
		return $this->baseURL;
	}

	/* Zwraca stronę z listą zwierząt */
	public function getClientListURL()
	{
		return $this->baseURL."/list";
	}

	/* Zwraca URL z identyfikatorem danego zwierzęcia */
	public function getClientURL($id) // pobiera $id zwierzęcia z URL
	{
			return $this->baseURL."/list/".$id;
	}

	/* Zwraca URL strony tworzącej nowe zwierzę */
	public function getClientCreationURL()
	{
		return $this->baseURL . "/action/add";
	}

	/* Zwraca URL strony zapisującej nowe zwierzę */
	public function getClientSaveURL()
	{
		return $this->baseURL . "/action/save";
	}

	/* Zwraca URL strony potwierdzenia skasowania  */
	public function getClientAskDeletionURL($id)
	{
		return $this->baseURL . "/action/delete/" . $id;
	}

	/* Zwraca URL strony kasowania */
	public function getClientDeletionURL($id)
	{
		return $this->baseURL . "/action/confirm/" . $id;
	}

    /**
     * Returns the URL of a given file directly accessible via get requests.
     * @param $path The path of a file relative to the root of this web site
     * (without the leading "/")
     * @return A string
     */
    /* U MNIE - TYLKO CS */
    public function getURL ($path) {
        return $this->webBaseURL ."/". $path;
    }

} // end class Router

?>