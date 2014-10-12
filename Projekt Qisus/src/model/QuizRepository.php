<?php

namespace model;

require_once("Repository.php");
require_once("Question.php");
require_once("Questions.php");
require_once("Adress.php");
require_once("Adresses.php");


class QuizRepository extends Repository{

	private $db;
	private $questions;
	private $adresses;
	private static $quizId = "quizid";
	private static $title = "title";
	private static $questionId = "questionId";
	private static $question = "question";
	private static $answer = "answer";
	private static $adress = "adress";
	private static $adressId = "adressId";

	public function __construct(){
		$this->questions = new Questions();
		$this->adresses = new Adresses();
	}


	public function createQuiz(Quiz $quiz){
		$this->dbTable = "quiz";

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::$quizId . ", " . self::$title . ") VALUES (?, ?)";

			$params = array($quiz->getQuizId(), $quiz->getTitle());

			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}

		public function deleteQuiz(Quiz $quiz) {
			$this->dbTable = "quiz";
					
			try{
				$db = $this -> connection();

				$sql = "DELETE FROM $this->dbTable
						WHERE " . self::$quizId . " = ?";
				$params = array($quiz -> getQuizId());

				$query = $db -> prepare($sql);
				$query -> execute($params);

			} catch (\Exception $e) {
				echo $e;
				die("An error occured in the database!");
			}
		}



	public function addQuestion(Question $question){
		$this->dbTable = "question";

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::$quizId . ", " . self::$question .", " . self::$answer . ", " . self::$questionId . ") VALUES (?, ?, ?, ?)";

			$params = array($question->getQuizId(), $question->getQuestion(), $question->getAnswer(), $question->getQuestionId());
			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}


		public function updateQuestion(Question $question) {
			$this->dbTable = "question";
					

			try{
				$db = $this -> connection();

				$sql = "UPDATE $this->dbTable SET " . self::$quizId . "=?, " . self::$question . "=?, " . self::$answer . "=? WHERE " . self::$questionId ."=?";

				$params = array($question->getQuizId(), $question->getQuestion(), $question->getAnswer(), $question->getQuestionId());

				$query = $db -> prepare($sql);
				$query -> execute($params);

			} catch (\Exception $e) {
				echo $e;
				die("An error occured in the database!");
			}
		}


		public function deleteQuestion(Question $question) {
			$this->dbTable = "question";
					
			try{
				$db = $this->connection();

				$sql = "DELETE FROM $this->dbTable
						WHERE " . self::$questionId . " = ?";
				$params = array($question->getQuestionId());

				$query = $db->prepare($sql);
				$query->execute($params);

			} catch (\Exception $e) {
				echo $e;
				die("An error occured in the database!");
			}
		}


	public function addAdress(Adress $adress){
		$this->dbTable = "mail";

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::$quizId . ", " . self::$adress .", " . self::$adressId . ") VALUES (?, ?, ?)";

			$params = array($adress->getQuizId(), $adress->getAdress(), $adress->getAdressId());
			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}
	
		public function deleteAdress(Adress $adress) {
			$this->dbTable = "mail";
					
			try{
				$db = $this->connection();

				$sql = "DELETE FROM $this->dbTable
						WHERE " . self::$adressId . " = ?";
				$params = array($adress->getAdressId());

				$query = $db->prepare($sql);
				$query->execute($params);

			} catch (\Exception $e) {
				echo $e;
				die("An error occured in the database!");
			}
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


	public function getQuestionsById($id){
		$this->dbTable = "question";
		
		try {
			$db = $this->connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$quizId . " = ?";
			$params = array($id);

			$query = $db->prepare($sql);
			$query->execute($params);
			foreach ($query->fetchAll() as $q) {
				$qu = $q[self::$question];
				$a = $q[self::$answer];
				$qId = $q[self::$questionId];

				$question = new Question($id, $qu, $a, $qId);

				$this->questions->addQuestions($question);
			}
			return $this->questions;
		} catch (\PDOException $e) {
			die('Error while connection to database.');
		}
	}


	public function getAdressesById($id){
		$this->dbTable = "mail";
		
		try {
			$db = $this->connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$quizId . " = ?";
			$params = array($id);

			$query = $db->prepare($sql);
			$query->execute($params);
			foreach ($query->fetchAll() as $q) {
				$a = $q[self::$adress];
				$aId = $q[self::$adressId];

				$adress = new Adress($id, $a, $aId);

				$this->adresses->addAdresses($adress);
			}
			return $this->adresses;
		} catch (\PDOException $e) {
			die('Error while connection to database.');
		}
	}

}