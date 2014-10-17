<?php

namespace controller;




class BoatController{




	public function doCreator(){

		// Hanterar indata.
			try {

				
			} catch (\Exception $e) {
				echo $e;
				die();
			}

		// Generar utdata.
			return $this->createView->showCreateCreator();
		}
}