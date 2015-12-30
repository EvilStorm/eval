<?php
	define('NL', "<br>\n");
	function input_korea($word){
		return iconv("UTF-8", "CP949", $word);
	}

	function str_count($str){
 		$kChar = 0;
 		for( $i = 0 ; $i < strlen($str) ;$i++){
  			$lastChar = ord($str[$i]);
  			if($lastChar >= 127){
   				$i= $i+2;
  			}
  			$kChar++;
 		}
 		return $kChar;
	}
	
?>