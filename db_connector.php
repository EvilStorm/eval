<?php
/*  	
  	$db_host = "mysql5.hosting.bizfree.kr";
  	$db_name = "hoseomobile_db";
  	$db_user = "hoseomobile";
  	$db_password = "kilho3050";
*/
  	$db_host = "localhost";
  	$db_name = "evaluation";
  	$db_user = "root";
  	$db_password = "serVice1!";

	$conn = mysql_connect($db_host, $db_user, $db_password);

if($conn){
	echo " DB CONNECT SUCCESS " ;
}else{
	echo " DB CONNECT FAIL ";
}


	$result = mysql_select_db($db_name, $conn);
	mysql_query(" set names utf8 "); 
	
	function closeConn(){
		mysql_close();	
	}
		
?>