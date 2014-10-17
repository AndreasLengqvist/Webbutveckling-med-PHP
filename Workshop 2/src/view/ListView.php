<?php

namespace view;

require_once('src/model/Session.php');


class ListView{

	private $memberRepository;


	const goToMember = 'goToMember';
	const memberId = 'memberId';
	private static $creator = 'creator';
	private static $submitTitle = 'submitTitle';
	private static $submitCreator = 'submitCreator';
	private static $back = 'back';



	public function __construct(\model\MemberRepository $memberRepository, \model\BoatRepository $boatRepository){
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}



	public function goToShowMember(){
		return isset($_POST[self::goToMember]);
	}


	public function getMemberId(){
		return $_POST[self::memberId];
	}


/**
  * Visar en kompakt lista av medlemmar.
  *
  * @param $members Array of Member-objects.
  *
  * @return string Returns the html for showCompact.
  */
	public function showCompact(\model\Members $members){

			$ret = "
						<h1>Den glade piraten</h1>
						<a id='navbutton' href='?" . NavigationView::action . '=' . NavigationView::actionShowDetailed . "'>Lista detaljerad</a><br>
						<a id='navbutton' href='?" . NavigationView::action . '=' . NavigationView::actionCreateMember . "'>Skapa medlem</a>

						<h2>Kompakt lista</h2>
					";

		foreach ($members->getMembers() as $member) {
			
			$memberId = $member->getMemberID();
			$boats = $this->boatRepository->getBoatsByMemberId($memberId);
			$numberOfBoats = count($boats->getBoats());

			$ret .= "
						<div class='member_div'>
						<form method='post'>
						<ul>
						<li>Medlem: " . $member->getFirstname() . " " . $member->getLastname() . "</li>
						<li>Medlems-ID: " . $memberId . "</li>
						<li>Antal båtar: " . $numberOfBoats . "</li>
						<input type='hidden' value='" . $memberId . "' name='" . self::memberId . "'>
						<input type='submit' value='Visa medlem' name='" . self::goToMember . "'>
						</ul>
						</form>
						</div>

					";
		}
		$ret .= "
				";
		return $ret;
	}


/**
  * Visar en detaljerad lista av medlemmar.
  *
  * @param $members Array of Member-objects.
  *
  * @return string Returns the html for showDetailed.
  */
	public function showDetailed(\model\Members $members){


			$ret = "
						<h1>Den glade piraten</h1>
						<a id='navbutton' href='?" . NavigationView::action . '=' . NavigationView::actionShowCompact . "'>Lista kompakt</a><br>
						<a id='navbutton' href='?" . NavigationView::action . '=' . NavigationView::actionCreateMember . "'>Skapa medlem</a>
						
						<h2>Detaljerad lista</h2>
					";

		foreach ($members->getMembers() as $member) {

			$memberId = $member->getMemberID();
			$boats = $this->boatRepository->getBoatsByMemberId($memberId);

			$ret .= "					
						<div class='member_div'>
						<form method='post'>
						<ul>
						<li>Medlem: " . $member->getFirstname() . " " . $member->getLastname() . "</li>
						<li>Personnummer: " . $member->getPersId() . "</li>
						<li>Medlems-ID: " . $memberId . "</li>
					";	

			if ($boats->getBoats()) {

			$ret .= "
						<li>Båtar:</li>
					";
			}

			foreach ($boats->getBoats() as $boat) {

			$ret .= "	
						<ul>
						<li>Båt: " . $boat->getBoatId() . ":</li>
						<ul>
						<li>Båttyp: " . $boat->getBoattype() . "</li>
						<li>Längd: " . $boat->getLength() . "</li>
						</ul>
						</ul>
					";
			}

			$ret .= "		
						<input type='hidden' value='" . $memberId . "' name='" . self::memberId . "'>
						<input type='submit' value='Visa medlem' name='" . self::goToMember . "'>
						</ul>
						</form>
						</div>
					";
		}

			$ret .= "
						</div>
					";
		return $ret;
	}
}