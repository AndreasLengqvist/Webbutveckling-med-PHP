<?php

namespace view;

require_once("src/model/Adress.php");


class PlayerView{

	private $session;
	private $quizRepository;

	private $quizId;
	private $i;
	private $errorMessage;

	private static $message = 'message';
	private static $adress = 'adress';
	private static $adressId = 'adressId';
	private static $back = 'back';
	private static $send = 'send';
	private static $addAdress = 'addAdress';
	private static $deleteAdress = 'deleteAdress';



	public function __construct(\model\CreateSession $session, \model\QuizRepository $quizRepository){
		$this->session = $session;
		$this->quizRepository = $quizRepository;

		$this->quizId = $this->session->getCreateSession();
	}


	public function backToQuestions(){
		return isset($_POST[self::$back]);
	}

	public function finished(){
		return isset($_POST[self::$send]);
	}

	public function submitAdress(){
		return isset($_POST[self::$addAdress]);
	}

	public function deleteAdress(){
		return isset($_POST[self::$deleteAdress]);
	}


	public function getAdressData(){
		if($this->submitAdress()){
			try {
				return new \model\Adress($this->quizId, $_POST[self::$adress], NULL);
			} catch (\Exception $e) {
				$this->errorMessage = "<p id='error_message'>" . $e->getMessage() . "</p>";
			}
		}
	}


	public function getAdressToDelete(){
		return new \model\Adress($this->quizId, "delete@this.adress", $_POST[self::$adressId]);		
	}


	public function show(){

		$adresses = $this->quizRepository->getAdressesById($this->quizId);
		$errorMessage = $this->errorMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>Skapa spelare</h2>
					<div>
						<form method='post'>
							<div>
								<label for='address_input' id='player_label'>Skriv in dina spelares mailadresser..</label>
					        </div>
								<input id='address_input' type='email' name='" . self::$adress . "'>
							
							$errorMessage

							<div>
		    					<input class='addButton' type='submit' value='+ Lägg till spelare' name='" . self::$addAdress . "'>  				
								</div>
								<input class='backButton' type='submit' value='← Tillbaka' name='" . self::$back . "'>
				";
						
				if ($adresses->getAdresses()) {
			    $ret .= "
		    					<input class='continueButton' type='submit' value='Fortsätt' name='" . self::$send . "'>
		    				</div>	
						";
		$ret .= "
						</form>
					</div>
				";
			}

		if(!$adresses->getAdresses()){
			$ret .= "
						<p>Inga spelare tillagda.</p>
					";
		}

		foreach ($adresses->getAdresses() as $adress) {

			$this->i++;

			$ret .= "
					<div class='saved_div'>
					<h3 class='question_number'>" . $this->i . "</h3>
						<form method='post'>
							<input type='hidden' name='" . self::$adressId . "' value='" . $adress->getAdressId() . "'>
							<p class='player_text'>" . $adress->getAdress() . "</p>
		    				<input class='deleteButton' type='submit' value='Ta bort' name='" . self::$deleteAdress . "'>
						</form>
					</div>
					";
		}

			return $ret;
	}
}