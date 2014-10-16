<?php

namespace controller;

require_once("common/UserAgent.php");
require_once("src/model/QuizRepository.php");
require_once("src/model/PlaySession.php");
require_once('src/view/GameView.php');


class GameController{

	private $useragent;
	private $playSession;
	private $quizRepository;
	private $gameView;



	public function __construct(){
		$this->playSession = new \model\PlaySession();
		$this->useragent = new \UserAgent();
		$this->quizRepository = new \model\QuizRepository();
		$this->gameView = new \view\GameView($this->playSession, $this->quizRepository);
	}


	public function setupGame(){
	
	// Hanterar indata.
		try {

			// Redirects för olika URL-tillstånd.
				if ($this->playSession->playSessionsIsset()) {
					\view\NavigationView::RedirectToGameView();
				}


			// När spelaren trycker på spela.
				$game = $this->gameView->getSetupData();
				if ($game and $game->isValid()) {
					$this->playSession->setPlaySessions($game->getGameId(), $game->getPlayerId(), $this->useragent->getUserAgent());
					\view\NavigationView::RedirectToGameView();
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
			
			// Redirects för olika URL-tillstånd.
				if (!$this->playSession->playSessionsIsset()) {
				\view\NavigationView::RedirectToSetupView();
				}

			// Fuskförebyggande - om spelaren försöker ladda samma spel från en annan webbläsare/dator.
				if (!$this->playSession->checkPlayerAgent($this->useragent->getUserAgent())) {
					$this->playSession->unSetPlaySessions();
					\view\NavigationView::RedirectToSetupView();
				}

			$gameId = $this->playSession->getGameSession();
			$playerId = $this->playSession->getPlayerSession();

			$questions = $this->quizRepository->getQuestionsById($gameId);

			$this->gameView->getAnswers($questions);

			if($this->playSession->answerSessionIsset()){
				$answers = $this->playSession->getAnswersSession();

				if (!in_array(null, $answers)){

					$titleToRender = $this->quizRepository->getTitleById($gameId);
					$player = $this->quizRepository->getAdressById($playerId);
					$to = $this->quizRepository->getCreatorById($gameId);
					$title = $this->gameView->renderTitle($player, $titleToRender);
					$message = $this->gameView->renderMessage($gameId, $player, $titleToRender, $questions, $answers);
					$header = $this->gameView->renderHeader();
					mail($to, $title, $message, $header);

					$this->playSession->unSetPlaySessions();
					$this->quizRepository->deleteAdress(new\model\Adress("delete", $player, $playerId));

					return $this->gameView->showSent($to);
				}
			}




		} catch (\Exception $e) {
			echo $e;
			die();
		}

	//Generar utdata.
		return $this->gameView->showQuestions($questions);
	}
}