<?php

namespace model;

require_once("src/model/Repository.php");


class QuizRepository extends Repository{

	protected $dbTable;
	
	const quizId = "quizid";
	const title = "title";
	const creator = "creator";



	public function __construct(){
		$this->dbTable = "quiz";
	}


	public function createQuiz(Quiz $quiz){

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::quizId . ", " . self::title . ", " . self::creator . ") VALUES (?, ?, ?)";

			$params = array($quiz->getQuizId(), $quiz->getTitle(), $quiz->getCreator());

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


	public function deleteQuiz($quizId) {
				
		try{
			$db = $this -> connection();

			$sql = "DELETE FROM $this->dbTable
					WHERE " . self::quizId . " = ?";
			$params = array($quizId);

			$query = $db -> prepare($sql);
			$query -> execute($params);

		} catch (\Exception $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function getTitleById($id){

		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::quizId . " = ?";

			$params = array($id);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			return $result[self::title];

		} catch (\Exception $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function getCreatorById($id){

		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::quizId . " = ?";

			$params = array($id);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			return $result[self::creator];

		} catch (\Exception $e) {
			if (Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}
}