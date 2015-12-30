<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	$content_id = $_GET['id'];
	$comment = $_GET['comment'];
	$create_date = round(microtime(true) * 1000);
			

	$query = "insert into comments(id, comment, create_date) values ('$content_id', '$comment', $create_date);";
	
	syslog(LOG_NOTICE, " query : " . $query). NL;
	mysql_query($query)  or die(queryFail(701));
	
	
	insertSuccess();
	
    function insertSuccess(){
		setResultCode(200);
		setResultStr('정상적으로 등록되었습니다.');
		flushOut();	
	}
	
	function insertFail($errorCode){
		setResultCode($errorCode);
		setResultStr('댓글 등록이 실패 했습니다.');
		flushOut();
	}	
	
?>