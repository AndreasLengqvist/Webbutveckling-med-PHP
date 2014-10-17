<?php

namespace controller;

require_once('src/model/MemberRepository.php');
require_once('src/model/BoatRepository.php');
require_once('src/model/Session.php');
require_once('src/view/MemberView.php');



class MemberController{

private $memberView;
private $session;
private $memberRepository;
private $boatRepository;



	public function __construct(){
		$this->memberRepository = new \model\MemberRepository();
		$this->boatRepository = new \model\BoatRepository();
		$this->session= new \model\Session();
		$this->memberView = new \view\MemberView($this->memberRepository, $this->boatRepository);
	}



	public function createMember(){

		// Hanterar indata.
			try {

				$member = $this->memberView->getMemberData();

				if ($member and $member->isValid()) {
					$this->memberRepository->addMember($member);
					return \view\NavigationView::RedirectToHome();
				}

				
			} catch (\Exception $e) {
				echo $e;
				die();
			}

		// Generar utdata.
			return $this->memberView->showCreateMember();
		}


	public function showMember(){

		// Hanterar indata.
			try {

			$member = $this->memberRepository->getMemberById($this->session->getSession());


			// TA BORT medlem.
				if($this->memberView->deleteMember()){
					$member = $this->memberView->getMemberToDelete();
					$this->memberRepository->deleteMember($member);
					return \view\NavigationView::RedirectToHome();
				}

			} catch (\Exception $e) {
				echo $e;
				die();
			}

		// Generar utdata.
			return $this->memberView->showMember($member);
		}
}