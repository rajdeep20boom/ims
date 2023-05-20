<?php

const NORTH = 1;
const EAST = 2;
const SOUTH = 3;
const WEST = 4;

$direction = [ 1 => "NORTH", 2 => "EAST", 3 => "SOUTH", 4 => "WEST"];

const MULTIPLIER_1 = 1;
const MULTIPLIER_2 = 1;
const MULTIPLIER_3 = -1;
const MULTIPLIER_4 = -1;

$x = $argv[1];
$y = $argv[2];

if(!is_numeric($x) || !is_numeric($y)){
	die("\nCo-ordinates must be Integer\n");
}

$currentDirection = $argv[3];

if($currentDirection != 'NORTH' && $currentDirection != 'EAST' && $currentDirection != 'SOUTH' && $currentDirection != 'WEST'){
	 die("\nWrong Direction\n");
}

$currentDirectionNumber = constant($currentDirection);
$path = $argv[4];

for($i = 0; $i < strlen($path); $i++ ){

	switch($path{$i}){
		case 'R':
			if($currentDirectionNumber == 4){
				$currentDirectionNumber = 1;
			} else {
				$currentDirectionNumber++;
			}
			break;
                case 'L':
                        if($currentDirectionNumber == 1){
                                $currentDirectionNumber = 4;
                        } else {
                                $currentDirectionNumber--;
                        }
                        break;
                case 'W':
			if( !($currentDirectionNumber % 2) ){
				$x += ($path{$i+1} * constant("MULTIPLIER_".$currentDirectionNumber) );
			} else {
				$y += ($path{$i+1} * constant("MULTIPLIER_".$currentDirectionNumber) );
			}
			$i++;
                        break;
		default:
			if(is_numeric($path{$i})){
				echo "\nNumber should be associated with 'W' walk ranging from 0 - 9\n";
			} else {
				echo "\nProvided char '".$path{$i}."' is not valid\n";
			}
			break;
	}

}

echo $x." ".$y." ".$direction[$currentDirectionNumber]."\n";

?>