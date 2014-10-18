<?php

namespace model;

require_once("src/model/Repository.php");
require_once("src/model/Question.php");
require_once("src/model/Questions.php");
require_once("src/model/Adress.php");
require_once("src/model/Adresses.php");


class AdressRepository extends Repository{

	protected $dbTable;

	private $adresses;
	
	const quizId = "quizid";
	const title = "title";
	const creator = "creator";
	const questionId = "questionId";
	const question = "question";
	const answer = "answer";
	const adress = "adress";
	const adressId = "adressId";



	public function __construct(){
		$this->dbTable = "mail";
		$this->adresses = new Adresses();
	}


	public function addAdress(Adress $adress){

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::quizId . ", " . self::adress .", " . self::adressId . ") VALUES (?, ?, ?)";

			$params = array($adress->getQuizId(), $adress->getAdress(), $adress->getAdressId());
			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}
	

	public function deleteAdress(Adress $adress) {
				
		try{
			$db = $this->connection();

			$sql = "DELETE FROM $this->dbTable
					WHERE " . self::adressId . " = ?";
			$params = array($adress->getAdressId());

			$query = $db->prepare($sql);
			$query->execute($params);

		} catch (\Exception $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function getAdressById($id){

		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::$adressId . " = ?";

			$params = array($id);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			return $result[self::adress];

		} catch (\Exception $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function getAdressesById($id){
		
		try {
			$db = $this->connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::quizId . " = ?";
			$params = array($id);

			$query = $db->prepare($sql);
			$query->execute($params);
			foreach ($query->fetchAll() as $q) {
				$a = $q[self::adress];
				$aId = $q[self::adressId];

				$adress = new Adress($id, $a, $aId);

				$this->adresses->addAdresses($adress);
			}
			return $this->adresses;
		} catch (\PDOException $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}

}