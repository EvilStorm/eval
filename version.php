<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	$query = "select * from version order by version desc limit 1";
	
	$query_result = mysql_query($query)  or die(queryFail(701));
	
	$row = mysql_fetch_row($query_result, MYSQL_BOTH);

	success($row['version'], $row['necessary']);
	
    function success($version, $necessary){
		setResultCode(200);
		setResultInt('version', (int)$version);
		setResultInt('necessary', (int)$necessary);
		setResultStr('정상리턴.');
		flushOut();	
	}
	
	function fail($errorCode){
		setResultCode($errorCode);
		setResultStr('버전정보를 가져오지 못했습니다.');
		flushOut();
	}	
	
?>