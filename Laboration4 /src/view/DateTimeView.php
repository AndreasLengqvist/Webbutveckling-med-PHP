<?php

namespace view;


class DateTimeView{

	// Datum och tid-funktion. (Kan brytas ut till en hjälpfunktion.)
	public function show(){
		date_default_timezone_set('Europe/Stockholm');
		setlocale(LC_ALL, 'sv_SE');
		$weekday = ucfirst(utf8_encode(strftime("%A")));
		$date = strftime("%d");
		$month = strftime("%B");
		$year = strftime("%Y");
		$time = strftime("[%H:%M:%S]");
		return "<p>" . $weekday . ", den " . $date . " " . $month . " år " . $year . ". Klockan är " . $time . "</p>";	
	}
}