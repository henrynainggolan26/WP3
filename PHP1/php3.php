<?php
function even_odd($input){
	$return = '';
	if($input %2 == 0){
		$return = "$input is even <br/>";
	}
	else{
		$return = "$input is odd <br />";
	}
	return $return;
}
for ($i = 1; $i <= 100; $i++) {
    echo even_odd($i);
}
?>