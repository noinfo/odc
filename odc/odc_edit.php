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

function odc_update($id, $content){
	$insert_content = addslashes($content);
	$sql = 'UPDATE odc SET content="'.$insert_content.'" WHERE id="'.$id.'";';
	
	my_insert($sql);
	return;
}

function odc_edit($id){
	
	$sql = 'SELECT tag,page,markdown,content FROM odc WHERE id="'.$id.'";';
	$rows = odc_my_query($sql);
	$onerow = mysql_fetch_assoc($rows);

	?>
<!-- HTML part -->	
<p>
Editing tag "<?=$onerow['tag']?>" on page <?=$onerow['page']?>.
</p>
<div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	<input type="hidden" name="id" value="<?=$id?>"/>
<textarea name="content" rows="25" cols="95">
<?=$onerow['content']?>
</textarea>

	<input type="submit" value="   save   "/>
</form>
</div>
<?
	// disable nicedit if simple-flag is set in odc_config or if content is markdown
	if(!$GLOBALS["simple_text_area"] && $onerow['markdown'] < 1){
?>
<!-- nicedit begin -->
<div>
<script type="text/javascript" src="<?=$GLOBALS['NCE_script_path']?>"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas(<?=$GLOBALS['NCE_editor_options']?>)});
</script>
</div>
<!-- nicedit end, html part end -->
<?php }
	return;
} // end of odc_edit()
?>


<?php
	// provide update & loading functionality by calling the functions above
	if($_POST['id'] && $_POST['content']){
		// do an update
		odc_update($_POST['id'], $_POST['content']);
	}

	$id = $_GET['id'];
	if(empty($id)){
	 	$id = $_POST['id'];
	}
?>