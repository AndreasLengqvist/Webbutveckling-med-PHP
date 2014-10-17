<?php

namespace controller;

require_once('src/view/ListView.php');
require_once('src/model/MemberRepository.php');
require_once('src/model/BoatRepository.php');
require_once('src/model/Session.php');



class ListController{

private $listView;
private $memberRepository;
private $boatRepository;
private $session;
private $members;



	public function __construct(){
		$this->session = new \model\Session();
		$this->memberRepository = new \model\MemberRepository();
		$this->boatRepository = new \model\BoatRepository();
		$this->listView = new \view\ListView($this->memberRepository, $this->boatRepository);

		$this->members = $this->memberRepository->getMembers();
	}


	public function showCompact(){
		

		if($this->listView->goToShowMember()){
			$this->session->setSession($this->listView->getMember());
			return \view\NavigationView::RedirectToShowMember();
		}

		return $this->listView->showCompact($this->members);
	}


	public function showDetailed(){


		if($this->listView->goToShowMember()){
			$this->session->setSession($this->listView->getMemberId());
			return \view\NavigationView::RedirectToShowMember();
		}

		return $this->listView->showDetailed($this->members);
	}

}