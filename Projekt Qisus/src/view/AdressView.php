<?php

namespace view;

require_once("src/model/Adress.php");


class AdressView{

	private $adressRepository;				// Instans av AdressRepository.

	private $i;
	private $errorMessage;

	// Statiska medlemsvariabler för att motverka strängberoenden.
	private static $message = 'message';
	private static $adress = 'adress';
	private static $adressId = 'adressId';
	private static $back = 'back';
	private static $send = 'send';
	private static $addAdress = 'addAdress';
	private static $deleteAdress = 'deleteAdress';



	public function __construct(\model\QuizModel $model){
		$this->model = $model;
		$this->quizId = $this->model->getCreateSession();
	}


/**
  * Submit-funktioner.
  */
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


/**
  * Instansierar och retunerar ett nytt Adress-objekt.
  *
  * @return object Returns Object Adress.
  */
	public function getAdressToCreate(){
		if($this->submitAdress()){

			$adress = trim($_POST[self::$adress]);
			
			if (empty($adress)) {
				$this->errorMessage = "<p id='error_message'>Du måste ange en mailadress! :)</p>";
				return null;
			}

			try {
				return new \model\Adress($this->quizId, $adress, NULL);
			} catch (\Exception $e) {
				$this->errorMessage = "<p id='error_message'>Mailadressen är ogiltig! :O</p>";
			}
		}
	}


/**
  * Instansierar och retunerar ett Adress-objekt för borttagning.
  *
  * @return object Returns Object Adress.
  */
	public function getAdressToDelete(){
		return new \model\Adress($this->quizId, "delete@this.adress", $_POST[self::$adressId]);		
	}


/**
  * Visar adresskaparen och listar alla skapade adresser (spelare).
  *
  * @param array Array of adress-objects.
  *
  * @return string Returns String HTML.
  */
	public function show($adresses){

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
						
				if (!empty($adresses)) {
			    $ret .= "
		    					<input class='continueButton' type='submit' value='Fortsätt →' name='" . self::$send . "'>
		    				</div>	
						";
		$ret .= "
						</form>
					</div>
				";
			}

		if(empty($adresses)){
			$ret .= "
						<p>Inga spelare tillagda.</p>
					";
		}

		foreach ($adresses as $adress) {

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