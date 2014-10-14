<?php

namespace view;

require_once("src/model/Adress.php");
require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class PlayerView{

	private $quizId;
	private $i;
	private $quizRepository;
	private $errorMessage;

	private static $message = 'message';
	private static $adress = 'adress';
	private static $adressId = 'adressId';
	private static $back = 'back';
	private static $send = 'send';
	private static $addAdress = 'addAdress';
	private static $deleteAdress = 'deleteAdress';



	public function __construct($quizId, \model\QuizRepository $quizRepository){
		$this->quizId = $quizId;
		$this->quizRepository = $quizRepository;
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
			$adress = trim($_POST[self::$adress]);
			if (empty($adress)) {
				$this->errorMessage = "<p id='error_message'>Du har glömt att skriva in en mailadress! ;)</p>";
				return null;
			}
				return new \model\Adress($this->quizId, $_POST[self::$adress], NULL);
		}
	}


	public function getAdressToDelete(){
		return new \model\Adress($this->quizId, "", $_POST[self::$adressId]);		
	}


	public function show(\model\Adresses $adresses){

		$errorMessage = $this->errorMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>Skapa spelare</h2>
					<div>
						<form method='post'>
							<div>
								<label for='address_input' id='player_label'>Skriv in dina spelares mailadresser..</label>
					        </div>
								<input id='address_input' type='text' name='" . self::$adress . "'>
							
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
							<label for='question_input" . $this->i . "'>" . $adress->getAdress() . "</label>
		    				<input class='deleteButton' type='submit' value='Ta bort' name='" . self::$deleteAdress . "'>
						</form>
					</div>
					";
		}

			return $ret;
	}
}