<?php

namespace view;


class MailView{

	private $model;					// Instans av CreateModel.

	private $quizId;
	private $errorMessage;

	// Statiska medlemsvariabler för att motverka strängberoenden.
	private static $title = 'title';
	private static $message = 'message';
	private static $send = 'send';
	private static $back = 'back';
	private static $creator = 'creator';



	public function __construct(\model\QuizModel $model){
		$this->model = $model;

		$this->quizId = $this->model->getCreateSession();
	}


/**
  * Submit-funktioner.
  */
	public function backToPlayers(){
		return isset($_POST[self::$back]);
	}

	public function send(){
		return isset($_POST['send']);
	}


/**
  * Hämtar det inmatade meddelandet.
  *
  * @return string Returns String message.
  */
	public function getMessage(){
		return $_POST[self::$message];
	}


/**
  * Renderar message för mailet, googla mail() + php.
  *
  * @return string Returns String Message.
  */
	public function renderMessage($adressId, $title){
		$ret  ="		<html><body>";
		$ret .="		<h2>" . $title . "</h2>";
		$ret .="		<p>" . $this->getMessage() . "</p>";
		$ret .="		<a href=http://alengqvist.com/qisus/?" . NavigationView::$action . "=" . NavigationView::$actionPlay . "&" . NavigationView::$game . '=' . $this->quizId . "&" . NavigationView::$player . "=" . $adressId . ">Spela " . $title  . "</a>";
	    $ret .="	</body></html>";
	   	return $ret;
	}

/**
  * Renderar headers för mailet, googla mail() + php.
  *
  * @return string Returns String headers.
  */
	public function renderHeader(){
		$headers = "From: " . \Config::POSTMASTER . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	   	return $headers;
	}


/**
  * Visar mailskaparen.
  *
  * @return string Returns String HTML.
  */
	public function show(){

		$errorMessage = $this->errorMessage;

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h2 id='title'>Skicka quizet!</h2>
					<div id='center_wrap'>
						<form method='post'>
							<div>
								<label for='question_input' id='question_label'>Skriv in ett litet meddelande till dina spelare..</label>
					        </div>
					        	<textarea id='question_input' rows='8' name='" . self::$message . "'>Hej! Här kommmer ett hejdundrande roligt quiz från qisus! :D</textarea>
				            <div>

							$errorMessage

		    				<div id='title_buttons_div'>
								<input class='backButton' type='submit' value='← Tillbaka' name='" . self::$back . "'>
								<input class='sendButton' type='submit' value='Skicka!' name='" . self::$send . "'>
							</div>
							</div>
						</form>
					</div>
				";

		return $ret;
	}


/**
  * Visar att mail blivit skickat.
  *
  * @return string Returns String HTML.
  */
	public function showSent(){

		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Quiz skickat! :D</h2>
						<p class='info'>Du kommer få resultaten från varje enskild spelare skickat till den mail du angav.</p>
						<p class='info'>Tack för att du valde qisus.</p>
					</div>
				";

		return $ret;
	}
}