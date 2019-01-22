<?php

class Sorts {

	public static function BubbleSort(array $score, array $name) {

	    $finished = false;

	    while (false === $finished) {

	        $finished = true;
	        for ($pointer = 0; $pointer < count($score)-1; ++$pointer) {

	            $currentScore = $score[$pointer];
	            $currentName = $name[$pointer];
	            
	            $nextScore = $score[$pointer + 1];
	            $nextName = $name[$pointer + 1];

	            if ($nextScore > $currentScore) {

	                $score[$pointer] = $nextScore;
	                $name[$pointer] = $nextName;

	                $score[$pointer+1] = $currentScore;
	                $name[$pointer+1] = $currentName;

	                $finished = false;
	            }

	        }

	    }

	    return array($score, $name);
	}
	//bubble sort, sorts two arrays in descending order
}