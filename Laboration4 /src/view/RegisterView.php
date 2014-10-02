<?php

require_once("CookieService.php");

class RegisterView{
	
	private $model;
	private $username = "RegisterView::Username";				// Användarnamnet.
	private $password = "RegisterView::Password";				// Lösenordet.
	private $repeatpassword = "RegisterView::RepeatPassword";	// Repeterat lösenord.
	private $message;											// Privat variabel för att visa fel/rättmeddelanden.

	public function __construct(RegisterModel $model){

		// Struktur för MVC.
		$this->model = $model;
	}

	// Kontrollerar om användare tryckt på Logga in.
	public function didUserPressRegister()	{
		return isset($_POST["RegisterView::register"]);
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

	// Hämtar repeterat lösenord vid rätt input.
	public function getRepeatPassword(){

		if (empty($_POST["$this->repeatpassword"])) {
			throw new \Exception("Repeterat lösenord saknas!");	
		}
		else {
			return $_POST["$this->repeatpassword"];	
		}
	}

	// Datum och tid-funktion. (Kan brytas ut till en hjälpfunktion.)
	public function getDateTime(){
		date_default_timezone_set('Europe/Stockholm');
		setlocale(LC_ALL, 'sv_SE');
		$weekday = ucfirst(utf8_encode(strftime("%A,")));
		$date = strftime("den %d");
		$month = strftime("%B");
		$year = strftime("år %Y.");
		$time = strftime("Klockan är [%H:%M:%S].");
		return "$weekday $date $month  $year  $time";	
	}

	// Visar fel/rättmeddelanden.
	public function showStatus($message){
		if (isset($message)) {
			$this->message = $message;
		}
		else{
			$this->message = "<p>" . $message . "</p>";
		}
	}


	// Slutlig presentation av utdata.
	public function showRegister(){

		$datetime = $this->getDateTime();

		$ret = "<h1>Laboration 4 - Inloggning - al223bn</h1>";

		$ret .= "<h2>Ej inloggad -> Registrera användare</h2>";

		$ret .= "<p><a href='?'>Tillbaka</a></p>";

		$ret .= 
				"
				<fieldset>
				<legend>Skriv in inloggningsuppgifterna här! </legend>";

		$ret .= "<p>$this->message";

		$ret .= "
				<form action='?register' method='post' >
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
                    <input type='password' id='pass' name='password'>
                    <label for='repeatpass'>Repetera lösenord</label>
                    <input type='password' id='repeatpass' name='repeatpass'>
                    <input type='submit' value='Registrera' name='submit'>
				</form>
				</fieldset>
				";

		$ret .= "<p>$datetime</p>";

		return $ret;
	}

}