<?php

namespace view;

require_once("src/model/Quiz.php");
require_once("NavigationView.php");


class TitleView{

	private static $title = 'title';
	private static $submit = 'submit';


	public function submitTitle(){
		return isset($_POST['submit']);
	}


	/*
	public function renderCRUD(){

		$this->render = "
							<label>Fråga 1</label><br>
					        <textarea id='questionbox' rows='4' cols='50' name='question'></textarea><br>
							<Input type = 'radio' Name = 'answer' VALUE = 'TRUE' checked>		        		
							<Input type = 'radio' Name = 'answer' VALUE = 'FALSE'>		        		
						";
	}

	public function showMailForm(){
		$adder = "";

		$ret = "
					<a id='navbutton' href='?'>Tillbaka!</a>

					<form method='post'>
				        <textarea id='mailbox' rows='4' cols='50' name='mailbox'></textarea><br>
	    				<input type='submit' value='Skicka iväg quizet!' name='submit'>
					</form>
				";

		return $ret;
	}*/


	public function getTitle(){
		if(empty($_POST[TitleView::$title])){
			throw new \Exception("Hörrö, ditt quiz måste heta något! ;)");
		}
		return new \model\Quiz($_POST[TitleView::$title]);
	}


// TODO - bryta ut menyn.
	public function show(){

		$ret = "
					<a id='backbutton' href='?" . NavigationView::$action . "=" . NavigationView::$actionHome . "'>Tillbaka!</a>
					<h3>qisus.</h3>
					<div id='title_wrap'>
						<form method='post'>
							<label id='title_label' for='title'>Vad ska quizet heta?</label><br>
							<input id='title' type='text' name='" . TitleView::$title . "'><br>
							<input id='title_button' type='submit' value='klar' name='" . TitleView::$submit . "'>
						</form>
					</div>
				";

		return $ret;
	}
}