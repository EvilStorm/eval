<?php
	define('RESULT_CODE', 'result_code');
	define('RESULT_STR', 'result_str');
		
	 $return = array();
	
	function setResultCode($value){
		global $return;
		
		$return[RESULT_CODE] = $value;		
	}
	
	function setResultStr($value){
		global $return;
		
		$return[RESULT_STR] = urlencode($value);				
	}
	function setResultInt($key, $value){
		global $return;
		
		$return[$key] = $value;		
	}
	function setResultValues($key, $value){
		global $return;
		
		$return[$key] = urlencode($value);		
	}
	function setResultArray($key, $value){
		global $return;
		
		$return[$key] = $value;		
	}

	function decodeResult(){
		global $return;
		
		$json_result = json_encode($return);
		$json_result = urldecode($json_result);
		
		echo $json_result;
	}
	
	function flushOut(){
		echo decodeResult();	
	}


	
?>