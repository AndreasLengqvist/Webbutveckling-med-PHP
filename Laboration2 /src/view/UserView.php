<?php



class UserView{
	
	private $model;


	public function __construct(LoginModel $model){
		$this->model = $model;
	}


	public function showUser(){
	
	

	$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>";

	$ret .= "<h2> är nu inloggad!</h2>";
	
	$ret .= "<p>Inloggningen lyckades!</p>";

	$ret .= "
				<form action='?logout' method='post' >
				<input type='submit' value='Logga ut' name='logout'>
				</form>
			";		

	return $ret;
}


}