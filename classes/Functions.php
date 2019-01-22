<?php

class Functions {

	public static function BubbleSort(array $score, array $name) {

	    $sorted = false;
	    while (false === $sorted) {

	        $sorted = true;

	        for ($count = 0; $count < count($score)-1; ++$count) {

	            $currentScore = $score[$count];
	            $currentName = $name[$count];
	            
	            $nextScore = $score[$count + 1];
	            $nextName = $name[$count + 1];

	            if ($nextScore > $currentScore) {

	                $score[$count] = $nextScore;
	                $name[$count] = $nextName;

	                $score[$count+1] = $currentScore;
	                $name[$count+1] = $currentName;

	                $sorted = false;
	            }

	        }

	    }

	    return array($score, $name);
	
	}

}