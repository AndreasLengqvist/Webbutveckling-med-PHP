<?php

namespace model;

require_once("Repository.php");


class QuizRepository extends Repository{

	private $db;
	private static $quizId = "quizid";
	private static $title = "title";
	private static $question = "question";
	private static $answer = "answer";



	public function createQuiz(Quiz $newQuiz){
		$this->dbTable = "quiz";

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::$quizId . ", " . self::$title . ") VALUES (?, ?)";

			$params = array($newQuiz->getQuizId(), $newQuiz->getTitle());

			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}


	public function addQuestion(Question $newQuestion){
		$this->dbTable = "question";

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::$quizId . ", " . self::$question . ", " . self::$answer . ") VALUES (?, ?, ?)";

			$params = array($newQuestion->getQuizId(), $newQuestion->getQuestion(), $newQuestion->getAnswer());

			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}


	/*public function quizExists($newTitle){
		$this->dbTable = "quiz";

		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::$title . " = ?";

			$params = array($newTitle);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			if (strtolower(trim(($result[self::$title])) === strtolower($newTitle)) {
				return true;
			}

		} catch (\Exception $e) {
			die("An error occured in the database!");
		}
	}*/


	public function getQuestions(){

	}


	public function getTitleById($id){
		$this->dbTable = "quiz";

		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::$quizId . " = ?";

			$params = array($id);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			return $result[self::$title];

		} catch (\Exception $e) {
			die("An error occured in the database!");
		}
	}

}