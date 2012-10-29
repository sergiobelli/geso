<?php


	function randomAlphaNum($length){ 

		//echo "\nlenght = ".$length;
		
		$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
		//echo "\nrangeMin = ".$rangeMin;
		
		$rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
		//echo "\nrangeMax = ".$rangeMax;
		
		$base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
		//echo "\nbase10Rand = ".$base10Rand;
		
		$newRand = base_convert($base10Rand, 10, 36); //convert it 
		//echo "\nnewRand = ".$newRand;
		
		return $newRand; //spit it out 

	} 


		$a = randomAlphaNum(5);
		$b = randomAlphaNum(5);
		$c = randomAlphaNum(5);
		$codice = $a . $b . $c;
		
echo "\n result = ".$codice;

?>
