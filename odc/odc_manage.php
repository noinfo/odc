<?php
require_once("database.php");
require_once("odc_config.php");

function odc_new($request_tag="default"){
	$tag = strtolower($request_tag);
	$page = strtolower($_SERVER['SCRIPT_NAME']);

	$sql = 'INSERT INTO odc (tag,page) VALUES ("'.$tag.'","'.$page.'");';

	my_insert($sql);
	return;
}

function odc_list($tabletags=""){
	// get config options from odc_config.php
	$basedir 			= $GLOBALS['basedir'];
	$deletable 			= $GLOBALS['deletable'];
	$editlink 			= $GLOBALS['edit_link'];
	$odc_dir			= $GLOBALS['odc_dir'];
	$enable_markdown	= $GLOBALS['enable_markdown'];

	// now get the content from the database...
	$sql = 'SELECT id,tag,markdown,page,content FROM odc WHERE 1 ORDER BY page;';
	//echo $sql;	
	$rows = odc_my_query($sql);

	if($deletable){
		$html_table = "<form name=\"delete_stubs\" action=\"".$odc_dir."odc_action.php\" method=\"POST\">";
	}

	$html_table = $html_table."<table ".$tabletags.">
	<tr><th>page</th><th>tag</th>";
	
	if($enable_markdown){
		$html_table = $html_table."<th title=\"markdown\">md</th>";
	}
	
	$html_table = $html_table."<th>content</th><th>options</th>";	

	if($deletable){
		$html_table = $html_table."<th><select name=\"action\" id=\"action\">
			<option value=\"\" selected>action</option>	
			<option value=\"delete\">delete</option>";
			if($enable_markdown){
				$html_table = $html_table."<option value=\"markdown\">markdown</option>";
			}
		$html_table = $html_table."</select></th>";
	}
	$html_table = $html_table."</tr>";

	while ($onerow = mysql_fetch_assoc($rows)){
		if($onerow['page'] == "any"){ // do not link to "any"-page content...
			$html_table = $html_table."\n\t<tr><td>".$onerow['page']."</td><td>".$onerow['tag']."</td>";
		}else{
			$html_table = $html_table."\n\t<tr><td><a href=\"".$basedir.$onerow['page']."\">".$onerow['page']."</a></td><td>".$onerow['tag']."</td>";
		}
		if($enable_markdown){
			$html_table = $html_table.'<td><input type="radio" name="markdown_'.$onerow['id'].'" title="markdown status for '.$onerow['tag'].'" ';
			if($onerow['markdown'] > 0){
				$html_table = $html_table.' checked ';	
			}
			$html_table = $html_table.'disabled></td>';
		}
		// special handling of content (do not display...)
		if(empty($onerow['content'])){
			$html_table = $html_table."<td>empty</td>";
		}else{
			$html_table = $html_table."<td>".strlen($onerow['content'])." characters</td>";
		}
		
		// display the edit button
		$html_table = $html_table.'<td><a href="'.$editlink.'?id='.$onerow['id'].'"><button>edit</button></a></td>';
		
		// display the mark if deletable
		if($deletable){
			$html_table = $html_table.'<td><input type="checkbox" name="marked[]" value="'.$onerow['id'].'" title="'.$onerow['tag'].'"></td>';
		}	
		// end tablerow
		$html_table = $html_table."</tr>";
	}
	if($deletable){
		$html_table = $html_table."\n<tr><td colspan=\"6\" align=\"right\"><input type=\"submit\" value=\"perform action\" ".'onClick="return confirm(\'Are you sure you want to perform the action on the marked content?\');"/></td>';
	}
	$html_table = $html_table."\n</table>\n</form>";



	return $html_table;
}

?>