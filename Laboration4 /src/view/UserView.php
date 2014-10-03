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
		if(isset($_POST["UserView::logout"])){
			return $_POST["UserView::logout"];
		}
		else{
			return false;
		}
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

	// Skickar rättmeddelandet till showStatus.
	public function successfullLogIn(){
		$this->showStatus("Inloggningen lyckades!");
	}

	// Skickar rättmeddelandet till showStatus.
	public function successfullLogInWithCookiesSaved(){
		$this->showStatus("Inloggningen lyckades och vi kommer ihåg dig nästa gång!");
	}

	// Skickar rättmeddelandet till showStatus.
	public function successfullLogInWithCookiesLoad(){
		$this->showStatus("Inloggningen lyckades via cookies!");
	}

	// Slutlig presentation av utdata.
	public function showUser(){
	$user = $this->model->getLoggedInUser();

	$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>
			<h2>$user är nu inloggad!</h2>

			$this->message

			<form action='?logout' method='post' >
			<p><input type='submit' value='Logga ut' name='UserView::logout'></p>
			</form>
			";		

	return $ret;
}


}