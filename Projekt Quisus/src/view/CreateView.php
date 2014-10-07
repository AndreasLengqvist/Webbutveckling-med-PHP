<?php

namespace view;

require_once("src/model/Quiz.php");
require_once("NavigationView.php");


class CreateView{

	private static $title = 'title';



	public function submitQuestion(){
		return isset($_POST['submit']);
	}

	public function newQuestion(){
		return isset($_POST['add']);
	}

	public function getQuestion(){
		return $_POST['question'];
	}

	public function getAnswer(){
		return $_POST['answer'];
	}



	/*public function addQuestion(){

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
		return $_POST[CreateView::$title];
	}

	public function show(){

		$ret = "
					<a id='navbutton' href='?" . NavigationView::$action . "=" . NavigationView::$actionHome . "'>Tillbaka!</a>
					<form method='post'>
						<label id='title_label' for='title'>Vad heter quizet?</label><br>
						<input id='title' type='text' name='title'><br>
						<input id='title_button' type='submit' value='Skapa!' name='submit'>
					</form>
				";

		return $ret;
	}
}