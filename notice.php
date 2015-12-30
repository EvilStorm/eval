<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	$query = "select * from notice order by id desc limit 1";
	
	$query_result = mysql_query($query)  or die(queryFail(701));
	
	$row = mysql_fetch_row($query_result, MYSQL_BOTH);

	success($row['id'], $row['notice']);
	
    function success($id, $notice){

    	if($id == null){
    		setResultCode(201);
    		setResultStr('정상리턴.');
    		flushOut();
    		return;	
    	}
		
		setResultCode(200);
		setResultInt('id', (int)$id);
		setResultValues('notice', $notice);
		setResultStr('정상리턴.');
		flushOut();	
	}
	
	function fail($errorCode){
		setResultCode($errorCode);
		setResultStr('공지사항을 가져오지 못했습니다.');
		flushOut();
	}	
	
?>