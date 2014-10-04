<?php

namespace view;

require_once("./common/CustomExceptions.php");


class RegisterView{
	
	private $username = "RegisterView::Username";				//
	private $password = "RegisterView::Password";				//
	private $rpassword = "RegisterView::RepeatedPassword";		//
	private $message;										// Privat variabel för att visa fel/rättmeddelanden.


	// Kontrollerar om användare tryckt på Registrera.
	public function didUserPressRegister(){
		return isset($_POST["RegisterView::register"]);
	}

	// Hämtar användarnamnet för registrering.
	public function getUsername(){
		return $_POST[$this->username];
	}

	// Hämtar lösenordet för registrering.
	public function getPassword(){
		return $_POST[$this->password];
	}
	
	// Hämtar lösenordet för registrering.
	public function getRepeatedPassword(){
		return $_POST[$this->rpassword];
	}

	public function backToLogin(){
		header("Location:?");
	}

	// Sätter de olika meddelandena som kommer in under valideringen.
	public function setMessage($e, $c){
		if($c == 201){
			$this->message = "Användarnamnet finns redan registrerat i databasen.";
		}
		if($c == 202){
			$this->message = "Användarnamnet är för kort. Minst 3 tecken.</p>
								 <p>Lösenorden är för korta. Minst 6 tecken.";
		}
		if($c == 204){		
			$this->message = "Användarnamnet innehöll ogiltiga tecken.";
			$_POST[$this->username] = $e;
		}
		if($c == 203){		
			$this->message = "Användarnamnet är för kort. Minst 3 tecken.";
		}
		if($c == 206){		
			$this->message = "Lösenorden är för korta. Minst 6 tecken.";
		}
		if($c == 205){		
			$this->message = "Lösenorden är olika varandra.";
		}
	}

	// Hämtar de olika meddelandena.
	public function getMessage(){
		return "<p>" . $this->message . "</p>";
	}

	// Slutlig presentation av utdata.
	public function showRegister(){
		
		$status = "";
		if(isset($this->message)){
			$status = $this->getMessage();
		}

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