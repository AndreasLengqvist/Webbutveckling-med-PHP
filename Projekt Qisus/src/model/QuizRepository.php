<?php

namespace model;

require_once("Repository.php");
require_once("Question.php");
require_once("Questions.php");


class QuizRepository extends Repository{

	private $db;
	private $questions;
	private static $quizId = "quizid";
	private static $title = "title";
	private static $question = "question";
	private static $answer = "answer";

	public function __construct(){
		$this->questions = new Questions();
	}


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
			var_dump($params);
			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
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

				$question = new Question($id, $qu, $a);

				$this->questions->addQuestions($question);
			}
			return $this->questions;
		} catch (\PDOException $e) {
			die('Error while connection to database.');
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

}