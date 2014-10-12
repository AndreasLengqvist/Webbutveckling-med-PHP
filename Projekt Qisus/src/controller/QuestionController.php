<?php

namespace controller;

require_once('src/view/QuestionView.php');
require_once("src/model/QuizRepository.php");


class QuestionController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->quizRepository = new \model\QuizRepository();
		$this->questionView = new \view\QuestionView($this->session->getSession(), $this->quizRepository);
	}


	public function doQuestion(){
		$quizId = $this->session->getSession();

		try {

			// Fortsätter till MailView.
			if($this->questionView->finished()){
				\view\NavigationView::RedirectToPlayerView();
			}


			// Börjar om från början.
			if($this->questionView->restart()){
				$questions = $this->quizRepository->getQuestionsById($quizId);
				$returnedQuestions = $questions->getQuestions();
				// Om det finns frågor kvar för quizet i databasen.
				if ($returnedQuestions) {
					foreach ($returnedQuestions as $question) {
						$this->quizRepository->deleteQuestion($question);
					}
				}
				$adresses = $this->quizRepository->getAdressesById($quizId);
				$returnedAdresses = $adresses->getAdresses();
				// Om det finns mailadresser kvar skapade för quizet i databasen.
				if ($returnedAdresses) {
					foreach ($returnedAdresses as $adress) {
						$this->quizRepository->deleteAdress($adress);
					}
				}
				$this->quizRepository->deleteQuiz($this->questionView->getQuizToDelete());
				$this->session->unSetSession();
				\view\NavigationView::RedirectHome();
			}


			// LÄGGER TILL - Om Question-objektet finns för att lägga till ny fråga.
			$newQuestion = $this->questionView->getQuestionData();
			if($newQuestion and $newQuestion->isValid()){
				$this->quizRepository->addQuestion($newQuestion);
			}


				// TA BORT fråga.
				if($this->questionView->deleteQuestion()){
					$deleteQuestion = $this->questionView->getQuestionToDelete();
					$this->quizRepository->deleteQuestion($deleteQuestion);
				}

				// UPPDATERA - Om Question-objektet finns för att lägga till uppdatera en fråga.
				$updatedQuestion = $this->questionView->getUpdatedData();
				if($updatedQuestion and $updatedQuestion->isValid()){
					$this->quizRepository->updateQuestion($updatedQuestion);
				}

		} catch (\Exception $e) {
			echo $e;
			die();
		}
		// Generar utdata.
		return $this->questionView->show($this->quizRepository->getQuestionsById($quizId));
			
	}
}