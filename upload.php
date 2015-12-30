<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	syslog(LOG_NOTICE, "UPLOAD!!!");

	$uploads_dir = './img/';
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$create_date = $_POST['create_date'];

	$array_count = count($_FILES["img"]["name"]);
	$uploadfiles = array();
	
	
	
	for($i=0; $i<$array_count; $i++){
		if(empty($_FILES["img"]["name"][$i])){
				
		 	continue;
		 }
		
		$uploadfile = $uploads_dir . $_FILES["img"]["name"][$i];

		$uploadfiles[$i] = $uploads_dir . $create_date . "_$i" . substr($uploadfile, strrpos($uploadfile, "."));

		$fileTmp = $_FILES["img"]["tmp_name"][$i]; 
		if (move_uploaded_file($fileTmp, $uploadfiles[$i])) {
		    syslog(LOG_NOTICE, " success.");
		} else {
		    syslog(LOG_NOTICE, " fail!");
		}
	}

	$query = "insert into contents(title, content, create_date) values ('$title', '$content', $create_date);";
	syslog(LOG_NOTICE, "query : " . $query);
	mysql_query($query)  or die(queryFail(444));
	
	$query = "select id from contents where create_date = $create_date;";
	$query_result = mysql_query($query)  or die(queryFail(444));
	$content_index = 0;
	if(mysql_num_rows($query_result) == 1){
		while($row = mysql_fetch_array($query_result)){
			$content_index = $row['id'];
		}
	}
	syslog(LOG_NOTICE,  "Upload index : " . $content_index);

	mysql_query("START TRANSACTION");
	if($content_index != 0){
	foreach($uploadfiles as $key => $value){
		syslog(LOG_NOTICE,  $value . "</br>");
		$query = "insert into images values($content_index, '$value');";
		syslog(LOG_NOTICE, "query : " . $query);
		mysql_query("$query");	
		
	}
	}
    mysql_query("COMMIT");
?>