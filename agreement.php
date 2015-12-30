<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	$query = "select * from agreement order by id desc limit 1";
	
	$query_result = mysql_query($query)  or die(queryFail(701));
	
	$row = mysql_fetch_row($query_result, MYSQL_BOTH);

	success($row['id'], $row['agreement']);
	
    function success($id, $agreement){
		setResultCode(200);
		setResultInt('id', (int)$id);
		setResultValues('agreement', $agreement);
		setResultStr('정상리턴.');
		flushOut();	
	}
	
	function fail($errorCode){
		setResultCode($errorCode);
		setResultStr('버전정보를 가져오지 못했습니다.');
		flushOut();
	}	
	
?>