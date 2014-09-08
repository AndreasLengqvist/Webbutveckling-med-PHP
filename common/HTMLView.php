<?php

class HTMLView{
	public function echoHTML($body){
		if($body == NULL){
			throw \Exception("HTMLView::echoHTML does not allow body to be null");
		}

		var_dump($body);



		echo "
			<!DOCTYPE html>
			<html>
			<body>

				$body
				
			</body>
			</html>";
	}
}