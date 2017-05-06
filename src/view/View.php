<?php

/**
* Wymagane klasy
*/
require_once('Router.php');
require_once('model/Client.php');
require_once('model/ClientBuilder.php');

class View
{

			/*** ATRYBUTY ***/

	/* Instancja Routera, wykorzystywana przez WIdok do budowy URL-i */
	protected $router;
	/* Tytuł strony, wypełniamy metodami widoku makeXXXPage() */
	protected $title;
	/* Zawartość strony, wypełniamy metodami widoku makeXXXPage() */
	protected $content;
	/* Menu główne, dostępne na wszystkich stronach */
	protected $menu;
	/* Informacja zwrotna dla usera po wykonaniu akcji */
	protected $feedback;
	/* Link do pliku css */
	protected $styleSheetURL;




			/***  ZABEZPIECZENIE PRZED ATAKAMI***/
/**
	 * Une fonction pour échapper les caractères spéciaux de HTML.
	 * Encapsule celle de PHP, trop lourde à utiliser car
	 * nécessite trop d'options.
	 */

	public static function htmlesc($str) 
	{
		return htmlspecialchars($str,
			ENT_QUOTES  /* on échappe guillemets _et_ apostrophes */
			| ENT_SUBSTITUTE  /* les séquences UTF-8 invalides sont
			                   * remplacées par le caractère �
			                   * (au lieu de renvoyer la chaîne vide…) */
			| ENT_HTML5,  /* on utilise les entités HTML5 (en particulier &apos;) */
			'UTF-8'  /* encodage de la chaîne passée en entrée */
		);
	}
			/***  KONIEC ZABEZPIECZENIA ***/




			/*** KONSTRUKTOR ***/

/* Tutaj trafia instancja Routera, przekazana Widokowi podczas tworzenia tego Widoku*/
	public function __construct(Router $router, $feedback)
	{
		/* Instancja Routera*/
		$this->router = $router;
		/* Konstrukcja menu */
		$this->menu = array(
			$this->router->getHomeURL() => 'Accueil',
			$this->router->getClientListURL() => 'Liste de clients',
			$this->router->getClientCreationURL() =>'Ajout d\'un client',
			);
		/* Konstrukcja feedbacku dl ausera */
		$this->feedback = $feedback;
		/* Konstrukcja adrescu do pliku css */
		$this->styleSheetURL = $router->getURL("style.css");
	}//end __construct()



			/*** METODY ***/

	/* Wypełnia Widok przykładową treścią */
	public function makeTestPage()
	{
		$this->title = 'Testowy tytuł strony';
		$this->content = 'Testowy kontent strony';
	}

	/* Wypełnia Widok treścią o zwierzęciu */
	public function makeClientPage($id, Client $client)
	{
		$this->title = "Strona info - ".self::htmlesc($client->getName());
		$this->content = '<p>'.self::htmlesc($client->getName()).' to bardzo miły '.self::htmlesc($client->getSurname()).'.<br/>Obecnie '.self::htmlesc($client->getName()).' ma już '.self::htmlesc($client->getEmail()).' lat.</p><a href="'.$this->router->getClientAskDeletionURL($id).'">Skasuj tego klienta</a></p>';
	}

	/* Generuje stronę z informacją o braku żądanego zwirzęcia */
	public function makeUnknownClientPage()
	{
		$this->title = "Zwierzę nieznane! ";
		$this->content = '<p> Nie możemy wyświetlić informacji o takim zwirzęciu, bo nie ma go w naszej bazie... </p>';
	}

	/* Generuje stronę powitalną */
	public function makeHomePage()
	{
		$this->title = "Bienvenue à LM_Emprunts";
		$this->content = '<p> Système de réservation du Linux Magazine de l\'Université de Caen.</p>';
	}

	/* Generuje stronę z listą zwierząt */
	public function makeListPage(array $clientsTab)
	{
		$print = "";
		$print .= "<p>Clients enregistrés dans la base de données : </p>";
		$print .= "<ul>";
		foreach ($clientsTab as $id => $a) {
			/* array jest OBIEKTEM więc nie można po porstu zrobić echo */
			$print .= '<li><a href="'.$this->router->getClientURL($id).'">'.self::htmlesc($a->getName()).' '.self::htmlesc($a->getSurname()).'</li>';
		}
		$print .= "</ul>";

		$this->title = "Liste de clients";
		$this->content = $print;
	}

	/* Strona z błędem nieznanej akcji */
	public function makeUnknownActionPage()
	{
		$this->title = "Błąd! ";
		$this->content = '<p> Próbujesz wykonać akcję, której nie ma! </p>';
	}

	/* Generuje stronę z formularzem do wpisania nowego zwierzęcia*/ 
	/* Przyjmowane dane przy tworzeniu są puste - pochodzą "na sztywno" z Routera, 
	* Przy poprtawianiu, pochodzą z błędnie wypełnionego formularza */
	public function makeClientCreationPage(ClientBuilder $builder)
	{
		/* Przygotowuję formularz */
		$data = $builder->getData();
		/* Referencje do nazw pól, dostępnych tylko w modelu ClientBuilder  */
		$nameRef = $builder::NAME_REF;
		$surnameRef = $builder::SURNAME_REF;
		$emailRef = $builder::EMAIL_REF;
		$statusRef = $builder::STATUS_REF;
		$telephoneRef = $builder::TELEPHONE_REF;
		/* HTML formularza */
		$s = '';
		$s .= '<form action ="'.$this->router->getClientSaveURL().'" method="POST">';
		$s .= '<p><label for="nameInput">Prenom : </label><input type="text" name="'.$nameRef.'" id="nameInput" value="'.self::htmlesc($data[$nameRef]).'" /></p>';
		$s .= '<p><label for="surnameInput">Nom : </label><input type="text" name="'.$surnameRef.'" id="surnameInput" value="'.self::htmlesc($data[$surnameRef]).'" /></p>';
		$s .= '<p><label for="emailInput">E-mail : </label><input type="text" name="'.$emailRef.'" id="emailInput" value="'.self::htmlesc($data[$emailRef]).'" /></p>';
		$s .= '<p><label for="statusInput">Status universitaire : </label><input type="text" name="'.$statusRef.'" id="statusInput" value="'.self::htmlesc($data[$statusRef]).'" /></p>';
		$s .= '<p><label for="telephoneInput">Téléphone : </label><input type="text" name="'.$telephoneRef.'" id="telephoneInput" value="'.self::htmlesc($data[$telephoneRef]).'" /></p>';
		$s .= '<p><button type="submit">Ajouter</button></p>';
		$s .= '</form>';
		/* Tablica błędów */
			$error = $builder->getError();
			if ($error !== '' && $error !== null) {
				$s .= '<div class="error">'.$error.'</div>';
			}
		$this->title = "Ajouter un client";
		$this->content = $s;
	}

	/* Generuje stronę do potwierdzenia kasowania zwierzęcia */
	public function makeClientDeletionPage($id, $client)
	{
		$s = '';
		$s .= '<form action="'.$this->router->getClientDeletionURL($id).'" method="POST">'."\n";
		$s .= '<p>Voulez-vous vraiment supprimer l’client « '
			.self::htmlesc($client->getName()).' » ?</p>'."\n";
		$s .= '<button type="submit">Confirmer la suppression</button>'."\n";
		$s .= '</form>'."\n";

		$this->title = 'Delete this client';
		$this->content = $s;
	}// end makeClientDeletionPage()

	/* Wskazuje co klient ma zrobić po powodzeniu stworzenia */
	public function displayClientCreationSuccess($id)
	{
		$_SESSION['feedback'] = "Dodawanie do bazy zakończone sukcesem!";
		$this->router->POSTredirect($this->router->getClientURL($id));
	}

	/* Wskazuje co klient ma zrobić po niepowodzeniu stworzenia */
	public function displayClientCreationFailure()
	{
		$_SESSION['feedback'] = 'Formulaire invalide';
		$this->router->POSTredirect($this->router->getClientCreationURL());
	}

	/* Wskazuje co klient ma zrobić po powodzeniu skasowania */
	public function displayClientDeletionSuccess($id)
	{
		$_SESSION['feedback'] = "Zwierzę skasowane!";
		$this->router->POSTredirect($this->router->getClientListURL());
	}

	/* Wskazuje co klient ma zrobić po niepowodzeniu skasowania */
	public function displayClientDeletionFailure()
	{
		$_SESSION['feedback'] = 'Zwierzęcia nie można skasować!';
		$this->router->POSTredirect($this->router->getClientURL($id));
	}

	/* Generuje HTML z wygenerowaną wcześniej w PHP treścią */
	public function render(){
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title><?php echo $this->title; ?></title>
				<link rel="stylesheet" type="text/css" href="<?php echo $this->styleSheetURL; ?>">
			</head>
			<body>
			<nav class="menu">
				<ul>
					<?php foreach ($this->menu as $url => $text) { ?>
						 	<li><a href="<?php echo $url; ?>"><?php echo $text; ?></a></li>
					<?php } ?>
				</ul>
			</nav>
			<h1><?php echo $this->title; ?></h1>
			<?php
			/* Chcemy wyświetlić feedback, tylko, jeśli istnieje */
			if($this->feedback !==''){
					echo '<div class="feedback">'.$this->feedback.'</div>';
				}
			echo $this->content; 
			?>
			</body>
		</html>
		<?php
	} //end render()


	/* Wypełnia widok potwierdzeniem skasowania zwierzęcia */
	public function makeClientDeletedPage()
	{
		$this->title = 'Kasowanie przebiegło pomyślnie!';
		$this->content = "Zwierzę zostało poprawnie skasowane.";
	}

		/* DEBUG */
	/* Wypełnia widok zawarością dowolnej zmiennej */
	public function makeDebugPage($variable)
	{
		$this->title='Debug';
		$this->content = '<pre>'.var_export($variable,true).'<pre>';
	}

} //end class View

?>