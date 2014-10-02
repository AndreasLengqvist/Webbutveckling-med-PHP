<?php



class DateTimeView{


	// Datum och tid-funktion. (Kan brytas ut till en hjälpfunktion.)
	public function show(){
		date_default_timezone_set('Europe/Stockholm');
		setlocale(LC_ALL, 'sv_SE');
		$weekday = ucfirst(utf8_encode(strftime("%A,")));
		$date = strftime("den %d");
		$month = strftime("%B");
		$year = strftime("år %Y.");
		$time = strftime("Klockan är [%H:%M:%S].");
		return "<p>$weekday $date $month  $year  $time</p>";	
	}
}