<?php

namespace view;

require_once("NavigationView.php");
require_once("src/model/QuizRepository.php");


class MailView{

	private static $message = 'message';
	private static $mailadresses = 'mailadresses';
	private static $back = 'back';
	private static $send = 'send';



	public function backToQuestions(){
		return isset($_POST[self::$back]);
	}


	public function show(){
		$ret = "
				<h4>qisus.</h4>
				<h5>Maillista</h5>
				<div id='mail_div'>
					<form method='post'>
						<label for='message_input' id='message_label'>Här skriver du in det meddelande som dina spelare ska få i mailet...</label><br>
				        <textarea id='message_input' rows='4' cols='50' name='" . self::$message . "'>Det kan kanske t ex. vara bra att berätta för dem vad det är för sorts quiz? :)</textarea><br>
						<label for='addresses_input' id='message_label'>Här under matar du enkelt in de mailadresser som quizet ska skickas till...</label><br>
				        <textarea id='addresses_input' rows='5' cols='50' name='" . self::$mailadresses . "'>spelare1@gmail.se, ← PS. glöm inte kommatecknet efter varje ny adress!</textarea><br>
	    				<input id='restartbutton' type='submit' value='← Tillbaka' name='" . self::$back . "'>
	    				<input id='finishbutton' type='submit' value='Skicka →' name='" . self::$send . "'>
					</form>
				</div>
				";
		return $ret;
	}
}