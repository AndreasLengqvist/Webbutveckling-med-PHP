<?php

class HTMLView{
	public function echoHTML($body){
		if($body === NULL){
			throw new \Exception("HTMLView::echoHTML does not allow body to be null");
		}

		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset='UTF-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1'>
				<link rel='stylesheet' type='text/css' href='css/reset_stylesheet.css'>
				<link rel='stylesheet' type='text/css' href='css/stylesheet.css'>
			</head>
			<body>

				$body
				
			</body>
			</html>";
	}
}