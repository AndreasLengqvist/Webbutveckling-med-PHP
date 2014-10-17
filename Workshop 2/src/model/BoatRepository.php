<?php

namespace model;

require_once("src/model/Repository.php");
require_once("src/model/Boat.php");
require_once("src/model/Boats.php");


class BoatRepository extends Repository{

	protected $dbTable;

	const memberId = "memberId";
	const boattype = "boattype";
	const length = "length";
	const boatId = "boatId";


	public function __construct(){
		$this->dbTable = "boat";	
	}

/*
	public function addBoat(Boat $boat){

		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::memberId . ", " . self::boatId . ", " . self::boattype . ", " . self::length . ") VALUES (?, ?, ?, ?)";

			$params = array($boat->getMemberId(), $boat->getBoatId(), $boat->getBoattype(), $boat->getLength());

			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}


	public function deleteBoat($id) {
				
		try{
			$db = $this -> connection();

			$sql = "DELETE FROM $this->dbTable
					WHERE " . self::boatId . " = ?";
			$params = array($id);

			$query = $db -> prepare($sql);
			$query -> execute($params);

		} catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}
*/

	public function getBoatsByMemberId($id){
		
		$boats = new Boats();

		try {
			$db = $this->connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::memberId . " = ?";
			$params = array($id);

			$query = $db->prepare($sql);
			$query->execute($params);
			foreach ($query->fetchAll() as $b) {
				$bId = $b[self::boatId];
				$bt = $b[self::boattype];
				$l = $b[self::length];

				$boat = new Boat($id, $bId, $bt, $l);

				$boats->addBoats($boat);
			}
			return $boats;
		} catch (\PDOException $e) {
			die('Error while connection to database.');
		}
	}
/*


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
		*/
}