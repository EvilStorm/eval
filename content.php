<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
		
	define('BOTH', 0);
	define('ANGEL', 1);
	define('EVIL', 2);
	
	$uploads_dir = './img/';
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$angel = $_POST['angel'];
	$create_date = round(microtime(true) * 1000);

	$array_count = count($_FILES["img"]["name"]);
	$uploadfiles = array();
	
	 syslog(LOG_NOTICE, " TITLE : " . $title);
	 syslog(LOG_NOTICE, " Content : " . $content);
	 syslog(LOG_NOTICE, " create_date : " . $create_date);
	 

	$query = "insert into contents(title, content, angel, create_date) values ('$title', '$content', $angel, $create_date);";
	mysql_query($query)  or die(queryFail(444));
	
	syslog(LOG_NOTICE, " Query : " . $query);
	
	$query = "select id from contents where create_date = $create_date;";
	$query_result = mysql_query($query)  or die(insertFail(701));
	$content_index = 0;
	if(mysql_num_rows($query_result) == 1){
		while($row = mysql_fetch_array($query_result)){
			$content_index = $row['id'];
		}
	}

syslog(LOG_NOTICE, " Index : " . $content_index);

	for($i=0; $i<$array_count; $i++){
		if(empty($_FILES["img"]["name"][$i])){
		 	continue;
		 }
		
		$uploadfile = $uploads_dir . $_FILES["img"]["name"][$i];
		$uploadfiles[$i] = $uploads_dir . $create_date . "_$i" . substr($uploadfile, strrpos($uploadfile, "."));

		$fileTmp = $_FILES["img"]["tmp_name"][$i]; 
		if (move_uploaded_file($fileTmp, $uploadfiles[$i])) {
		} else {
			syslog(LOG_NOTICE, " Insert Fail : " . $title);
			insertFail(702);
		}
	}
	
	mysql_query("START TRANSACTION");
	if($content_index != 0){
		foreach($uploadfiles as $key => $value){
			$query = "insert into images values($content_index, '$value');";
			mysql_query("$query") or die(insertFail(701));	
		}
	}
    mysql_query("COMMIT");
    syslog(LOG_NOTICE, " SUCCESS!!! ");
    insertSuccess();
    
    
    function insertSuccess(){
    syslog(LOG_NOTICE, " 정상적으로 등록되었습니다.");
		setResultCode(200);
		setResultStr('정상적으로 등록되었습니다.');
		flushOut();	
	}
	
	function insertFail($errorCode){
	syslog(LOG_NOTICE, " 계시글 등록이 실패 했습니다. : " . $errorCode);
		setResultCode($errorCode);
		setResultStr('계시글 등록이 실패 했습니다.');
		flushOut();
	}	
    
?>