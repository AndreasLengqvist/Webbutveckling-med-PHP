<?php

namespace controller;

require_once('src/view/QuestionView.php');
require_once("src/model/QuizRepository.php");


class QuestionController{

	private $session;



	public function __construct(\model\CreateSession $createSession){
		$this->createSession = $createSession;
		$this->quizRepository = new \model\QuizRepository();
		$this->questionView = new \view\QuestionView($this->createSession->getCreateSession(), $this->quizRepository);
	}


	public function doQuestion(){
		
		// Hanterar indata.
			try {

				if (!$this->createSession->createSessionIsset()) {
					\view\NavigationView::RedirectHome();
				}

				$quizId = $this->createSession->getCreateSession();

				// Fortsätt till MailView.
				if($this->questionView->finished()){
					\view\NavigationView::RedirectToPlayerView();
				}


				// Börja om från början.
				if($this->questionView->restart()){

			// KAN TAS BORT??
					$questions = $this->quizRepository->getQuestionsById($quizId);
					$returnedQuestions = $questions->getQuestions();
					$adresses = $this->quizRepository->getAdressesById($quizId);
					$returnedAdresses = $adresses->getAdresses();

					// Om det finns frågor sparade i databasen.
					if ($returnedQuestions) {
						foreach ($returnedQuestions as $question) {
							$this->quizRepository->deleteQuestion($question);
						}
					}
					// Om det finns mailadresser skapade i databasen.
					if ($returnedAdresses) {
						foreach ($returnedAdresses as $adress) {
							$this->quizRepository->deleteAdress($adress);
						}
					}
					$this->quizRepository->deleteQuiz($this->questionView->getQuizToDelete());
					$this->createSession->unSetCreateSession();
					\view\NavigationView::RedirectHome();
				}


				// LÄGG TILL - Om Question-objektet är validerat och satt.
				$newQuestion = $this->questionView->getQuestionData();
				if($newQuestion and $newQuestion->isValid()){
					$this->quizRepository->addQuestion($newQuestion);
				}

					// TA BORT FRÅGA.
					if($this->questionView->deleteQuestion()){
						$deleteQuestion = $this->questionView->getQuestionToDelete();
						$this->quizRepository->deleteQuestion($deleteQuestion);
					}

					// UPPDATERA FRÅGA - Om Question-objektet är validerat och satt.
					$updatedQuestion = $this->questionView->getUpdatedData();
					if($updatedQuestion and $updatedQuestion->isValid()){
						$this->quizRepository->updateQuestion($updatedQuestion);
					}

			} catch (\Exception $e) {
				echo $e;
				die();
			}

	// Generar utdata.
		return $this->questionView->show();
	}
}