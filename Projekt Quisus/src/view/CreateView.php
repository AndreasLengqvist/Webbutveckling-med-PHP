<?php

namespace view;


class CreateView{

	private $render;

	public function submitQuestions(){
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

	public function addQuestion(){
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
	}

	public function show(){
		$adder = "";

		$ret = "
					<a id='navbutton' href='?'>Tillbaka!</a>

					<form method='post'>";
        $ret .= "      $this->render";
	    $ret .= "      <input type='submit' value='Lägg till fråga' name='add'>
	    			   <input type='submit' value='Klar!' name='submit'>
					</form>
				";

		return $ret;
	}
}