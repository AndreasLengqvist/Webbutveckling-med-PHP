<?php

namespace controller;

require_once('src/view/GameView.php');
require_once("src/model/QuizRepository.php");
require_once("src/model/PlaySession.php");


class GameController{

	private $game;
	private $player;



	public function __construct(\model\PlaySession $playSession){
		$this->playSession = $playSession;
		$this->quizRepository = new \model\QuizRepository();
		$this->gameView = new \view\GameView($this->quizRepository);
	}


	public function setupGame(){
		
	// Hanterar indata.
		try {

			$gameId = \view\NavigationView::getUrlGame();
			$playerId = \view\NavigationView::getUrlPlayer();

			// När spelaren trycker på spela.
				if ($this->gameView->play()) {
					if (empty($gameId) or empty($playerId)){
						$this->gameView->setMessage("Ditt spel går inte att ladda. Var god tryck på direktlänken du fick i mailet igen.");
					}
					else{
						$this->playSession->setPlaySessions($gameId, $playerId);
						\view\NavigationView::RedirectToGameView();
					}
				}

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	// Generar utdata.
		return $this->gameView->showSetup();
	}


	public function playGame(){
	// Hanterar indata.
		try {

			$gameId = $this->playSession->getGameSession();
			$playerId = $this->playSession->getPlayerSession();

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	//Generar utdata.
		return $this->gameView->showQuestions($this->quizRepository->getQuestionsById($gameId), $gameId, $playerId);
	}
}