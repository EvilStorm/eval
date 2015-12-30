<?php
	include('string_utils.php');
	
  	$db_host = "localhost";
  	$db_name = "evaluation";
  	$db_user = "root";
  	$db_password = "serVice1!!";
  	
  	$conn = mysql_connect($db_host, $db_user, $db_password);

	echo " CONNECT : " . $conn;

	$result = mysql_select_db($db_name, $conn);

	echo " CONNECT RESULT : " . $result;

agreement();
notice();
version();
contents();
comments();
images();

	function agreement(){
		$query = "create table agreement( ";
		$query = $query . "id int not null auto_increment primary key, ";
		$query = $query . "agreement text not null);";
		
		echo $query . NL;
		mysql_query($query);
	}
	
	function notice(){
		$query = "create table notice( ";
		$query = $query . "id int not null auto_increment primary key, ";
		$query = $query . "notice text not null);";
		
		echo $query . NL;
		mysql_query($query);
	}

	function version(){
		$query = "create table version( ";
		$query = $query . "version int, ";
		$query = $query . "necessary int);";

		echo $query . NL;
		mysql_query($query);
	}
	
	function contents(){
		$query = "create table contents( ";
		$query = $query . "id int unsigned not null auto_increment primary key, ";
		$query = $query . "title varchar(100) not null, ";
		$query = $query . "content varchar(255) not null, ";
		$query = $query . "angel int not null, ";
		$query = $query . "create_date long not null, ";
		$query = $query . "index(title));";

		echo $query . NL;
		mysql_query($query);
	}
	
	
	function comments(){
		$query = "create table comments( ";
		$query = $query . "id int unsigned not null, ";
		$query = $query . "comment varchar(255) not null, ";
		$query = $query . "create_date long not null, ";
		$query = $query . "index(id));";
		echo $query . NL;
		mysql_query($query);
	}
	function images(){
		$query = "create table images( ";
		$query = $query . "id int unsigned not null, ";
		$query = $query . "file_name varchar(255) not null,";
		$query = $query . "index(id));";
		
		
		echo $query . NL;
		mysql_query($query);
	}
?>