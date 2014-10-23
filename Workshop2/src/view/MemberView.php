<?php

namespace view;

require_once('src/model/Member.php');


class MemberView{

	private $session;
	private $errorMessage;
	private $memberRepository;
	private $boatRepository;

	const firstname = 'firstname';
	const lastname = 'lastname';
	const persId = 'persId';
	const memberId = 'memberId';

	const addBoat = 'addBoat';
	const editBoat = 'editBoat';
	const deleteBoat = 'deleteBoat';

	const addMember = 'addMember';
	const deleteMember = 'deleteMember';
	const editMember = 'editMember';



	public function __construct(\model\MemberRepository $memberRepository, \model\BoatRepository $boatRepository){
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}


	public function addMember(){
		return isset($_POST[self::addMember]);
	}

	public function deleteMember(){
		return isset($_POST[self::deleteMember]);
	}

	public function editMember(){
		return isset($_POST[self::editMember]);
	}

	public function getMemberToDelete(){
		return $_POST[self::memberId];		
	}

	public function getMemberData(){
		if ($this->addMember()) {
			try {
				return new \model\Member(NULL, $_POST[self::firstname], $_POST[self::lastname], $_POST[self::persId]);
			} catch (\Exception $e) {
				$this->errorMessage = "<p>" . $e->getMessage() . "</p>";
			}
		}
	}


	public function showMember(\model\Member $member){

		$memberId = $member->getMemberId();
		$boats = $this->boatRepository->getBoatsByMemberId($memberId);

		$ret = "
					<h1>Den glade piraten</h1>
					<a id='navbutton' href='?'>Tillbaks</a><br>

					<h2>" . $member->getFirstname() . $member->getLastname() . "</h1>
					<div class='member_div'>
						<form method='post'>
							<input type='submit' value='Redigera medlem' name='" . self::editMember . "'>
							<input type='submit' value='Ta bort medlem' name='" . self::deleteMember . "'>
							<ul>
								<li>Personnummer: " . $member->getFirstname() . $member->getLastname() . "</li>
								<li>Medlems-ID: " . $memberId . "</li>
								<input type='hidden' value='" . $memberId . "' name='" . self::memberId . "'>
				";

		foreach ($boats->getBoats() as $boat) {

			$ret .= "	
								<ul>
									<li>Båt: " . $boat->getBoatId() . ":</li>
										<ul>
										<li>Båttyp: " . $boat->getBoattype() . "</li>
										<li>Längd: " . $boat->getLength() . "</li>
										</ul>
								</ul>
								<input type='submit' value='Redigera båt' name='" . self::editBoat . "'>
								<input type='submit' value='Ta bort båt' name='" . self::deleteBoat . "'>
					";
		}

		$ret .= "
							</ul>
							<input type='submit' value='Lägg till ny båt' name='" . self::addBoat . "'>
						</form>
					</div>


				";

		return $ret;
	}


	public function showCreateMember(){

		$errorMessage = $this->errorMessage;

		$ret = "
					<h1>Den glade piraten</h1>
					<a id='navbutton' href='?'>Tillbaks</a><br>

					<h2>Skapa medlem</h1>

					$errorMessage

					<form method='post'>
						<div>
							<label for='firstname'>Förnamn</label>
						</div>
						<div>
							<input id='firstname' type='text' name='" . self::firstname . "'>
						</div>
						<div>
							<label for='lastname'>Efternamn</label>
						</div>
						<div>
							<input id='lastname' type='text' name='" . self::lastname . "'>
						</div>
						<div>
							<label for='persId'>Personnummer</label>
						</div>
						<div>
							<input id='persId' type='text' name='" . self::persId . "'>
						</div>

	    				<div>
							<input class='continueButton' type='submit' value='Skapa' name='" . self::addMember . "'>
						</div>
					</form>

				";

		return $ret;
	}
}