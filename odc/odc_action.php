<?php
require_once("database.php");
require_once("odc_config.php");

function odc_delete($id){
	$sql = 'DELETE FROM odc WHERE id="'.$id.'";';
	
	my_query($sql);
	return;
}


function odc_set_markdown($id, $value=0){
	$markdown = 0;
	if($value > 0){ // be safe and prevent accidental misuse by using binary options
		$markdown = 1;
	}
	$sql = 'UPDATE odc SET markdown="'.$markdown.'" WHERE id="'.$id.'";';
	
	my_insert($sql);
	return;
}
?>


<?php
	// delete stubs from database or toggle markdown-flag
	
	if($_POST['action'] == "delete"){
		if($_POST['marked']){ // we have ids to work on
			// delete stubs
	
			$i = 0;
			
			while($_POST['marked'][$i]){
				odc_delete($_POST['marked'][$i]);
				echo "Deleting: ".$_POST['marked'][$i]."<br/>\n";
				$i++;
			}
		}
	}
	if($_POST['action'] == "markdown"){
		/*
			Handles enabling and disabling of markdown support for stubs		
		*/
		
		// this is necessary to ensure correct behaviour if no box was marked in the form
		if($_POST['marked']){ 
			$formvalues = $_POST['marked'];
		}else{
			$formvalues = array();
		}
		
		$all_ids = array();
		$sql = "SELECT id, markdown FROM odc WHERE TRUE;"; // actually markdown-state is not really needed
		$result = odc_my_query($sql);

		// strings to hold ids for sql-request
		$markdown_on = ""; 
		$markdown_off = "";
	
		// first write down all ids (and markdown states, though these are unused for now)	
		while($row = mysql_fetch_assoc($result)){
			$all_ids[$row['id']] = $row['markdown'];
		}
		// find all new states
		foreach ($all_ids as $key => $value)
		{
			if(in_array($key, $formvalues)){
				$markdown_on .= ",'".$key."'";
			}else{
				$markdown_off .= ",'".$key."'";				
			}
		}
		
		// remove trailing and leading ',' from strings and add brackets...
		$markdown_on	= "(".trim($markdown_on , ",").")";
		$markdown_off	= "(".trim($markdown_off, ",").")";
		// build the two actual	sql-queries
		$sql_on  = "UPDATE odc SET markdown='1' WHERE id IN ".$markdown_on;
		$sql_off = "UPDATE odc SET markdown='0' WHERE id IN ".$markdown_off;
		
		/*
		// some debug output
		echo "<pre>";
		print_r($all_ids);
		print_r($_POST['marked']);
		echo "On:\n".$markdown_on."\nOff:\n".$markdown_off."\n";
		echo $sql_on;
		echo $sql_off;
		echo "</pre>";
		*/
		
		// execute queries to set new states
		my_query($sql_on);
		my_query($sql_off);	
		
	}
	
?>

<p><a href="../<?=$GLOBALS['manage_link']?>">ODC Manage Content</a></p>