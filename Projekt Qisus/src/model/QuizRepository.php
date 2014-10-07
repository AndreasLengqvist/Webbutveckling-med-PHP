<?php

namespace model;

require_once("Repository.php");


class QuizRepository extends Repository{

	private $db;
	private static $quizId = "quizId";
	private static $title = "title";



	public function __construct(){
		$this->dbTable = "quiz";
	}


	public function createQuiz(Quiz $newQuiz){
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


	public function quizExists($newTitle){
		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::$title . " = ?";

			$params = array($newTitle);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			if (strtolower($result[self::$title]) === strtolower($newTitle)) {
				return true;
			}

		} catch (\Exception $e) {
			die("An error occured in the database!");
		}
	}

}