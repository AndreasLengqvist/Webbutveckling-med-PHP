<?php

namespace view;


class NavigationView{

	// Kontrollerar om användare tryckt på skapa.
	public function createPressed(){
		return isset($_GET["skapa"]);
	}

	// Här kan jag ha en funktion som kollar den aktuella adressfältet och på så viss navigera mig rätt.


	public function show(){
		$ret = "
					<a id='navbutton' href='?skapa'>Skapa!</a>
				";

		return $ret;
	}
}