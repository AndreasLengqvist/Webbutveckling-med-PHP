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



	public function backToPlayers(){
		return isset($_POST[self::$back]);
	}

	public function send(){
		return isset($_POST['send']);
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


	public function getTitle(){
		return $this->quizRepository->getTitleById($this->quizId);
	}


	public function renderMessage($quizId, $adressId, $clientMessage){
		$ret = "
				<html>
					<body>
						<p> $clientMessage </p>
						<a href=" . \Config::$ROOT_PATH . '/?' . NavigationView::$action.'='.NavigationView::$actionPlay . '/' . $quizId . '&' . $adressId . "/>
					</body>
				</html>
			   ";

	   return $ret;
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
}