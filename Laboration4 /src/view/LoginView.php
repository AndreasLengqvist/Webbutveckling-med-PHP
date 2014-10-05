<?php

namespace view;

require_once("./common/CookieService.php");


class LoginView{
	
	private $model;
	private $cookieUsername;						// Instans av CookieStorage för att lagra användarnamn.
	private $cookiePassword;						// Instans av CookieStorage för att lagra lösenord.
	private $username = "LoginView::Username";		// Användarnamnets kakas namn.
	private $password = "LoginView::Password";		// Lösenordets kakas namn.
	private $message;								// Privat variabel för att visa fel/rättmeddelanden.

	public function __construct(\model\LoginModel $model){

		// Struktur för MVC.
		$this->model = $model;
		$this->cookieUsername = new \CookieService();
		$this->cookiePassword = new \CookieService();
	}

	// Kontrollerar om användare tryckt på Logga in.
	public function didUserPressLogin()	{
		return isset($_POST["LoginView::login"]);
	}

	// Kontrollerar användare checkat i Håll mig inloggad.
	public function RememberMeIsFilled(){
		return isset($_POST["LoginView::checked"]);
	}

	// Funktion för att hämta sparade kakor.
	public function userIsRemembered(){
		if ($this->cookieUsername->loadCookie($this->username) && $this->cookiePassword->loadCookie($this->password)) {
			return true;
		}
		else{
			return false;
		}
	}

	// Funktion för att spara kakor (och spara ner förfallotid).
	public function saveToCookies($username, $password){
		$this->cookieUsername->saveCookie($this->username, $username);
		$this->model->saveCookieTime($this->cookiePassword->saveCookie($this->password, $this->model->cryptPassword($password)));
	}

	// Funktion för att radera sparade kakor.
	public function forgetRememberedUser(){
		$this->cookieUsername->removeCookie($this->username);
		$this->cookiePassword->removeCookie($this->password);
	}

	// Hämtar användarnamn från kakan.
	public function getUsernameCookie(){
		return $this->cookieUsername->loadCookie($this->username);
	}

	// Hämtar lösenord från kakan.
	public function getPasswordCookie(){
		return $this->cookiePassword->loadCookie($this->password);
	}

	// Hämtar Användarnamnet vid rätt input.
	public function getUsername(){
		if (empty($_POST["$this->username"])) {
			throw new \Exception("Användarnamn saknas!");
		}
		else {
			return $_POST["$this->username"];	
		}
	}

	// Hämtar lösenordet vid rätt input.
	public function getPassword(){
		if (empty($_POST["$this->password"])) {
			throw new \Exception("Lösenord saknas!");	
		}
		else {
			return $_POST["$this->password"];	
		}
	}

	// Lyckad utloggning.
	public function successfullLogOut(){
		$this->setMessage("Du har nu loggat ut!");
	}

	// Lyckad registrering av användare.
	public function successfullRegister(){
		$this->setMessage("Registrering av ny användare lyckades!");
		$this->model->unSetSession();
	}

	public function registerClick(){
		return isset($_GET["register"]);
	}

	// Sätter de olika meddelandena som kommer in under valideringen.
	public function setMessage($message){
		$this->message = $message;
	}

	// Hämtar de olika meddelandena.
	public function getMessage(){
		return "<p>" . $this->message . "</p>";
	}

	// Slutlig presentation av utdata.
	public function showLogin(){

		$status = "";
		if(isset($this->message)){
			$status = $this->getMessage();
		}

		$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>
			   	<h2>Ej inloggad</h2>
				<p><a href='?register'>Registrera ny användare</a></p>
				<fieldset>
				<legend>Logga in här!</legend>

				$status

				<form action='?login' method='post'>";

					// Om det inte finns något inmatat användarnamn så visa tom input.
					if(empty($_POST[$this->username])){
						$ret .= "Användarnamn: <input type='text' name='$this->username'>";
					}
					// Annars visa det tidigare inmatade användarnamnet i input.
					else{
						$uservalue = $_POST[$this->username];
						$ret .= "Användarnamn: <input type='text' name='$this->username' value='$uservalue'>";
					}

		$ret .= "
					Lösenord: <input type='password' name='$this->password'>
					Håll mig inloggad: <input type='checkbox' name='LoginView::checked'>
					<input type='submit' value='Logga in' name='LoginView::login'>
				</form>
				</fieldset>
				";

		return $ret;
	}

}