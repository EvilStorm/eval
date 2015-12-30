<?php

	include('string_utils.php');
	include('db_connector.php');
	include('json_return.php');
	
	define(ONE_PAGE_LIST_ITEM, 20);
	
	define('BOTH', 0);
	define('ANGEL', 1);
	define('EVIL', 2);
	
	define('NEWUP', 1);
	define('MORE', 2);
	
	$last_id = $_GET['last_id'];
	$search_target = $_GET['search_target'];
	$search_word = $_GET['search_word'];
	
	$start_offset = $last_id;
	$end_offset = $last_id - ONE_PAGE_LIST_ITEM;
	if($end_offset < 0){
		$end_offset = 1;
	}
	
	$arrWords = split(',', $search_word);
	$words_size = sizeof($arrWords);
	
	$item_count = $_GET['item_count'];
	if($item_count == 0){
		$item_count = 20;
	}

	$is_more = (int)$_GET['is_more'];
	
	$query = "select c.id as id, c.title as title,c.angel as type, c.content as content, c.create_date as create_date, i.file_name as file_name ";
	$query = $query . " from contents as c left outer join images as i on c.id = i.id  ";
	$query = $query . " where c.id > 0 ";


	if($last_id != 0){
		if($is_more == NEWUP){
			$query = $query . " and c.id > $last_id ";
		}else if($is_more == MORE){
			$query = $query . " and c.id < $last_id and c.id > $end_offset ";
			
		}
	}
	
	if($search_target != BOTH){
		$query = $query . " and c.angel = $search_target ";
	}

	if(str_count($search_word) > 0){
		for($i=0; $i<$words_size; $i++){
			$query = $query . " and c.title like '%$arrWords[$i]%'";
		}
	}
	
	$query = $query . " order by c.id desc ";

	$query_result = mysql_query($query)  or die(queryFail(701));
	
	$return_array = array();
	$return_img_array = array();
	$prev_id = 0;
	$image_count = 0;
	
	if( mysql_num_rows($query_result) > 0 ){
		while($row = mysql_fetch_array($query_result, MYSQL_BOTH)){
	
			if(($prev_id != 0) && ($prev_id != $row['id'])){
				$image_count = 0;
				if(count($return_img_array) > 0){
					$row_array['images'] = $return_img_array;
				}
				array_push($return_array, $row_array);
				unset($return_img_array);
				unset($row_array);
				$return_img_array = array();
			}
			
			$row_array['id'] = (int)$row['id'];
			$row_array['title'] = urlencode($row['title']);
			$row_array['content'] = urlencode(str_replace('"','\"',$row['content']));
			$row_array['type'] = (int)$row['type'];
			$row_array['create_date'] = (int)$row['create_date'];
			
			if($row['file_name'] != null){
				$return_img_array["$image_count"] = $row['file_name'];
			}	
			
			$image_count++;		
			$prev_id =  $row['id'];
		}
			if(count($return_img_array) > 0){
				$row_array['images'] = $return_img_array;
			}
			array_push($return_array, $row_array);	
	}
	
	
	setResultArray('userlist', $return_array);
	success();
	
	function getRowStartOffest($page_index){
		return (ONE_PAGE_LIST_ITEM * ($page_index - 1)) +1;
	}
	
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