<?php

require_once("CookieStorage.php");


class LoginView{
	
	private $model;
	private $UserName;
	private $PassWord;
	private $message;

	public function __construct(LoginModel $model){
		$this->model = $model;
		//$this->UserName = new CookieStorage();
		//$this->PassWord = new CookieStorage();
	}

	public function didUserPressLogin()	{
		if(isset($_POST["LoginView::login"])){
			return $_POST["LoginView::login"];
		}
		else{
			return false;
		}
	}


	public function checkboxFilled(){
		if(isset($_POST["LoginView::checked"])){
			return true;
		}
	}

	// Hämtar Användarnamnet.
	public function getUsername(){

		if (empty($_POST["LoginView::username"])) {
			throw new \Exception("Användarnamn saknas!");
		}
		else {
			return $_POST["LoginView::username"];	
		}
	}

	// Hämtar lösenordet.
	public function getPassword(){

		if (empty($_POST["LoginView::password"])) {
			throw new \Exception("Lösenord saknas!");	
		}
		else {
			return $_POST["LoginView::password"];	
		}
	}

	public function getDateTime(){
		setlocale(LC_ALL, 'sv_SE');
		$weekday = ucfirst(utf8_encode(strftime("%A,")));
		$date = strftime("den %d");
		$month = strftime("%B");
		$year = strftime("år %Y.");
		$time = strftime("Klockan är [%H:%M:%S].");
		return "$weekday $date $month  $year  $time";	
	}

	// Presenterar felmeddelandet vid inloggningsfel.
	public function showStatus($message){
		if (isset($message)) {
			$this->message = $message;
		}
		else{
			$this->message = "<p>" . $message . "</p>";
		}
	}

	public function successfullLogOut(){
		$this->showStatus("Du har nu loggat ut!");
	}


	// Presentation av utdata.
	public function showLogin(){

		$datetime = $this->getDateTime();

		$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>";

		$ret .= "<h2>Ej inloggad!</h2>";

		$ret .= 
				"
				<fieldset>
				<legend>Logga in här!</legend>";

		$ret .= "<p>$this->message";

		$ret .= "
				<form action='?login' method='post' >";

		// Om det inte finns något inmatat användarnamn så visa tom input.
		if(empty($_POST["LoginView::username"])){
			$ret .= "Användarnamn: <input type='text' name='LoginView::username'>";
		}
		// Annars visa det tidigare inmatade användarnamnet i input.
		else{
			$uservalue = $_POST["LoginView::username"];
			$ret .= "Användarnamn: <input type='text' name='LoginView::username' value='$uservalue'>";
		}

		$ret .= "
					Lösenord: <input type='text' name='LoginView::password'>
					Håll mig inloggad: <input type='checkbox' name='LoginView::checked'>
					<input type='submit' value='Logga in' name='LoginView::login'>
				</form>
				</fieldset>
				";

		$ret .= "<p>$datetime</p>";

		return $ret;
	}

}