<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/QuestionView.php');


class QuestionController{

	private $createSession;
	private $quizRepository;
	private $questionView;



	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->quizRepository = new \model\QuizRepository();
		$this->questionView = new \view\QuestionView($this->createSession, $this->quizRepository);
	}


	public function doQuestion(){
		
		// Hanterar indata.
			try {

				// Redirects för olika URL-tillstånd.
					if (!$this->createSession->createSessionIsset()) {
						\view\NavigationView::RedirectHome();
					}

					if($this->questionView->finished()){
						\view\NavigationView::RedirectToPlayerView();
					}


				// RESTART - tar bort quizet alla frågor och adresser tillhörande quizet.
					if($this->questionView->restart()){
						
						$quizId = $this->createSession->getCreateSession();
						$questions = $this->quizRepository->getQuestionsById($quizId);
						$adresses = $this->quizRepository->getAdressesById($quizId);

						// Om det finns frågor sparade i databasen.
							if ($questions) {
								$returnedQuestions = $questions->getQuestions();
								foreach ($returnedQuestions as $question) {
									$this->quizRepository->deleteQuestion($question);
								}
							}

						// Om det finns mailadresser skapade i databasen.
							if ($adresses) {
								$returnedAdresses = $adresses->getAdresses();
								foreach ($returnedAdresses as $adress) {
									$this->quizRepository->deleteAdress($adress);
								}
							}

						$this->quizRepository->deleteQuiz($this->questionView->getQuizToDelete());
						$this->createSession->unSetCreateSession();
						\view\NavigationView::RedirectHome();
					}


					// LÄGG TILL - Om Question-objektet är validerat och satt.
						$newQuestion = $this->questionView->getAddData();
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