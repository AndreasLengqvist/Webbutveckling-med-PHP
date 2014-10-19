<?php

namespace model;

require_once("src/model/Repository.php");
require_once("src/model/Question.php");
require_once("src/model/Questions.php");


class QuestionRepository extends Repository{

	protected $dbTable;
	
	const quizId = "quizid";
	const questionId = "questionId";
	const question = "question";
	const answer = "answer";



	public function __construct(){
		$this->dbTable = "question";
	}


	public function addQuestion(Question $question){

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::quizId . ", " . self::question .", " . self::answer . ", " . self::questionId . ") VALUES (?, ?, ?, ?)";

			$params = array($question->getQuizId(), $question->getQuestion(), $question->getAnswer(), $question->getQuestionId());
			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {

			error_log($e->getMessage() . "\n", 3, \Config::ERROR_LOG);

			if (\Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function updateQuestion(Question $question) {				

		try{
			$db = $this -> connection();

			$sql = "UPDATE $this->dbTable SET " . self::quizId . "=?, " . self::question . "=?, " . self::answer . "=? WHERE " . self::questionId ."=?";

			$params = array($question->getQuizId(), $question->getQuestion(), $question->getAnswer(), $question->getQuestionId());

			$query = $db -> prepare($sql);
			$query -> execute($params);

		} catch (\Exception $e) {

			error_log($e->getMessage() . "\n", 3, \Config::ERROR_LOG);

			if (\Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function deleteQuestion(Question $question) {
				
		try{
			$db = $this->connection();

			$sql = "DELETE FROM $this->dbTable
					WHERE " . self::questionId . " = ?";
			$params = array($question->getQuestionId());

			$query = $db->prepare($sql);
			$query->execute($params);

		} catch (\Exception $e) {

			error_log($e->getMessage() . "\n", 3, \Config::ERROR_LOG);

			if (\Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}


	public function getQuestionsById($id){

		$questions = new Questions();
		
		try {
			$db = $this->connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::quizId . " = ?";
			$params = array($id);

			$query = $db->prepare($sql);
			$query->execute($params);
			foreach ($query->fetchAll() as $q) {
				
				$qu = $q[self::question];
				$a = $q[self::answer];
				$qId = $q[self::questionId];

				$question = new Question($id, $qu, $a, $qId);

				$questions->addQuestions($question);
			}
			return $questions;
			
		} catch (\PDOException $e) {

			error_log($e->getMessage() . "\n", 3, \Config::ERROR_LOG);

			if (\Config::DEBUG) {
				echo $e;
			} else{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}
}