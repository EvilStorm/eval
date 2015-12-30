<!DOCTYPE HTML>
<head>
<title>Content 입력</title>
<style>
.text {width:400px; height:40px;}
</style>
</head>
<body>
<form action="input_content.php" method="post" >
Title : </br>
<input class="text" name="title" >
</br>
Content : </br>
<textarea name="content" cols="50" rows="6" > </textarea>
</br>
Type : </br>
<input class="text" name="type">
</br>
Image1 : </br>
<input class="text" name="img1">
</br>
Image2 : </br>
<input class="text" name="img2">
</br>
Image3 : </br>
<input class="text" name="img3">
</br>


<input type="submit" value="입력">

<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$type = $_POST['type'];
	
	$create_date = round(microtime(true) * 1000);

	$img1 = $_POST['img1'];
	$img2 = $_POST['img2'];
	$img3 = $_POST['img3'];
	
	if($title == null){
		return;
	}

	$query = "insert into contents(title, content, angel, create_date) values ('$title', '$content', $type, $create_date);";
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

	
	mysql_query("START TRANSACTION");
	if($content_index != 0){
		if($img1 != null){
			$query = "insert into images values($content_index, '$img1');";
			mysql_query("$query") or die(insertFail(701));	
		}
		if($img2 != null){
			$query = "insert into images values($content_index, '$img2');";
			mysql_query("$query") or die(insertFail(701));	
		}
		if($img3 != null){
			$query = "insert into images values($content_index, '$img3');";
			mysql_query("$query") or die(insertFail(701));	
		}
		
	}
    mysql_query("COMMIT");
    insertSuccess();
    
    function insertSuccess(){
    global $title;
    $title = null;
    
    print "성공";
	}
	
	function insertFail($errorCode){
	print "실패";
	}				 
?>
</form>
</body>
</html>