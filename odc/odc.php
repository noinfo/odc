<?php
require_once("database.php");

// background function to create new content; used by the wrappers
function odc_new_content($request_tag="default", $anypage=FALSE){
	$tag = strtolower($request_tag);
	$page = strtolower($_SERVER['SCRIPT_NAME']);

	if($anypage){
		$sql = 'INSERT INTO odc (tag,page) VALUES ("'.$tag.'","any");';
	}else{
		$sql = 'INSERT INTO odc (tag,page) VALUES ("'.$tag.'","'.$page.'");';	
	}
	
	my_insert($sql);
	return;
}

// wrapper to create new "anypage" content
function odc_new_anypage($request_tag="default"){
	return (odc_new_content($request_tag,TRUE));
}

// wrapper to create new content
function odc_new($request_tag="default"){
	return (odc_new_content($request_tag,FALSE));
}


// background function to display content; used by the wrappers
function odc_display_content($request_tag="default", $anypage=FALSE){

	$tag = strtolower($request_tag);
	$page = strtolower($_SERVER['SCRIPT_NAME']);
	
	// now check for/get content from the database...
	if($anypage){
		$sql = 'SELECT content,markdown FROM odc WHERE tag="'.$tag.'" AND page="any";';
	}else{
		$sql = 'SELECT content,markdown FROM odc WHERE tag="'.$tag.'" AND page="'.$page.'";';
	}
	$rows = odc_my_query($sql);
	$content = mysql_fetch_assoc($rows);

	if(empty($content)){
		// call function to create new content-stub if there is none
		odc_new($tag,$anypage);
	}else{
		// print out content 
		if($content['markdown'] > 0){
			require_once($GLOBALS['MD_file']);
			echo markdown($content['content']);
		}else{
			echo $content['content'];
		}
	}
	
	// just for debugging, return nothing normally...
	//return "Tag: ".$tag." Page: ".$page;
	
	return;
}

// wrapper to display normal content
function odc_display($request_tag="default"){
	return (odc_display_content($request_tag,FALSE));
}


// wrapper to display "anypage" content
function odc_display_anypage($request_tag="default"){
	return (odc_display_content($request_tag,TRUE));
}


?>