<?php

/* Restricts access to specified user types */

/* Required Files */
Hypworks::loadDao('Candidate');
Hypworks::loadDao('Party');
Hypworks::loadDao('Position');
Hypworks::loadDao('Vote');

/* Assign/Initialize common variables */

/* Data Gathering */
$positions = Position::selectAll();
foreach($positions as $key => $position) {
	$candidates = Candidate::selectAllByPositionID($position['positionid']);
	foreach($candidates as $candidateid=>$candidate) {
		$candidates[$candidateid]['votes'] = Vote::countAllByCandidateID($candidate['candidateid']);
		$party = Party::select($candidate['partyid']);
		$candidates[$candidateid]['partydesc'] = $party['description'];
	}
	$positions[$key]['candidates'] = $candidates;
}

/* Final Assignment of Variables */
$this->assign(compact('positions'));

/* Output HTML */
$this->display();

?>