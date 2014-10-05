<?php

namespace view;

class UserView{
	
	private $model;
	private $message;


	public function __construct(\model\LoginModel $model){
		$this->model = $model;
	}

	// Kontrollerar om användaren tryckt på Logga ut.
	public function didUserPressLogout(){
		return isset($_POST["UserView::logout"]);
	}

	// Skickar rättmeddelandet till showStatus.
	public function successfullLogIn(){
		$this->setMessage("Inloggningen lyckades!");
	}

	// Skickar rättmeddelandet till showStatus.
	public function successfullLogInWithCookiesSaved(){
		$this->setMessage("Inloggningen lyckades och vi kommer ihåg dig nästa gång!");
	}

	// Skickar rättmeddelandet till showStatus.
	public function successfullLogInWithCookiesLoad(){
		$this->setMessage("Inloggningen lyckades via cookies!");
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
	public function showUser(){
				
	$status = "";
	if(isset($this->message)){
		$status = $this->getMessage();
	}

	$user = $this->model->getLoggedInUser();

	$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>
			<h2>$user är nu inloggad!</h2>

			$status

			<form action='?logout' method='post' >
			<p><input type='submit' value='Logga ut' name='UserView::logout'></p>
			</form>
			";		

	return $ret;
}


}