<?php

require_once("./common/CustomExceptions.php");

class RegisterView{
	
	private $model;
	private $username = "RegisterView::Username";				//
	private $password = "RegisterView::Password";				//
	private $rpassword = "RegisterView::RepeatedPassword";		//
	private $messages = [];											// Privat variabel för att visa fel/rättmeddelanden.

	public function __construct(RegisterModel $model){

		// Struktur för MVC.
		$this->model = $model;
	}

	// Kontrollerar om användare tryckt på Registrera.
	public function didUserPressRegister()	{
		return isset($_POST["RegisterView::register"]);
	}

	// Hämtar användarnamnet för registrering.
	public function getUsername(){
		try {
			return $this->model->setUsername($_POST[$this->username]);
		} 
		catch (TooShortException $e) {
			$this->messages[] = "Användarnamnet är för kort. Minst " . $e->getMessage() . " tecken.";
		}
		catch (InvalidCharException $e) {
			$_POST[$this->username] = $e->getMessage();
			$this->messages[] = "Användarnamnet är ogiltigt.";
		}
	}

	// Hämtar lösenordet för registrering.
	public function getPassword(){
		try {
			// Fungerade inte att göra denna valideringen i modellen av någon anledning. Kolla upp!
			if($_POST[$this->password] !== $_POST[$this->rpassword]){
				throw new \NoMatchException();		
			}
			return $this->model->setPassword($_POST[$this->password]);
		} 
		catch (NoMatchException $e) {
			$this->messages[] = "Lösenorden matchar inte varandra.";
		}
		catch (TooShortException $e) {
			$this->messages[] = "Lösenorden är för korta. Minst " . $e->getMessage() . " tecken.";
		}
	}

	// Visar meddelanden.
	public function renderStatus(){
		$ret = "";
        if(is_array($this->messages )){
        	foreach ($this->messages as $message) {
        		$ret .= "<p>" . $message . "</p>";
        	}
		}
		return $ret;
	}

	// Slutlig presentation av utdata.
	public function showRegister(){

		$status = $this->renderStatus();

		$ret = "<h1>Laboration 4 - Inloggning - al223bn</h1>
				<h2>Ej inloggad -> Registrera användare</h2>
				<p><a href='?'>Tillbaka</a></p>
				<fieldset>
				<legend>Skriv in inloggningsuppgifterna här! </legend>

				$status

				<form method='post' >
					<label for='username'>Användarnamn</label>";
	
					if(empty($_POST[$this->username])){
						$ret .= " <input id='username' type='text' name='$this->username'>";
					}
					// Annars visa det tidigare inmatade användarnamnet i input.
					else{
						$uservalue = $_POST[$this->username];
						$ret .= "<input id='username' type='text' name='$this->username' value='$uservalue'>";
					}
		$ret .= "
                    <label for='pass'>Lösenord</label>
                    <input type='password' id='pass' name='$this->password'>
                    <label for='repeatedpass'>Repetera lösenord</label>
                    <input type='password' id='repeatedpass' name='$this->rpassword'>
                    <input type='submit' value='Registrera' name='RegisterView::register'>
				</form>
				</fieldset>
				";

		return $ret;
	}

}