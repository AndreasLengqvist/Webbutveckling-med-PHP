<?php

namespace view;


class SentView{



	public function show(){


		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Quiz skickat! :D</h2>
						<p class='info'>Du kommer få resultaten från varje enskild spelare skickat till den mail du angav.</p>
						<p class='info'>Tack för att du valde qisus.</p>
					</div>
				";

		return $ret;
	}
}