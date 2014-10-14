<?php

namespace view;

require_once("NavigationView.php");


class MailView{

	private $session;
	private $errorMessage;

	private static $title = 'title';
	private static $message = 'message';
	private static $send = 'send';
	private static $back = 'back';
	private static $creator = 'creator';



	public function __construct($quizId, \model\QuizRepository $quizRepository){
		$this->quizId = $quizId;
		$this->quizRepository = $quizRepository;
	}

	public function backToPlayers(){
		return isset($_POST[self::$back]);
	}

	public function send(){
		return isset($_POST['send']);
	}


	public function getTitle(){
		return $this->quizRepository->getTitleById($this->quizId);
	}


	public function getMessage(){
		if($this->send()){
			$message = trim($_POST[self::$message]);
			if (empty($message)) {
				$this->errorMessage = "<p id='error_new_question'>Det kan vara bra för dina spelare att få veta vad det är du skickat dem :)</p>";
				return null;
			}
			return $message;
		}
	}


	public function renderMessage($adressId){
		$title = $this->getTitle();
		$ret  ="		<html><body>";
		$ret .="		<h2>" . $title . "</h2>";
		$ret .="		<p>" . $this->getMessage() . "</p>";
		$ret .="		<a href=http://alengqvist.com/?" . NavigationView::$action . "=" . NavigationView::$actionPlay . "&" . NavigationView::$game . '=' . $this->quizId . "&" . NavigationView::$player . "=" . $adressId . ">Spela " . $title  . "</a>";
	    $ret .="	</body></html>";
	   	return $ret;
	}


	public function renderHeader(){
		$headers  = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	   	return $headers;
	}


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