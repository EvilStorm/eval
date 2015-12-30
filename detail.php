<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	$id = $_GET['id'];

	$query = "select * from comments where id = $id order by create_date desc";
	
	$query_result = mysql_query($query)  or die(queryFail(701));
	
	$return_array = array();
	while($row = mysql_fetch_array($query_result, MYSQL_BOTH)){
		$row_array['id'] = $row['id'];
		$row_array['comment'] = urlencode($row['comment']);
		$row_array['create_date'] = $row['create_date'];
		
		array_push($return_array, $row_array);
	}
	setResultArray('comments', $return_array);
			
	success();
	
    function success(){
		setResultCode(200);
		setResultStr('정상리턴.');
		flushOut();	
	}
	
	function fail($errorCode){
		setResultCode($errorCode);
		setResultStr('리스트를 가져오지 못했습니다.');
		flushOut();
	}	
	
?>