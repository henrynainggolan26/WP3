<?php
function even_odd($input){
	$return = '';
	if($input %2 == 0){
		echo "even";
	}
	else{
		echo "odd";
	}
	return $return;
}
even_odd(2)
?>